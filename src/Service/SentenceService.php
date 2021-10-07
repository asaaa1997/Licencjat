<?php
/**
 * Sentence service.
 */

namespace App\Service;


use App\Entity\Language;
use App\Entity\Sentence;
use App\Repository\SentenceRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class SentenceService.
 */
class SentenceService
{
    /**
     * Sentence repository.
     *
     * @var \App\Repository\SentenceRepository
     */
    private $sentenceRepository;

    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface
     */
    private $paginator;

    /**
     * Category service.
     *
     * @var \App\Service\CategoryService
     */
    private $categoryService;

    /**
     * Language service.
     *
     * @var \App\Service\LanguageService
     */
    private $languageService;

    /**
     * SentenceService constructor.
     *
     * @param SentenceRepository $sentenceRepository
     * @param PaginatorInterface $paginator
     * @param CategoryService $categoryService
     * @param LanguageService $languageService
     */
    public function __construct(SentenceRepository $sentenceRepository, PaginatorInterface $paginator, CategoryService $categoryService, LanguageService $languageService)
    {
        $this->sentenceRepository = $sentenceRepository;
        $this->paginator = $paginator;
        $this->categoryService = $categoryService;
        $this->languageService = $languageService;
    }

    /**
     * Create author paginated list.
     *
     * @param int $page
     * @param UserInterface $user
     * @param array $filters
     *
     * @return PaginationInterface
     */
    public function createAuthorPaginatedList(int $page, UserInterface $user, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->sentenceRepository->queryByAuthor($user, $filters),
            $page,
            SentenceRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Create language paginated list.
     *
     * @param int $page
     * @param Language $language
     * @param UserInterface $user
     * @param array $filters
     *
     * @return PaginationInterface
     */
    public function createLanguagePaginatedList(int $page, Language $language, UserInterface $user, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->sentenceRepository->queryByLanguage($language, $user, $filters),
            $page,
            SentenceRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save sentence.
     *
     * @param Sentence $sentence
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Sentence $sentence): void
    {
        $this->sentenceRepository->save($sentence);
    }

    /**
     * Delete sentence.
     *
     * @param Sentence $sentence
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Sentence $sentence): void
    {
        $this->sentenceRepository->delete($sentence);
    }

    /**
     * Prepare filters for the sentences list.
     *
     * @param array $filters Raw filters from request
     *
     * @return array Result array of filters
     */
    private function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (isset($filters['category']) && is_numeric($filters['category'])) {
            $category = $this->categoryService->findOneById(
                $filters['category']
            );
            if (null !== $category) {
                $resultFilters['category'] = $category;
            }
        }

        if (isset($filters['language']) && is_numeric($filters['language'])) {
            $language = $this->languageService->findOneById(
                $filters['language']
            );
            if (null !== $language) {
                $resultFilters['language'] = $language;
            }
        }

        return $resultFilters;
    }
}