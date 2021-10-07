<?php
/**
 * Main controller.
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\ChangeUsernameType;
use App\Service\UserService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class MainController.
 *
 * @Route("/")
 */
class MainController extends AbstractController
{

    /**
     * User service.
     *
     * @var UserService
     */
    private $userService;

    /**
     * MainController constructor.
     *
     * @param UserService     $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Index action.
     *
     * @return Response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="main_index",
     * )
     */
    public function index(): Response
    {
        $user = $this->getUser();

        return $this->render(
            'main/index.html.twig',
            ['user' => $user]
        );
    }

    /**
     * Info action.
     *
     * @return Response
     *
     * @Route(
     *     "/info",
     *     methods={"GET"},
     *     name="main_info",
     * )
     */
    public function info(): Response
    {
        $user = $this->getUser();

        return $this->render(
            'main/info.html.twig',
            ['user' => $user]
        );
    }

    /**
     * ChangePassword action.
     *
     * @param Request $request
     * @param User    $user
     *
     * @return Response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/{id}/password",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="user_password",
     * )
     */
    public function changePassword(Request $request, User $user): Response
    {
        $form = $this->createForm(ChangePasswordType::class, $user, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $this->userService->encodingPassword($user)
            );
            $this->userService->saveUser($user);
            $this->addFlash('success', 'message_password_updated_successfully');

            return $this->redirectToRoute('main_index');
        }

        return $this->render(
            'user/editpass.html.twig',
            [
                'form' => $form->createView(),
                'user' => $user,
            ]
        );
    }

    /**
     * ChangeUsername action.
     *
     * @param Request $request
     * @param User    $user
     *
     * @return Response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/{id}/username",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="user_username",
     * )
     */
    public function changeUsername(Request $request, User $user): Response
    {
        $form = $this->createForm(ChangeUsernameType::class, $user, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->saveUser($user);
            $this->addFlash('success', 'message_username_updated_successfully');

            return $this->redirectToRoute('main_index');
        }

        return $this->render(
            'user/editusername.html.twig',
            [
                'form' => $form->createView(),
                'user' => $user,
            ]
        );
    }
}