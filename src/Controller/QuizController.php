<?php
/**
 * Quiz controller.
 */
namespace App\Controller;

use App\Service\LanguageService;
use App\Service\SentenceService;
use App\Service\WordService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class QuizController.
 *
 * @Route("/quiz")
 */
class QuizController extends AbstractController
{
    /**
     * Word service.
     *
     * @var \App\Service\WordService
     */
    private $wordService;

    /**
     * Sentence service.
     *
     * @var \App\Service\SentenceService
     */
    private $sentenceService;

    /**
     * Language service.
     *
     * @var \App\Service\LanguageService
     */
    private $languageService;

    /**
     * QuizController constructor.
     *
     * @param WordService $wordService
     * @param LanguageService $languageService
     */
    public function __construct(WordService $wordService, LanguageService $languageService, SentenceService $sentenceService)
    {
        $this->wordService = $wordService;
        $this->sentenceService = $sentenceService;
        $this->languageService = $languageService;
    }

    /**
     * Index action.
     *
     * @return Response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="quiz_index",
     * )
     */
    public function index(): Response
    {
        $user = $this->getUser();

        return $this->render(
            'quiz/index.html.twig',
            [
                'user' => $user,
            ]
        );
    }

    /**
     * Modeit action.
     *
     * @return Response
     *
     * @Route(
     *     "/modeit",
     *     methods={"GET"},
     *     name="quiz_modeit",
     * )
     */
    public function modeit(): Response
    {
        $user = $this->getUser();

        return $this->render(
            'quiz/modeit.html.twig',
            [
                'user' => $user,
            ]
        );
    }

    /**
     * Modeen action.
     *
     * @return Response
     *
     * @Route(
     *     "/modeen",
     *     methods={"GET"},
     *     name="quiz_modeen",
     * )
     */
    public function modeen(): Response
    {
        $user = $this->getUser();

        return $this->render(
            'quiz/modeen.html.twig',
            [
                'user' => $user,
            ]
        );
    }

    /**
     * Modehu action.
     *
     * @return Response
     *
     * @Route(
     *     "/modehu",
     *     methods={"GET"},
     *     name="quiz_modehu",
     * )
     */
    public function modehu(): Response
    {
        $user = $this->getUser();

        return $this->render(
            'quiz/modehu.html.twig',
            [
                'user' => $user,
            ]
        );
    }

    /**
     * Wordtransit action.
     *
     * @return Response
     *
     * @Route(
     *     "/wordtransit",
     *     methods={"GET"},
     *     name="quiz_wordtransit",
     * )
     */
    public function wordtransit(Request $request): Response
    {
        $user = $this->getUser();
        $language = $this->languageService->findOneByName('włoski');
        $page = $request->query->getInt('page', 1);
        $filters = $request->query->getAlnum('filters', []);
        $pagination = $this->wordService->createLanguagePaginatedList($page, $language, $user, $filters);


        return $this->render(
            'quiz/wordtrans.html.twig',
            [
                'pagination' => $pagination,
                'user' => $user,
                'language' => $language,
            ]
        );
    }

    /**
     * Wordit action.
     *
     * @return Response
     *
     * @Route(
     *     "/wordit",
     *     methods={"GET"},
     *     name="quiz_wordit",
     * )
     */
    public function wordit(Request $request): Response
    {
        $user = $this->getUser();
        $language = $this->languageService->findOneByName('włoski');
        $page = $request->query->getInt('page', 1);
        $filters = $request->query->getAlnum('filters', []);
        $pagination = $this->wordService->createLanguagePaginatedList($page, $language, $user, $filters);


        return $this->render(
            'quiz/word.html.twig',
            [
                'pagination' => $pagination,
                'user' => $user,
                'language' => $language,
            ]
        );
    }

    /**
     * Sentencetransit action.
     *
     * @return Response
     *
     * @Route(
     *     "/sentencetransit",
     *     methods={"GET"},
     *     name="quiz_sentencetransit",
     * )
     */
    public function sentencetransit(Request $request): Response
    {
        $user = $this->getUser();
        $language = $this->languageService->findOneByName('włoski');
        $page = $request->query->getInt('page', 1);
        $filters = $request->query->getAlnum('filters', []);
        $pagination = $this->sentenceService->createLanguagePaginatedList($page, $language, $user, $filters);


        return $this->render(
            'quiz/sentencetrans.html.twig',
            [
                'pagination' => $pagination,
                'user' => $user,
                'language' => $language,
            ]
        );
    }

    /**
     * Sentenceit action.
     *
     * @return Response
     *
     * @Route(
     *     "/sentenceit",
     *     methods={"GET"},
     *     name="quiz_sentenceit",
     * )
     */
    public function sentenceit(Request $request): Response
    {
        $user = $this->getUser();
        $language = $this->languageService->findOneByName('włoski');
        $page = $request->query->getInt('page', 1);
        $filters = $request->query->getAlnum('filters', []);
        $pagination = $this->sentenceService->createLanguagePaginatedList($page, $language, $user, $filters);


        return $this->render(
            'quiz/sentence.html.twig',
            [
                'pagination' => $pagination,
                'user' => $user,
                'language' => $language,
            ]
        );
    }

