<?php

namespace App\Controller;

use App\Entity\UE;
use App\Entity\User;
use App\Form\UeType;
use App\Form\EditType;
use App\Entity\Courses;
use App\Form\CourseType;
use App\Form\RelationType;
use App\Form\RegistrationType;
use App\Repository\UERepository;
use App\Entity\UserPropertySearch;
use App\Repository\UserRepository;
use App\Entity\AssocTeacherCourses;
use App\Entity\ClassPropertySearch;
use App\Entity\NotesPropertySearch;
use App\Repository\NotesRepository;
use App\Form\UserPropertySearchType;
use App\Form\ClassPropertySearchType;
use App\Form\NotesPropertySearchType;
use App\Repository\CoursesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\String\UnicodeString;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AssocTeacherCoursesRepository;
use App\Repository\RegistrationToCourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/registration", name="registration")
     */
    public function registration(Request $request, ManagerRegistry $manager, UserPasswordEncoderInterface $encoder, UserRepository $userRepo)
    {
        
        $user = new User();
        $search = new UserPropertySearch();

        $form = $this->createForm(RegistrationType::class, $user);
        $searchForm = $this->createForm(UserPropertySearchType::class, $search);


        $form->handleRequest($request);
        $searchForm->handleRequest($request);

        $userlist = $userRepo->findAllAsc($search);

        if($form->isSubmitted() && $form->isValid()){
            
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $manager->getManager()->persist($user);
            
            //Teste si il s'agit d'un étudiant
            //Sinon la class est automatiquement 'NONE'
            if($user->getType() != 'ROLE_USER'){
                $user->setClass('NONE');
            }
            $username = (new UnicodeString())
                ->append(substr($user->getFirstName(),0,1))
                ->append($user->getLastName());

            $user->setUsername(strtolower($username));

            $email = (new UnicodeString())
                ->append($user->getFirstName())
                ->append('.')
                ->append($user->getLastName())
                ->append('@projetWeb.com');

            $user->setEmail($email);

            $manager->getManager()->flush();
            $this->addFlash("success", "New account created");
            return $this->redirectToRoute('registration');
        }

        return $this->render('admin/registration.html.twig', [
            'controller_name' => 'Registration',
            'form' => $form->createView(),
            'searchForm' => $searchForm->createView(),
            'userlist' => $userlist

        ]);
    }
    /**
     * @Route("/admin/relation", name="relation")
     */
    public function relation(Request $request, ManagerRegistry $manager, AssocTeacherCoursesRepository $assocrepo): Response
    {
        $relation = new AssocTeacherCourses();

        $form = $this->createForm(RelationType::class, $relation);

        $form->handleRequest($request);
        

        if($form->isSubmitted() && $form->isValid()){
            
            $manager->getManager()->persist($relation);

            $manager->getManager()->flush();
            $this->addFlash("success", "Relation uptaded");
            return $this->redirectToRoute('relation');
            
        }
        return $this->render('admin/relation.html.twig', [
            'controller_name' => 'Relation',
            'products' => $assocrepo->findAllAsc(),
            'form' => $form->createView()

        ]);
    }
    /**
     * @Route("/admin/addUE", name="addUE")
     */
    public function addUE(Request $request, ManagerRegistry $manager, UERepository $uerepo): Response
    {
        $ue = new UE();

        $form = $this->createForm(UeType::class, $ue);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $manager->getManager()->persist($ue);
            $ue->setName(strtoupper($ue->getName()));

            $manager->getManager()->flush();
            $this->addFlash("success", "New UE added");
            return $this->redirectToRoute('addUE');
            
        }
        return $this->render('admin/addUE.html.twig', [
            'controller_name' => 'Add an new UE',
            'products' => $uerepo->findAllAsc(),
            'form' => $form->createView()

        ]);
    }
    /**
     * @Route("/admin/addCourse", name="addCourse")
     */
    public function addCourse(Request $request, ManagerRegistry $manager, CoursesRepository $repo): Response
    {
        $course = new Courses();

        $form = $this->createForm(CourseType::class, $course);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $manager->getManager()->persist($course);
            
            $manager->getManager()->flush();
            $this->addFlash("success", "New course added");
            return $this->redirectToRoute('addCourse');
            
        }
        return $this->render('admin/addCourse.html.twig', [
            'controller_name' => 'Add an new course',
            'products' => $repo->findAllAsc(),
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/admin/userprofile/{username}", name="userprofile")
     */
    public function userprofile(Request $request, User $user, UserRepository $userRepo, NotesRepository $noteRepo, RegistrationToCourseRepository $regisRepo): Response
    {
        $userNotes = null;
        $teacherNotes = null;
        $noteCourse = [];
        $noteNote = [];
        $noteColor = [];
        $totalNote = 0;
        $nbrNotes = 0;
        $mediumNote = 0;

        $search = new NotesPropertySearch();

        $searchForm = $this->createForm(NotesPropertySearchType::class, $search);

        $searchForm->handleRequest($request);

        $userInfos = $userRepo->findByCurrentUserAsc($user->getUsername());
        $regisList = $regisRepo->findByCurrentUser($user->getUsername());
        $notes = $noteRepo->findNotesBySearch($user, $search);

        if($user->getType() == 'ROLE_TEACHER'){
            $teacherNotes = 'teacher';
        }else if ($user->getType() == 'ROLE_USER'){
            $userNotes = 'user';
        }
        foreach ($notes as $note) {
            $noteCourse[] = $note->getCourse();
            $noteNote[] = $note->getNote();
            
            if ($note->getNote() < 10){
                $noteColor[] = "darkred";
            }else{
                $noteColor[] = "#262865";
            } 
            $totalNote += $note->getNote();
            $nbrNotes ++;
        }
        if ($nbrNotes > 0){
            $mediumNote = $totalNote / $nbrNotes;
        }

        $form = $this->createForm(EditType::class, $user);

        return $this->render('admin/userprofile.html.twig', [
            'controller_name' => 'Userprofile',
            'userInfos' => $userInfos,
            'userNotes' => $userNotes,
            'teacherNotes' => $teacherNotes,
            'regisList' => $regisList,
            'noteCourse' => json_encode($noteCourse),
            'noteNote' => json_encode($noteNote),
            'noteColor' => json_encode($noteColor),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'form' => $form->createView(),
            'searchForm' => $searchForm->createView(),
            'mediumNote' => $mediumNote,
            'notes' => $notes,


        ]);
    }
    /**
     * @Route("/admin/searchByClass/", name="searchByClass")
     */
    public function searchByClass(Request $request, NotesRepository $noteRepo): Response
    {
        $search = new ClassPropertySearch();

        $searchForm = $this->createForm(ClassPropertySearchType::class, $search);

        $noteCourse = [];
        $noteNote = [];
        $noteColor = [];
        $totalNote = 0;
        $nbrNotes = 0;
        $mediumNote = 0;

        $searchForm->handleRequest($request);
        
        $notes = $noteRepo->findBySearchClass($search);

        foreach ($notes as $note) {
            $noteCourse[] = $note->getCourse();
            $noteNote[] = $note->getNote();
            
            if ($note->getNote() < 10){
                $noteColor[] = "darkred";
            }else{
                $noteColor[] = "#262865";
            } 
            $totalNote += $note->getNote();
            $nbrNotes ++;
        }
        if ($nbrNotes > 0){
            $mediumNote = $totalNote / $nbrNotes;
        }

        return $this->render('admin/searchByClass.html.twig', [
            'controller_name' => 'Results By Course / Student',
            'searchForm' => $searchForm->createView(),
            'noteCourse' => json_encode($noteCourse),
            'noteNote' => json_encode($noteNote),
            'noteColor' => json_encode($noteColor),
            'mediumNote' => $mediumNote,
            'notes' => $notes,


        ]);
    }
}
