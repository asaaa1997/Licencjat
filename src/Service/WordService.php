<?php
/**
 * Word service.
 */

namespace App\Service;

use App\Entity\Language;
use App\Entity\Word;
use App\Repository\WordRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class WordService.
 */
class WordService
{
    /**
     * Word repository.
     *
     * @var \App\Repository\WordRepository
     */
    private $wordRepository;

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
     * WordService constructor.
     *
     * @param WordRepository $wordRepository
     * @param PaginatorInterface $paginator
     * @param CategoryService $categoryService
     * @param LanguageService $languageService
     */
    public function __construct(WordRepository $wordRepository, PaginatorInterface $paginator, CategoryService $categoryService, LanguageService $languageService)
    {
        $this->wordRepository = $wordRepository;
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
            $this->wordRepository->queryByAuthor($user, $filters),
            $page,
            WordRepository::PAGINATOR_ITEMS_PER_PAGE
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
            $this->wordRepository->queryByLanguage($language, $user, $filters),
            $page,
            WordRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save word.
     *
     * @param Word $word
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Word $word): void
    {
        $this->wordRepository->save($word);
    }

    /**
     * Delete word.
     *
     * @param Word $word
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Word $word): void
    {
        $this->wordRepository->delete($word);
    }

    /**
     * Prepare filters for the words list.
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