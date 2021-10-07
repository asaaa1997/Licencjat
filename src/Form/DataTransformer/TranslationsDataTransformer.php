<?php
/**
 * Translations data transformer.
 */

namespace App\Form\DataTransformer;

use App\Entity\Translation;
use App\Repository\TranslationRepository;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class TranslationsDataTransformer.
 */
class TranslationsDataTransformer implements DataTransformerInterface
{
    /**
     * Translation repository.
     *
     * @var \App\Repository\TranslationRepository
     */
    private $repository;

    /**
     * TranslationsDataTransformer constructor.
     *
     * @param \App\Repository\TranslationRepository $repository Translation repository
     */
    public function __construct(TranslationRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Transform array of translations to string of names.
     *
     * @param \Doctrine\Common\Collections\Collection $translations Translations entity collection
     *
     * @return string Result
     */
    public function transform($translations): string
    {
        if (null == $translations) {
            return '';
        }

        $translationNames = [];

        foreach ($translations as $translation) {
            $translationNames[] = $translation->getName();
        }

        return implode(', ', $translationNames);
    }

    /**
     * Transform string of translation names into array of Translation entities.
     *
     * @param string $value String of translation names
     *
     * @return array Result
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function reverseTransform($value): array
    {
        $translationNames = explode(', ', $value);

        $translations = [];

        foreach ($translationNames as $translationName) {
            if ('' !== trim($translationName)) {
                $translation = $this->repository->findOneByName(strtolower($translationName));
                if (null == $translation) {
                    $translation = new Translation();
                    $translation->setName($translationName);
                    $this->repository->save($translation);
                }
                $translations[] = $translation;
            }
        }

        return $translations;
    }
}