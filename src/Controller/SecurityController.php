<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditType;
use App\Form\RegistrationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\String\UnicodeString;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connection", name="connection")
     */
    public function connection(AuthenticationUtils $authenticationUtils): Response
    {
        
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/connection.html.twig', [
            'controller_name' => 'connection',
            "lastUsername" => $lastUsername,
            "error" => $error
        ]);
    }
    /**
     * @Route("/edit/{username}", name="edit")
     */
    public function edit(User $user, Request $request, ManagerRegistry $manager, UserPasswordEncoderInterface $encoder)
    {
        if(!$user){
            return $this->render("error/error404.html.twig");
        }

        $form = $this->createForm(EditType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            
            $manager->getManager()->flush();
            $this->addFlash("success", "Account informations uptated");
            return $this->redirectToRoute('edit', [
                'username'=> $user->getUsername()
            ]);
            
        }
        return $this->render('security/edit.html.twig', [
            'user' => $user,
            'controller_name' => 'Edit Profile',
            'form' => $form->createView(),
            'user' => $user->getUsername(),
        ]);
    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        
    }
    
}
