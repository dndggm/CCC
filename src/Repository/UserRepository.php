<?php
/**
 * @2020 Creative Coffeur Sükrü Demir, Burgsteinfurt
 * http://www.creative-coiffeur.de/
 */

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * UserRepository constructor.
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $manager
     */
    public function __construct(
        ManagerRegistry $registry,
        EntityManagerInterface $manager
    )
    {
        parent::__construct($registry, User::class);
        $this->manager = $manager;
    }

    /**
     * Saves New User to DB
     *
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $phone
     * @param $gender
     * @param $info
     */
    public function saveUser($firstName, $lastName, $email, $phone, $gender, $info)
    {
        $newUser = new User();

        $newUser
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail($email)
            ->setPhone($phone)
            ->setGender($gender)
            ->setInfo($info);

        $this->manager->persist($newUser);
        $this->manager->flush();
    }

    /**
     * Updates User
     *
     * @param User $user
     * @return User
     */
    public function updateUser(User $user): User
    {
        $this->manager->persist($user);
        $this->manager->flush();

        return $user;
    }

    /**
     * Deletes User
     *
     * @param User $user
     */
    public function removeUser(User $user)
    {
        $this->manager->remove($user);
        $this->manager->flush();
    }
}
