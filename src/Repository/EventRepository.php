<?php
/**
 * @2020 Creative Coffeur Sükrü Demir, Burgsteinfurt
 * http://www.creative-coiffeur.de/
 */

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
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
        parent::__construct($registry, Event::class);
        $this->manager = $manager;
    }

    /**
     * Saves New Event to DB
     *
     * @param $start
     * @param $end
     * @param $title
     * @param $content
     * @param $contentFull
     * @param $gender
     */
    public function saveEvent(
        string $start,
        string $end,
        string $title,
        string $content,
        string $contentFull,
        string $gender
    ) {
        $newEvent = new Event();

        $newEvent
            ->setStart($start)
            ->setEnd($end)
            ->setTitle($title)
            ->setContent($content)
            ->setContentFull($contentFull)
            ->setGender($gender);

        $this->manager->persist($newEvent);
        $this->manager->flush();
    }

    /**
     * Updates Event
     *
     * @param Event $event
     * @return Event
     */
    public function updateEvent(Event $event): Event
    {
        $this->manager->persist($event);
        $this->manager->flush();

        return $event;
    }

    /**
     * Deletes Event
     *
     * @param Event $event
     */
    public function removeUser(Event $event)
    {
        $this->manager->remove($event);
        $this->manager->flush();
    }
}
