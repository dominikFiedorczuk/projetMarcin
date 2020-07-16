<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class homeController extends AbstractController {

    /**
     * @Route("/", name="home")
     */
    public function home(){
        return $this->render(
            'fr/base.html.twig'
        );
    }

    /**
     * @Route("/{lang}", name="lang")
     */
    public function lang($lang){
        if($lang == "fr"){
            return $this->render(
                'fr/base.html.twig'
            );
        }

        else {
            return $this->render(
                'nl/base.html.twig'
            );
        }
    }
    
}