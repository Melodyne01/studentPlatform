<?php

namespace App\Controller;

use App\Entity\UE;
use App\Entity\User;
use App\Entity\Notes;
use App\Entity\Courses;
use App\Entity\Message;
use App\Entity\AssocTeacherCourses;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeleteController extends AbstractController
{
    /**
     * @Route("/deleteCourse/{id}", name="deleteCourse")
     */
    public function deleteCourse (Courses $course, ManagerRegistry $manager)
    {
        $manager->getManager()->remove($course);
        $manager->getManager()->flush();
        $this->addFlash("danger", "Course deleted");
        return $this->redirectToRoute("addCourse");
    }
    /**
     * @Route("/deleteUE/{id}", name="deleteUE")
     */
    public function deleteUE (UE $UE, ManagerRegistry $manager)
    {
        $manager->getManager()->remove($UE);
        $manager->getManager()->flush();
        $this->addFlash("danger", "UE deleted");
        return $this->redirectToRoute("addUE");
    }
    /**
     * @Route("/deleteRelation/{id}", name="deleteRelation")
     */
    public function deleteRelation(AssocTeacherCourses $relation, ManagerRegistry $manager)
    {
        $manager->getManager()->remove($relation);
        $manager->getManager()->flush();
        $this->addFlash("danger", "Relation deleted");
        return $this->redirectToRoute("relation");
    }
    /**
     * @Route("/deleteUser/{id}", name="deleteUser")
     */
    public function deleteUser (User $user, ManagerRegistry $manager)
    {
        $manager->getManager()->remove($user);
        $manager->getManager()->flush();
        $this->addFlash("danger", "User deleted");
        return $this->redirectToRoute("registration");
    }

    /**
     * @Route("/deleteNote/{id}", name="deleteNote")
     */
    public function deleteNote (Notes $note, ManagerRegistry $manager)
    {
        $manager->getManager()->remove($note);
        $manager->getManager()->flush();
        $this->addFlash("danger", "Note deleted");
        return $this->redirectToRoute("addNote");
    }

    /**
     * @Route("/deleteMessage/{id}", name="deleteMessage")
     */
    public function deleteMessage (Message $message, ManagerRegistry $manager)
    {
        $manager->getManager()->remove($message);
        $manager->getManager()->flush();
        $this->addFlash("danger", "Message deleted");
        return $this->redirectToRoute("conversation",[
            'username' => $message->getReceiver(),
        ]);
    }
}
