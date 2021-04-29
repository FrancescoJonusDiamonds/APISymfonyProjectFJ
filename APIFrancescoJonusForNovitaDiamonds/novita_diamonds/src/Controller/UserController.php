<?php


namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Annotations as OA;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends AbstractController
{
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * UserController constructor.
     * @param UserService $userService
     * @param SerializerInterface $serializer
     */
    public function __construct(UserService $userService, SerializerInterface $serializer)
    {
        $this->userService = $userService;
        $this->serializer = $serializer;
    }

    /**
     * This method is used to render twig template in which the users from database are displayed
     * @return Response
     */
    public function list()
    {
        return $this->render('user.html.twig');
    }

    /**
     * This method is used to return all the users from the database
     * @return Response
     */
    public function index()
    {
        $users = $this->userService->findAll();
        $responseData = [
            'total' => count($users),
            'items' => $users
        ];

        return new Response(
            $this->serializer->serialize($responseData, 'json', ['groups' => 'show_user']),
            Response::HTTP_OK,
            ['Content-type' => 'application/json']
        );
    }

    /**
     * This method is used to return a specific user from the database based on the id that is provided
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $user = $this->userService->show($id);

        return new Response(
            $this->serializer->serialize($user, 'json', ['groups' => 'show_user']),
            Response::HTTP_OK,
            ['Content-type' => 'application/json']
        );
    }

    /**
     * This method is used to insert a new user into the database
     *
     * @OA\RequestBody(
     *     description="User properties",
     *     required=true,
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(
     *             property="name",
     *             type="string",
     *             example="name"
     *         ),
     *         @OA\Property(
     *             property="username",
     *             type="string",
     *             example="username"
     *         ),
     *         @OA\Property(
     *             property="password",
     *             type="string",
     *             example="password"
     *         )
     *     )
     * )
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $userModel = $this->serializer->deserialize($request->getContent(), User::class, 'json');
        $user = $this->userService->create($userModel);

        return new Response(
            $this->serializer->serialize($user, 'json', ['groups' => 'show_user']),
            Response::HTTP_OK,
            ['Content-type' => 'application/json']
        );
    }

    /**
     * This method is used to update and return a specific user from the database based on the id that is provided
     *
     * @OA\RequestBody(
     *     description="User properties",
     *     required=true,
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(
     *             property="name",
     *             type="string",
     *             example="new-name"
     *         ),
     *         @OA\Property(
     *             property="username",
     *             type="string",
     *             example="new-username"
     *         ),
     *         @OA\Property(
     *             property="password",
     *             type="string",
     *             example="new-password"
     *         )
     *     )
     * )
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $userModel = $this->serializer->deserialize($request->getContent(), User::class, 'json');
        $user = $this->userService->update($userModel, $id);

        return new Response(
            $this->serializer->serialize($user, 'json', ['groups' => 'show_user']),
            Response::HTTP_OK,
            ['Content-type' => 'application/json']
        );
    }

    /**
     * This method is checks user credentials that are provided and returns true if both conditions are met false otherwise.
     *
     * @OA\RequestBody(
     *     description="User credentials",
     *     required=true,
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(
     *             property="username",
     *             type="string",
     *             example="username"
     *         ),
     *         @OA\Property(
     *             property="password",
     *             type="string",
     *             example="password"
     *         )
     *     )
     * )
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        $userModel = $this->serializer->deserialize($request->getContent(), User::class, 'json');
        $response = ['authorised' => $this->userService->login($userModel)];
        return new Response(
            $this->serializer->serialize($response, 'json'),
            Response::HTTP_OK,
            ['Content-type' => 'application/json']
        );
    }
}