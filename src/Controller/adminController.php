<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class adminController extends AbstractController {
    
    /**
     * @Route("/admin", name="admin")
     */
    public function admin(){
        return $this->render(
            'base.html.twig'
        );
    }
}