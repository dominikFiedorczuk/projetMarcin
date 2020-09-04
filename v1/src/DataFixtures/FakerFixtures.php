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

        $roleAdmin = new Role();
        $roleAdmin
        ->setName("ROLE_ADMIN");

        $manager->persist($roleAdmin);

        $user = new User();
        $user
        ->setPseudo("domad007")
        ->setPassword($this->encoder->encodePassword($user, "domad1997"))
        ->addRole($roleAdmin);

        $userMarcin = new User();

        $userMarcin
        ->setPseudo("marcinP")
        ->setPassword($this->encoder->encodePassword($user, "egCRnt5Fbs5xRFMx"))
        ->addRole($roleAdmin);

        $userIrek = new User();

        $userIrek
        ->setPseudo("ireneuszD")
        ->setPassword($this->encoder->encodePassword($user, "ZufFbkQ4KQadkq7D"))
        ->addRole($roleAdmin);

        $manager->persist($userMarcin);
        $manager->persist($userIrek);
        $manager->persist($user);
        $manager->flush();
    }
}