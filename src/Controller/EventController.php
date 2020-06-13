<?php
/**
 * @2020 Creative Coffeur Sükrü Demir, Burgsteinfurt
 * http://www.creative-coiffeur.de/
 */

namespace App\Controller;

use App\Repository\EventRepository;
use App\Form\Type\EventType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class EventController
 */
class EventController
{
    /**
     * @var EventRepository $eventRepository
     */
    private $eventRepository;

    public function __construct(
        EventRepository $eventRepository
    )
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * Get one Event
     *
     * @Route("/events/{id}", name="get_one_event", methods={"GET"})
     * @param $id
     * @return JsonResponse
     */
    public function getEvent($id): JsonResponse
    {
        $event = $this->eventRepository->findOneBy(['id' => $id]);

        return new JsonResponse($event, Response::HTTP_OK);
    }

    /**
     * Get all Events
     *
     * @Route("/events", name="get_all_events", methods={"GET"})
     * @return JsonResponse
     */
    public function getAllEvents(): JsonResponse
    {
        $events = $this->eventRepository->findAll();

        return new JsonResponse($events, Response::HTTP_OK);
    }

    /**
     * Adds new Event
     *
     * @Route("/events", name="add_event", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addEvent(Request $request): JsonResponse
    {

        $data = json_decode($request->getContent(), true);

        $start = $data['start'];
        $end = $data['end'];
        $title = $data['title'];
        $content = $data['content'];
        $contentFull = $data['contentFull'];
        $gender = $data['gender'];

        if (empty($start) ||
            empty($end) ||
            empty($title) ||
            empty($content) ||
            empty($contentFull) ||
            empty($gender)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->eventRepository->saveEvent(
            $start,
            $end,
            $title,
            $content,
            $contentFull,
            $gender);

        return new JsonResponse(['status' => 'Event created!'], Response::HTTP_CREATED);
    }

    /**
     * Updates Event
     *
     * @Route("/events/{id}", name="update_event", methods={"PUT"})
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        $user = $this->eventRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['start']) ? true : $user->setStart($data['start']);
        empty($data['end']) ? true : $user->setEnd($data['end']);
        empty($data['title']) ? true : $user->setTitle($data['title']);
        empty($data['content']) ? true : $user->setContent($data['content']);
        empty($data['contentFull']) ? true : $user->setContentFull($data['contentFull']);
        empty($data['gender']) ? true : $user->setGender($data['gender']);

        $updateEvent = $this->eventRepository->updateEvent($user);

        return new JsonResponse($updateEvent, Response::HTTP_OK);
    }

    /**
     * Deletes Event
     *
     * @Route("/events/{id}", name="delete_event", methods={"DELETE"})
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $event = $this->eventRepository->findOneBy(['id' => $id]);

        $this->eventRepository->removeUser($event);

        return new JsonResponse(['status' => 'Customer deleted'], Response::HTTP_NO_CONTENT);
    }
}
