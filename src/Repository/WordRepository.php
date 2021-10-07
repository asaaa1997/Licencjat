<?php
/**
 * Word repository.
 */
namespace App\Repository;

use App\Entity\Category;
use App\Entity\Language;
use App\Entity\User;
use App\Entity\Word;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class WordRepository.
 */
class WordRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    const PAGINATOR_ITEMS_PER_PAGE = 5;

    /**
     * WordRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Word::class);
    }

    /**
     * Query words by author.
     *
     * @param User $user
     * @param array $filters
     *
     * @return QueryBuilder
     */
    public function queryByAuthor(User $user, array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->queryAll($filters);

        $queryBuilder->andWhere('word.author = :author')
            ->setParameter('author', $user);

        return $queryBuilder;
    }

    /**
     * Query words by language.
     *
     * @param Language $language
     * @param User $user
     * @param array $filters
     *
     * @return QueryBuilder
     */
    public function queryByLanguage(Language $language, User $user, array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->queryByAuthor($user, $filters);

        $queryBuilder->andWhere('word.language = :language')
            ->setParameter('language', $language);

        return $queryBuilder;
    }

    /**
     * Query all records.
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryAll(array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->getOrCreateQueryBuilder()
            ->select(
                'partial word.{id, name}',
                'partial category.{id, name}',
                'partial translations.{id, name}'
            )
            ->join('word.category', 'category')
            ->join('word.language', 'language')
            ->leftJoin('word.translations', 'translations')
            ->orderBy('word.id', 'DESC');

        $queryBuilder = $this->applyFiltersToList($queryBuilder, $filters);

        return $queryBuilder;
    }

    /**
     * Apply filters to paginated list.
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder
     * @param array                      $filters      Filters array
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    private function applyFiltersToList(QueryBuilder $queryBuilder, array $filters = []): QueryBuilder
    {
        if (isset($filters['category']) && $filters['category'] instanceof Category) {
            $queryBuilder->andWhere('category = :category')
                ->setParameter('category', $filters['category']);
        }

        if (isset($filters['language']) && $filters['language'] instanceof Language) {
            $queryBuilder->andWhere('language = :language')
                ->setParameter('language', $filters['language']);
        }

        return $queryBuilder;
    }

    /**
     * Save record.
     *
     * @param \App\Entity\Word $word Word entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Word $word): void
    {
        $this->_em->persist($word);
        $this->_em->flush();
    }

    /**
     * Delete record.
     *
     * @param \App\Entity\Word $word Word entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Word $word): void
    {
        $this->_em->remove($word);
        $this->_em->flush();
    }

    /**
     * Get or create new query builder.
     *
     * @param \Doctrine\ORM\QueryBuilder|null $queryBuilder Query builder
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('word');
    }
}
