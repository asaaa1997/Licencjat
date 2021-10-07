<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Language;
use App\Entity\Sentence;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sentence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sentence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sentence[]    findAll()
 * @method Sentence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SentenceRepository extends ServiceEntityRepository
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
    const PAGINATOR_ITEMS_PER_PAGE = 3;

    /**
     * SentenceRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sentence::class);
    }

    /**
     * Query sentences by author.
     *
     * @param User $user
     * @param array $filters
     *
     * @return QueryBuilder
     */
    public function queryByAuthor(User $user, array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->queryAll($filters);

        $queryBuilder->andWhere('sentence.author = :author')
            ->setParameter('author', $user);

        return $queryBuilder;
    }

    /**
     * Query sentences by language.
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

        $queryBuilder->andWhere('sentence.language = :language')
            ->setParameter('language', $language);

        return $queryBuilder;
    }

    /**
     * Query all records.
     *
     * @param array $filters
     *
     * @return QueryBuilder
     */
    public function queryAll(array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->getOrCreateQueryBuilder()
            ->join('sentence.category', 'category')
            ->join('sentence.language', 'language')
            ->orderBy('sentence.id', 'DESC');

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
     * @param \App\Entity\Sentence $sentence Sentence entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Sentence $sentence): void
    {
        $this->_em->persist($sentence);
        $this->_em->flush();
    }

    /**
     * Delete record.
     *
     * @param \App\Entity\Sentence $sentence Sentence entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Sentence $sentence): void
    {
        $this->_em->remove($sentence);
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
        return $queryBuilder ?? $this->createQueryBuilder('sentence');
    }

}
