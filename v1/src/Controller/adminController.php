<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Entity\Images;
use App\Entity\Folders;
use App\Form\AddImagesType;
use App\Entity\ImagesCompare;
use App\Service\FileUploader;
use App\Form\AdminProfileType;
use App\Form\UploadImagesType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

            $this->addFlash('success', "Dane konta zostały zapisane !");
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
     * @Route("admin/gallery/{id}", name="galleryAdmin")
     */
    public function adminGallery(Folders $id){
        $manager = $this->getDoctrine()->getManager();
        $galeries = $manager
        ->getRepository(Folders::class)
        ->findAll();

        $folderImages = $manager
        ->getRepository(Images::class)
        ->findByfolder($id);

        $folderImagesCompare = $manager
        ->getRepository(ImagesCompare::class)
        ->findByfolder($id);

        return $this->render(
            'admin/adminGallery.html.twig',
            [
                'galeries' =>  $galeries,
                'folderImages' => $folderImages,
                'folder' => $id,
                'folderImagesCompare' => $folderImagesCompare
            ]
        );
    }

    /**
     * @Route("admin/addImages/{idFolder}", name="add_images")
     */
    public function addImages(Folders $idFolder, Request $request, string $uploadDir, FileUploader $uploader){
        $manager = $this->getDoctrine()->getManager();
        $galeries = $manager
        ->getRepository(Folders::class)
        ->findAll();
        
        if($request->isMethod('post')){
            $data = $request->request->all();
            if($this->isCsrfTokenValid("upload_files", $data['token'])){
                $image = new Images();

                $file = $request->files->get('file');
                $fileName= $file->getClientOriginalName();
                $uploader->upload($uploadDir, $file, $fileName);

                $image
                ->setUrl('http://localhost:8000/img/'.$fileName)
                ->setLocalPath($uploadDir.'/'.$fileName);
                
                $idFolder
                ->addImage($image);

                $manager->persist($image);
            }
            $manager->flush();
        }

        return $this->render(
            'admin/addImages.html.twig',
            [
                'galeries' => $galeries,
                'folder' => $idFolder
            ]
        );
    }

    /**
     * @Route("admin/addImagesCompare/{idFolder}", name="add_compare")
     */
    public function addImagesCompare(Folders $idFolder, Request $request, string $uploadDir, FileUploader $uploader){
        $manager = $this->getDoctrine()->getManager();
        $form = $this->createForm(AddImagesType::class);

        $galeries = $manager
        ->getRepository(Folders::class)
        ->findAll();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $files = $form->get('images');
            foreach($files as $key => $value){
                $images = new ImagesCompare();
                $file =  $value->get('localPath')->getData();
                $fileToCompare = $value->get('localPathToCompare')->getData();
                $fileName = $file->getClientOriginalName();
                $fileNameToCompare = $fileToCompare->getClientOriginalName();
                $uploader->upload($uploadDir, $file, $fileName);
                $uploader->upload($uploadDir, $fileToCompare, $fileNameToCompare);

                $images
                ->setUrl('http://localhost:8000/img/gallery/'.$fileName)
                ->setUrlToCompare('http://localhost:8000/img/gallery/'.$fileNameToCompare)
                ->setLocalPath($uploadDir.'/'.$fileName)
                ->setLocalPathToCompare($uploadDir.'/'.$fileNameToCompare);
                
                $idFolder
                ->addImagesCompare($images);

                $manager->persist($images);
            }

            $manager->flush();
            return $this->redirectToRoute('galleryAdmin', ['id' => $idFolder->getId()]);
        }

        return $this->render(
            'admin/addImagesCompare.html.twig',
            [  
                'galeries' => $galeries,
                'folder' => $idFolder,
                'form'  => $form->createView()
            ]
        );
    }

    /**
     * @Route("/deleteImages", name="delete_images")
     */
    public function deleteImages(Request $request, string $uploadDir){
        $manager = $this->getDoctrine()->getManager();
        if($request->isMethod('post')){
            $data = $request->request->all();

            if($this->isCsrfTokenValid('del_img', $data['token'])){
                foreach($data['id'] as $key => $value){
                    $fileSystem = new Filesystem();
                    $image = $manager
                    ->getRepository(Images::class)
                    ->findOneById($value);
                    
                    unlink($image->getLocalPath());

                    $manager->remove($image);
                }
            }

            $manager->flush();
        }

        return new Response("");
    }
}
