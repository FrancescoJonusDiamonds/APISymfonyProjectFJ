<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserService
 * @package App\Service
 */
class UserService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserService constructor.
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * This method is used to return all the users from the database
     * @return object[]
     */
    public function findAll()
    {
        return $this->em->getRepository(User::class)->findAll();
    }

    /**
     * This method is used to return a specific user from the database based on the id that is provided
     * @param int $id
     * @return object|null
     */
    public function show(int $id)
    {
        return $this->em->getRepository(User::class)->findOneBy(['id' => $id]);
    }

    /**
     * This method is used to insert a new user into the database
     * @param User $userModel
     * @return User
     */
    public function create(User $userModel)
    {
        $user = new User();
        $user->setName($userModel->getName())
            ->setUsername($userModel->getUsername())
            ->setPassword($this->passwordEncoder->encodePassword($user, $userModel->getPassword()));

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * This method is used to update and return a specific user from the database based on the id that is provided
     * @param User $userModel
     * @param int $id
     * @return User
     */
    public function update(User $userModel, int $id)
    {
        /** @var User $user */
        $user = $this->em->getRepository(User::class)->findOneBy(['id' => $id]);
        $user->setName($userModel->getName())
            ->setUsername($userModel->getUsername())
            ->setPassword($this->passwordEncoder->encodePassword($user, $userModel->getPassword()));

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * This method is checks user credentials that are provided and returns true if both conditions are met false otherwise.
     * @param User $userModel
     * @return bool
     */
    public function login(User $userModel)
    {
        $user = $this->em->getRepository(User::class)->findOneBy(['username' => $userModel->getUsername()]);
        if (($user instanceof User) && $this->passwordEncoder->isPasswordValid($user, $userModel->getPassword())) {
            return true;
        }

        return false;
    }
}