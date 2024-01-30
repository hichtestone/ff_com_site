<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

/**
 * Class UserFixtures
 * @package App\DataFixtures
 */
class UserFixtures extends Fixture implements FixtureGroupInterface
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder, ManagerRegistry $doctrine)
    {
        $this->encoder           = $encoder;
        $this->em = $doctrine->getManager();
    }

    public function load(ObjectManager $manager)
    {
        //ajouter un nouveau utilisateur  dont le profil est un Direction générale

        $user = new User();
        $encodedPassword = $this->encoder->hashPassword($user, 'azerty');
        $user->setEmail('zz@bb.com');
        $user->setPassword($encodedPassword);
        $user->setRoles(["ROLE_SUPER_ADMIN"]);
        $user->setResume('hhh');
        $user->setFirstname('hhh');
        $user->setLastname('hhh');
        $user->setDescription('hhh');
        $this->em->persist($user);


        $this->em->flush();


    }

    public static function getGroups(): array
    {
        return ['userCreate'];
    }
}
