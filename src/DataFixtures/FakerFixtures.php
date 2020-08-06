<?php
// src/DataFixtures/FakerFixtures.php
namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Images;
use App\Entity\Folders;
use App\Entity\Personne;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class FakerFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $folder1 = new Folders();
        $folder2 = new Folders();
        $folder3 = new Folders();
        $folder1->setName("Ogrodzenia");
        $folder2->setName("Bramy");
        $folder3->setName("Balustrady");

        $manager->persist($folder1);
        $manager->persist($folder2);
        $manager->persist($folder3);

        /*for($i=0; $i<10; $i++){

            $image = new Images();
            $image->setUrl($faker->imageUrl(200,200, 'cats'));
            $folder1->addImage($image);

            $manager->persist($image);
        }*/

        for($i=0; $i<10; $i++){

            $image = new Images();
            $image
            ->setUrl($faker->imageUrl(600,600, 'cats'))
            ->setLocalPath($faker->imageUrl(600,600, 'cats'));
            $folder2->addImage($image);

            $manager->persist($image);
        }

        for($i=0; $i<10; $i++){

            $image = new Images();
            $image
            ->setUrl($faker->imageUrl(600,600, 'cats'))
            ->setLocalPath($faker->imageUrl(600,600, 'cats'));
            $folder3->addImage($image);

            $manager->persist($image);
        }

        $roleAdmin = new Role();
        $roleAdmin
        ->setName("ROLE_ADMIN");

        $manager->persist($roleAdmin);

        $user = new User();
        $user
        ->setPseudo("domad007")
        ->setPassword($this->encoder->encodePassword($user, "domad1997"))
        ->addRole($roleAdmin);

        $manager->persist($user);
        $manager->flush();
    }
}