    /**
     * Wordtransen action.
     *
     * @return Response
     *
     * @Route(
     *     "/wordtransen",
     *     methods={"GET"},
     *     name="quiz_wordtransen",
     * )
     */
    public function wordtransen(Request $request): Response
    {
        $user = $this->getUser();
        $language = $this->languageService->findOneByName('angielski');
        $page = $request->query->getInt('page', 1);
        $filters = $request->query->getAlnum('filters', []);
        $pagination = $this->wordService->createLanguagePaginatedList($page, $language, $user, $filters);


        return $this->render(
            'quiz/wordtransen.html.twig',
            [
                'pagination' => $pagination,
                'user' => $user,
                'language' => $language,
            ]
        );
    }

    /**
     * Worden action.
     *
     * @return Response
     *
     * @Route(
     *     "/worden",
     *     methods={"GET"},
     *     name="quiz_worden",
     * )
     */
    public function worden(Request $request): Response
    {
        $user = $this->getUser();
        $language = $this->languageService->findOneByName('angielski');
        $page = $request->query->getInt('page', 1);
        $filters = $request->query->getAlnum('filters', []);
        $pagination = $this->wordService->createLanguagePaginatedList($page, $language, $user, $filters);


        return $this->render(
            'quiz/worden.html.twig',
            [
                'pagination' => $pagination,
                'user' => $user,
                'language' => $language,
            ]
        );
    }

    /**
     * Sentencetransen action.
     *
     * @return Response
     *
     * @Route(
     *     "/sentencetransen",
     *     methods={"GET"},
     *     name="quiz_sentencetransen",
     * )
     */
    public function sentencetransen(Request $request): Response
    {
        $user = $this->getUser();
        $language = $this->languageService->findOneByName('angielski');
        $page = $request->query->getInt('page', 1);
        $filters = $request->query->getAlnum('filters', []);
        $pagination = $this->sentenceService->createLanguagePaginatedList($page, $language, $user, $filters);


        return $this->render(
            'quiz/sentencetransen.html.twig',
            [
                'pagination' => $pagination,
                'user' => $user,
                'language' => $language,
            ]
        );
    }

    /**
     * Sentenceen action.
     *
     * @return Response
     *
     * @Route(
     *     "/sentenceen",
     *     methods={"GET"},
     *     name="quiz_sentenceen",
     * )
     */
    public function sentenceen(Request $request): Response
    {
        $user = $this->getUser();
        $language = $this->languageService->findOneByName('angielski');
        $page = $request->query->getInt('page', 1);
        $filters = $request->query->getAlnum('filters', []);
        $pagination = $this->sentenceService->createLanguagePaginatedList($page, $language, $user, $filters);


        return $this->render(
            'quiz/sentenceen.html.twig',
            [
                'pagination' => $pagination,
                'user' => $user,
                'language' => $language,
            ]
        );
    }

    /**
     * Wordtranshu action.
     *
     * @return Response
     *
     * @Route(
     *     "/wordtranshu",
     *     methods={"GET"},
     *     name="quiz_wordtranshu",
     * )
     */
    public function wordtranshu(Request $request): Response
    {
        $user = $this->getUser();
        $language = $this->languageService->findOneByName('węgierski');
        $page = $request->query->getInt('page', 1);
        $filters = $request->query->getAlnum('filters', []);
        $pagination = $this->wordService->createLanguagePaginatedList($page, $language, $user, $filters);


        return $this->render(
            'quiz/wordtranshu.html.twig',
            [
                'pagination' => $pagination,
                'user' => $user,
                'language' => $language,
            ]
        );
    }

    /**
     * Wordhu action.
     *
     * @return Response
     *
     * @Route(
     *     "/wordhu",
     *     methods={"GET"},
     *     name="quiz_wordhu",
     * )
     */
    public function wordhu(Request $request): Response
    {
        $user = $this->getUser();
        $language = $this->languageService->findOneByName('węgierski');
        $page = $request->query->getInt('page', 1);
        $filters = $request->query->getAlnum('filters', []);
        $pagination = $this->wordService->createLanguagePaginatedList($page, $language, $user, $filters);


        return $this->render(
            'quiz/wordhu.html.twig',
            [
                'pagination' => $pagination,
                'user' => $user,
                'language' => $language,
            ]
        );
    }

    /**
     * Sentencetranshu action.
     *
     * @return Response
     *
     * @Route(
     *     "/sentencetranshu",
     *     methods={"GET"},
     *     name="quiz_sentencetranshu",
     * )
     */
    public function sentencetranshu(Request $request): Response
    {
        $user = $this->getUser();
        $language = $this->languageService->findOneByName('węgierski');
        $page = $request->query->getInt('page', 1);
        $filters = $request->query->getAlnum('filters', []);
        $pagination = $this->sentenceService->createLanguagePaginatedList($page, $language, $user, $filters);


        return $this->render(
            'quiz/sentencetranshu.html.twig',
            [
                'pagination' => $pagination,
                'user' => $user,
                'language' => $language,
            ]
        );
    }

    /**
     * Sentencehu action.
     *
     * @return Response
     *
     * @Route(
     *     "/sentencehu",
     *     methods={"GET"},
     *     name="quiz_sentencehu",
     * )
     */
    public function sentencehu(Request $request): Response
    {
        $user = $this->getUser();
        $language = $this->languageService->findOneByName('węgierski');
        $page = $request->query->getInt('page', 1);
        $filters = $request->query->getAlnum('filters', []);
        $pagination = $this->sentenceService->createLanguagePaginatedList($page, $language, $user, $filters);


        return $this->render(
            'quiz/sentencehu.html.twig',
            [
                'pagination' => $pagination,
                'user' => $user,
                'language' => $language,
            ]
        );
    }
}