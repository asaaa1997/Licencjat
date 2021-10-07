<?php
/**
 * Language service.
 */

namespace App\Service;

use App\Entity\Language;
use App\Repository\LanguageRepository;

/**
 * Class LanguageService.
 */
class LanguageService
{
    /**
     * Language repository.
     *
     * @var \App\Repository\LanguageRepository
     */
    private $languageRepository;

    /**
     * LanguageService constructor.
     *
     * @param LanguageRepository $languageRepository
     */
    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    /**
     * Find language by Id.
     *
     * @param int $id Language Id
     *
     * @return \App\Entity\Language|null Language entity
     */
    public function findOneById(int $id): ?Language
    {
        return $this->languageRepository->findOneById($id);
    }

    /**
     * Find one by name.
     *
     * @param string $value
     *
     * @return Language
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByName(string $value): Language
    {
        return $this->languageRepository->findOneByName($value);
    }
}