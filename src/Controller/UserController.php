<?php
/**
 * @2020 Creative Coffeur Sükrü Demir, Burgsteinfurt
 * http://www.creative-coiffeur.de/
 */

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class UserController
 */
class UserController
{
    /**
     * @var UserRepository $userRepository
     */
    private $userRepository;

    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get one User
     *
     * @Route("/users/{id}", name="get_one_user", methods={"GET"})
     * @param $id
     * @return JsonResponse
     */
    public function getUser($id): JsonResponse
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);

        return new JsonResponse($user, Response::HTTP_OK);
    }

    /**
     * Get all Users
     *
     * @Route("/users", name="get_all_users", methods={"GET"})
     * @return JsonResponse
     */
    public function getAllUsers(): JsonResponse
    {
        $users = $this->userRepository->findAll();

        return new JsonResponse($users, Response::HTTP_OK);
    }

    /**
     * Adds new User
     *
     * @Route("/users", name="add_user", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addUser(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $email = $data['email'];
        $phone = $data['phone'];
        $gender = $data['gender'];
        $info = $data['info'];

        if (empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($gender) || empty($info)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->userRepository->saveUser($firstName, $lastName, $email, $phone, $gender, $info);

        return new JsonResponse(['status' => 'Customer created!'], Response::HTTP_CREATED);
    }

    /**
     * Updates User
     *
     * @Route("/users/{id}", name="update_user", methods={"PUT"})
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['firstName']) ? true : $user->setFirstName($data['firstName']);
        empty($data['lastName']) ? true : $user->setLastName($data['lastName']);
        empty($data['email']) ? true : $user->setEmail($data['email']);
        empty($data['info']) ? true : $user->setInfo($data['info']);

        $updateUser = $this->userRepository->updateUser($user);

        return new JsonResponse($updateUser, Response::HTTP_OK);
    }

    /**
     * Deletes User
     *
     * @Route("/users/{id}", name="delete_user", methods={"DELETE"})
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);

        $this->userRepository->removeUser($user);

        return new JsonResponse(['status' => 'Customer deleted'], Response::HTTP_NO_CONTENT);
    }
}
