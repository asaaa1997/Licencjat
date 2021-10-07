<?php
/**
 * Translation entity.
 */
namespace App\Entity;

use App\Repository\TranslationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Translation.
 *
 * @ORM\Entity(repositoryClass=TranslationRepository::class)
 * @ORM\Table(name="translations")
 *
 * @UniqueEntity(fields={"name"})
 */
class Translation
{
    /**
     * Primary key.
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Name.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="100",
     * )
     */
    private $name;

    /**
     * Words.
     *
     * @var ArrayCollection|Word[] Words
     *
     * @ORM\ManyToMany(targetEntity=Word::class, mappedBy="translations")
     */
    private $words;

    /**
     * Translation constructor.
     */
    public function __construct()
    {
        $this->words = new ArrayCollection();
    }

    /**
     * Getter for Id.
     *
     * @return int|null Result
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Name.
     *
     * @return string|null Name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Setter for Name.
     *
     * @param string $name Name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Getter for words.
     *
     * @return Collection|Word[] Words collection
     */
    public function getWords(): Collection
    {
        return $this->words;
    }

    /**
     * Add word to collection.
     *
     * @param Word $word Word entity
     */
    public function addWord(Word $word): void
    {
        if (!$this->words->contains($word)) {
            $this->words[] = $word;
            $word->addTranslation($this);
        }
    }

    /**
     * Remove word from collection.
     *
     * @param Word $word Word entity
     */
    public function removeWord(Word $word): void
    {
        if ($this->words->removeElement($word)) {
            $word->removeTranslation($this);
        }
    }
}
