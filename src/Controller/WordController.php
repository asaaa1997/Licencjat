<?php
/**
 * Word controller.
 */
namespace App\Controller;

use App\Entity\Word;
use App\Form\WordType;
use App\Service\WordService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WordController.
 *
 * @Route("/word")
 */
class WordController extends AbstractController
{
    /**
     * Word service.
     *
     * @var \App\Service\WordService
     */
    private $wordService;

    /**
     * WordController constructor.
     *
     * @param \App\Service\WordService $wordService Word service
     */
    public function __construct(WordService $wordService)
    {
        $this->wordService = $wordService;
    }

    /**
     * Index action.
     *
     * @param Request $request
     *
     * @return Response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="word_index",
     * )
     */
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        $page = $request->query->getInt('page', 1);
        $filters = $request->query->getAlnum('filters', []);
        $pagination = $this->wordService->createAuthorPaginatedList($page, $user, $filters);


        return $this->render(
            'word/index.html.twig',
            [
                'pagination' => $pagination,
                'user' => $user,
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
     *     name="word_create",
     * )
     */
    public function create(Request $request): Response
    {
        $word = new Word();
        $user = $this->getUser();
        $form = $this->createForm(WordType::class, $word);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $word->setAuthor($user);
            $this->wordService->save($word);

            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('word_index');
        }

        return $this->render(
            'word/create.html.twig',
            ['form' => $form->createView(),
                'user' => $user
            ]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\Word                      $word           Word entity
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
     *     name="word_edit",
     * )
     */
    public function edit(Request $request, Word $word): Response
    {
        $form = $this->createForm(WordType::class, $word, ['method' => 'PUT']);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $this->wordService->save($word);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('word_index');
        }

        return $this->render(
            'word/edit.html.twig',
            [
                'form' => $form->createView(),
                'word' => $word,
                'user' => $user
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\Word                     $word          Word entity
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
     *     name="word_delete",
     * )
     */
    public function delete(Request $request, Word $word): Response
    {
        $form = $this->createForm(FormType::class, $word, ['method' => 'DELETE']);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->wordService->delete($word);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('word_index');
        }

        return $this->render(
            'word/delete.html.twig',
            [
                'form' => $form->createView(),
                'word' => $word,
                'user' => $user
            ]
        );
    }
}
