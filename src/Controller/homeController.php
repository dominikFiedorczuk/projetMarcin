<?php

namespace App\Controller;


use App\Form\ContactFrType;
use App\Form\ContactNlType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class homeController extends AbstractController {

    private $mailer;
    public function __construct(\Swift_Mailer $mail){
        $this->mailer = $mail;
    }
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
    public function lang(Request $request, $lang){
        if($lang == "fr"){
            
            $form = $this->createForm(ContactFrType::class);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $this->contactFr($form);
            }

            return $this->render(
                'fr/base.html.twig', [
                    'formFr' => $form->createView()
                ]
            );
        }

        else {
            $form = $this->createForm(ContactNlType::class);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $this->contactNl($form);
            }
            return $this->render(
                'nl/base.html.twig',
                [
                    'formNl' => $form->createView()
                ]
            );
        }
    }

    private function contactFr($form){
        $data = $form->getData();

        $message = (new \Swift_Message('Contact'))
        ->setFrom("Formulaire@form")
        ->setTo('contact.easypeps@gmail.com')
        ->setBody(
            'Nom: '.$data['nom']. '<br>'.
            'Prenom: '.$data['prenom']. '<br>'.
            'Mail ou numéro de contact: '.$data['email']. '<br>'.
            'Message: '.$data['message']. '<br>',
            'text/html'
        );

        $this->mailer->send($message);
    }

    private function contactNl($form){
        $data = $form->getData();

        $message = (new \Swift_Message('Contact'))
        ->setFrom("Formulaire@form")
        ->setTo('contact.easypeps@gmail.com')
        ->setBody(
            'Nom: '.$data['naam']. '<br>'.
            'Prenom: '.$data['voornaam']. '<br>'.
            'Mail ou numéro de contact: '.$data['email']. '<br>'.
            'Message: '.$data['message']. '<br>',
            'text/html'
        );

        $this->mailer->send($message);
    }
    
}