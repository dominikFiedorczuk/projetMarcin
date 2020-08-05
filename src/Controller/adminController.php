<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Entity\Images;
use App\Entity\Folders;
use App\Form\AdminProfileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class adminController extends AbstractController {

    /**
     * @Route("/admin/login", name="admin_login")
     */
    public function adminLogin(AuthenticationUtils $utils){
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();


        return $this->render(
            'admin/login.html.twig',
            [
                'error' => $error !== null,
                'username' => $username
            ]
        );
    }

    /**
     * @Route("logout", name="logout")
     */
    public function logout(){
        
    }

    /**
     * @Route("admin", name="admin_dashboard")
     */
    public function adminDashboard(){
        $manager = $this->getDoctrine()->getManager();
        $galeries = $manager
        ->getRepository(Folders::class)
        ->findAll();

        return $this->render(
            'admin/base.html.twig',
            [
                'galeries' => $galeries
            ]
        );
    }

    /**
     * @Route("admin/account", name="admin_account")
     */
    public function adminAccount(Request $request, UserPasswordEncoderInterface $encoder){
        $manager = $this->getDoctrine()->getManager();
        $galeries = $manager
        ->getRepository(Folders::class)
        ->findAll();

        $user = $this->getUser();
        $form = $this->createForm(AdminProfileType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $newPassword = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($newPassword);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', "Dane konta zostaly zmienione !");
        }

        return $this->render(
            'admin/adminAccount.html.twig',
            [
                'form' => $form->createView(),
                'galeries' =>  $galeries
            ]
        );
    }

    /**
     * @Route("admin/gallery/{id}", name="gallery")
     */
    public function adminGallery(Folders $id){
        $manager = $this->getDoctrine()->getManager();
        $galeries = $manager
        ->getRepository(Folders::class)
        ->findAll();

        $folderImages = $manager
        ->getRepository(Images::class)
        ->findByfolder($id);

        return $this->render(
            'admin/adminGallery.html.twig',
            [
                'galeries' =>  $galeries,
                'folderImages' => $folderImages
            ]
        );
    }
}