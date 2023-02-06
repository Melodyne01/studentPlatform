<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Work;
use App\Entity\Event;
use App\Entity\Notes;
use App\Form\NoteType;
use App\Form\WorkType;
use App\Entity\Courses;
use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\UserRepository;
use App\Entity\NotesPropertySearch;
use App\Repository\EventRepository;
use App\Repository\NotesRepository;
use App\Entity\RegistrationToCourse;
use App\Form\NotesPropertySearchType;
use App\Repository\CoursesRepository;
use App\Repository\MessageRepository;
use App\Form\RegistrationToCourseType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RegistrationToCourseRepository;
use App\Repository\WorkRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Controller extends AbstractController
{

     /**
     * @Route("/", name="index")
     * 
     */
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('connection');
        }

        return $this->render('index.html.twig');
    }

    /**
     * @Route("/dashboard/{username}", name="dashboard")
     */
    public function dashboard(Request $request, User $user, NotesRepository $noteRepo): Response
    {
        if (!$user) {
            return $this->render('error/error404.html.twig');
        }
        $search = new NotesPropertySearch();

        $searchForm = $this->createForm(NotesPropertySearchType::class, $search);

        $searchForm->handleRequest($request);

        //Récupère les notes de l'étudiant dans la base de données en tenant de l'application ou non du filtre
        $notes = $noteRepo->findNotesBySearch($user, $search);
        //Tableau contenant les cours 
        $noteCourse = [];
        //Tableau contenant les note
        $noteNote = [];
        //Tableau contenant les couleurs des colonnes
        $noteColor = [];
        //Variables permettant de cacluler la moyenne des notes sélectionnées
        $totalNote = 0;
        $nbrNotes = 0;
        $mediumNote = 0;
        //Répartition des valeurs dans les bons tableaux
        foreach ($notes as $note) {
            //Cours
            $noteCourse[] = $note->getCourse();
            //Note
            $noteNote[] = $note->getNote();
            //Couleurs
            if ($note->getNote() < 10){
                //Note en dessous de la moyenne 
                $noteColor[] = "darkred";
            }else{
                //Note au dessus de la moyenne
                $noteColor[] = "#132d46";
            }
            //Addition des valeurs des notes
            $totalNote += $note->getNote();
            //Calcul du nombre de note
            $nbrNotes ++;
        }
        //S'il y'a au moins une note
        if ($nbrNotes > 0){
            //Calcul de la moyenne
            $mediumNote = $totalNote / $nbrNotes;
        }

    return $this->render('student/dashboard.html.twig',[
        'controller_name' => 'Dashboard',
        'user' => $user->getUsername(),
        //Revoie des différent tableau pour qu'ils soient utilisable dans le fichier twig
        'noteCourse' => json_encode($noteCourse),
        'noteNote' => json_encode($noteNote),
        'noteColor' => json_encode($noteColor),
        'notes' => $notes,
        'searchForm' => $searchForm->createView(),
        'mediumNote' => $mediumNote,


    ]
        );   
    }
    
    /**
     * @Route("/addNote", name="addNote")
     */
    public function addNotes(Request $request, ManagerRegistry $manager, NotesRepository $repo)
    {
        if (!$this->getUser()) {
            return $this->render('error/error404.html.twig');
        }
        
        $note = new Notes();

        $form = $this->createForm(NoteType::class, $note);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $note->setAddedBy($this->getUser()->getUsername());
            $manager->getManager()->persist($note);
            $manager->getManager()->flush();
            $this->addFlash("success", "New note added");
            return $this->redirectToRoute('addNote');
            
        }
        return $this->render('teacher/addNote.html.twig', [
            'controller_name' => 'AddNote',
            'notes' => $repo->findByTeacher($this->getUser()->getUsername()),
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/registrationToCourse", name="registrationToCourse")
     */
    public function registrationToCourse(Request $request, ManagerRegistry $manager, RegistrationToCourseRepository $repo, ?Courses $course, CoursesRepository $courseRepo)
    {
        $course = null;
        $regist = new RegistrationToCourse();

        $form = $this->createForm(RegistrationToCourseType::class, $regist);

        $form->handleRequest($request);

        //Récuperation du cours dans la table "courses"
        $course = $courseRepo->findOneByName($regist->getCourse());        

        //Vérifie si le formulaire est soumis (Si le bouton "register" est pressé)
        if($form->isSubmitted() && $form->isValid()){

            $regist->setStudent($this->getUser()->getUsername());

            $manager->getManager()->persist($regist);

            //Comparasion de la clé du cours et de la clés entrée par l'étudiant
            if ($course->getCourseKey() != $regist->getCourseKey()){
                //Afficher ce message si les deux champs ne sont pas égaux
                $this->addFlash("danger", "Wrong key" );
                return $this->redirectToRoute('registrationToCourse');
            }
            //Ligne permettant l'integration de la nouvelle inscription dans la base de données
            $manager->getManager()->flush();
            //Affiche ce message si les deux champs sont égaux
            $this->addFlash("success", "You are registered" );
            return $this->redirectToRoute('registrationToCourse');
            
        }
        return $this->render('student/registrationToCourse.html.twig', [
            'controller_name' => 'My courses',
            'regists' => $repo->findByCurrentUser($this->getUser()->getUsername()),
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/message", name="message")
     */
    public function message(MessageRepository $messageRepo)
    {
        
        $received = $messageRepo->findByReceived($this->getUser()->getUsername());
        
        return $this->render('student/message.html.twig', [
            'controller_name' => 'Messages',
            'receivedMessages' => $received,
        ]);
    }
    /**
     * @Route("/createConveration", name="createConveration")
     */
    public function createConveration(Request $request, ManagerRegistry $manager)
    {
        
        $message = new Message();

        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $message->setSender($this->getUser()->getUsername());
            $message->setSentAt(new Datetime());
            $manager->getManager()->persist($message);

            $manager->getManager()->flush();
            $this->addFlash("success", "Message send" );
            return $this->redirectToRoute('message');
            
        }
        
        return $this->render('student/createConversation.html.twig', [
            'controller_name' => 'Start a new conversation',
            'form' => $form->createView()

        ]);
    }
    /**
     * @Route("/conversation/{username}", name="conversation")
     */
    public function conversation(User $user, MessageRepository $messageRepo, Request $request, ManagerRegistry $manager)
    {
        $messages = $messageRepo->findAllByCurentUser($user->getUsername(), $this->getUser()->getUsername());

        $message = new Message();

        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);
        
        $message->setSender($this->getUser()->getUsername());
        $message->setReceiver($user->getUsername());
        $message->setSentAt(new Datetime());

        if($form->isSubmitted() && $form->isValid()){
            $manager->getManager()->persist($message);

            $manager->getManager()->flush();
            return $this->redirectToRoute('conversation', [
                'username'=> $user->getUsername()
            ]);
        }
        return $this->render('student/conversation.html.twig', [
            'messages' => $messages,
            'form' => $form->createView(),
            'conversationWithFirstName' => $user->getFirstName(),
            'conversationWithLastName' => $user->getLastName(),
        ]);
    }

    /**
     * @Route("/addEvent", name="addEvent")
     */
    public function addEvent(Request $request, WorkRepository $workRepo, ManagerRegistry $manager)
    {
        $works = $workRepo->findAllByCurrentUser($this->getUser()->getUsername());

        $work = new Work();

        $form = $this->createForm(WorkType::class, $work);
        $work->setAddedBy($this->getUser()->getUsername());

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $manager->getManager()->persist($work);

            $manager->getManager()->flush();
            return $this->redirectToRoute('addEvent');
        }
       
        return $this->render('teacher/addEvent.html.twig', [
            'controller_name' => 'Event',
            'form' => $form->createView(),
            'works' =>$works,
        ]);
    }

    /**
     * @Route("/showEvents", name="showEvents")
     */
    public function showEvents(Request $request, WorkRepository $workRepo, ManagerRegistry $manager)
    {
        $works = $workRepo->findAllByCurrentUser($this->getUser()->getUsername());
       
        return $this->render('teacher/addEvent.html.twig', [
            'controller_name' => 'Show Event',
            'works' =>$works,
        ]);
    }
            
}
