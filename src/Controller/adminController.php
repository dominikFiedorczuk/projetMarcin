<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
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
        return $this->render(
            'admin/base.html.twig'
        );
    }
}