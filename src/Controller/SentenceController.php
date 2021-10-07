<?php
/**
 * Sentence controller.
 */

namespace App\Controller;

use App\Entity\Sentence;
use App\Form\SentenceType;
use App\Repository\SentenceRepository;
use App\Service\SentenceService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SentenceController.
 *
 * @Route("/sentence")
 */
class SentenceController extends AbstractController
{
    /**
     * Sentence service.
     *
     * @var \App\Service\SentenceService
     */
    private $sentenceService;

    /**
     * SentenceController constructor.
     *
     * @param \App\Service\SentenceService $sentenceService Sentence service
     */
    public function __construct(SentenceService $sentenceService)
    {
        $this->sentenceService = $sentenceService;
    }

    /**
     * Index action.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="sentence_index",
     * )
     */
    public function index(Request $request): Response
    {
        $user = $this->getUser();

        $page = $request->query->getInt('page', 1);
        $filters = $request->query->getAlnum('filters', []);
        $pagination = $this->sentenceService->createAuthorPaginatedList($page, $user, $filters);

        return $this->render(
            'sentence/index.html.twig',
            ['pagination' => $pagination,
                'user' => $user
            ]
        );
    }

    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="sentence_create",
     * )
     */
    public function create(Request $request): Response
    {
        $sentence = new Sentence();
        $user = $this->getUser();
        $form = $this->createForm(SentenceType::class, $sentence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sentence->setAuthor($user);
            $this->sentenceService->save($sentence);

            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('sentence_index');
        }

        return $this->render(
            'sentence/create.html.twig',
            ['form' => $form->createView(),
                'user' => $user
            ]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\Sentence                      $sentence           Sentence entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="sentence_edit",
     * )
     */
    public function edit(Request $request, Sentence $sentence): Response
    {
        $form = $this->createForm(SentenceType::class, $sentence, ['method' => 'PUT']);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sentenceService->save($sentence);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('sentence_index');
        }

        return $this->render(
            'sentence/edit.html.twig',
            [
                'form' => $form->createView(),
                'sentence' => $sentence,
                'user' => $user
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\Sentence                     $sentence          Sentence entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="sentence_delete",
     * )
     */
    public function delete(Request $request, Sentence $sentence): Response
    {
        $form = $this->createForm(FormType::class, $sentence, ['method' => 'DELETE']);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sentenceService->delete($sentence);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('sentence_index');
        }

        return $this->render(
            'sentence/delete.html.twig',
            [
                'form' => $form->createView(),
                'sentence' => $sentence,
                'user' => $user
            ]
        );
    }
}