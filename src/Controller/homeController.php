<?php

namespace App\Controller;


use App\Entity\Images;
use App\Entity\Folders;
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
     * @Route("/{lang}", name="lang")
     */
    public function lang(Request $request, $lang){
        if($lang == "fr"){
            
            $form = $this->createForm(ContactFrType::class);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $this->contact("fr", $form);
            }

            return $this->render(
                'fr/base.html.twig', [
                    'formFr' => $form->createView()
                ]
            );
        }

        if($lang == "nl") {
            $form = $this->createForm(ContactNlType::class);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $this->contact("nl", $form);
            }
            return $this->render(
                'nl/base.html.twig',
                [
                    'formNl' => $form->createView()
                ]
            );
        }
    }

    private function contact($lang, $form){
        $data = $form->getData();

        if($lang == "fr"){
            $message = (new \Swift_Message('Contact'))
            ->setFrom("Formulaire@form")
            ->setTo('contact.easypeps@gmail.com')
            ->setBody(
                'Imie: '.$data['nom']. '<br>'.
                'Nazwisko: '.$data['prenom']. '<br>'.
                'Email lub numer telefonu: '.$data['email']. '<br>'.
                'Wiadomosc: '.$data['message']. '<br>',
                'text/html'
            );
        }
        
        else {
            $message = (new \Swift_Message('Contact'))
            ->setFrom("Formulaire@form")
            ->setTo('contact.easypeps@gmail.com')
            ->setBody(
                'Imie: '.$data['naam']. '<br>'.
                'Nazwisko: '.$data['voornaam']. '<br>'.
                'Email lub numer telefonu: '.$data['email']. '<br>'.
                'Wiadomosc: '.$data['message']. '<br>',
                'text/html'
            );
        }

        $this->mailer->send($message);
    }

    /**
     * @Route("/{lang}/{gallery}", name="gallery")
     */
    public function gallery($lang, $gallery){
        $manager = $this->getDoctrine()->getManager();
        $folderName = "";
        if($lang == "fr"){
            switch($gallery){
                case 'balustrades': 
                    $folder = $manager
                    ->getRepository(Folders::class)
                    ->findByname("Balustrady");

                    $photos = $manager
                    ->getRepository(Images::class)
                    ->findByfolder($folder);

                    $folderName= "Balustrades";
                break;
                case 'portes':
                    $folder = $manager
                    ->getRepository(Folders::class)
                    ->findByname("Bramy");
                    
                    $photos = $manager
                    ->getRepository(Images::class)
                    ->findByfolder($folder);

                    $folderName= "Portes";
                break;
                case 'clotures' : 
                    $folder = $manager
                    ->getRepository(Folders::class)
                    ->findByname("Ogrodzenia");
                    
                    $photos = $manager
                    ->getRepository(Images::class)
                    ->findByfolder($folder);

                    $folderName= "Clôtures";
                break;
            }

            return $this->render(
                'fr/gallery.html.twig',
                [
                    'photos' => $photos,
                    'folderName' => $folderName
                ]
            );
        }
        else {
            switch($gallery){
                case 'balustrades': 
                    $folder = $manager
                    ->getRepository(Folders::class)
                    ->findByname("Balustrady");

                    $photos = $manager
                    ->getRepository(Images::class)
                    ->findByfolder($folder);

                    $folderName= "Balustrades";
                break;
                case 'portes':
                    $folder = $manager
                    ->getRepository(Folders::class)
                    ->findByname("Bramy");
                    
                    $photos = $manager
                    ->getRepository(Images::class)
                    ->findByfolder($folder);

                    $folderName= "Deuren";
                break;
                case 'clotures' : 
                    $folder = $manager
                    ->getRepository(Folders::class)
                    ->findByname("Ogrodzenia");
                    
                    $photos = $manager
                    ->getRepository(Images::class)
                    ->findByfolder($folder);

                    $folderName= "Hekken";
                break;
            }
                
            return $this->render(
                'nl/gallery.html.twig',
                [
                    'photos' => $photos,
                    'folderName' => $folderName
                ]
            );
        }
    }
    
}