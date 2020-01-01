<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * AuthorFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $manager->persist($this->createUser("Adams", "Alexandra", 1));
        $manager->persist($this->createUser("Beuys", "Joseph", 2));
        $manager->persist($this->createUser("Carter", "Jimmey", 3));
        $manager->persist($this->createUser("Ringer", "Ginger", 4));
        $manager->persist($this->createUser("Rocher", "Yves", 5));

        $manager->flush();
    }
    private function createUser($name, $firstName, $order){
        $user = new User();
        $user   ->setName($name)
            ->setFirstName($firstName)
            ->setPassword($this->encoder->encodePassword($user, '123'))
            ->setEmail("$firstName.$name@user-stories.fr");
        $this->addReference("user_$order", $user);
        return $user;
    }
}
