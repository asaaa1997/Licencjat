<?php
/**
 * Word entity.
 */

namespace App\Entity;

use App\Repository\WordRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Word.
 *
 * @ORM\Entity(repositoryClass=WordRepository::class)
 * @ORM\Table(name="words")
 *
 * @UniqueEntity(fields={"name"})
 */
class Word
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
     * Category.
     *
     * @var Category Category
     *
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="words")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * Language.
     *
     * @var Language Language
     *
     * @ORM\ManyToOne(targetEntity=Language::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $language;

    /**
     * Translations.
     *
     * @var array
     *
     * @ORM\ManyToMany(targetEntity=Translation::class, inversedBy="words")
     *
     * @ORM\JoinTable(name="words_translations")
     */
    private $translations;

    /**
     * Author.
     *
     * @var \App\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * Word constructor.
     */
    public function __construct()
    {
        $this->translations = new ArrayCollection();
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
     * Getter for Category.
     *
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * Setter for Category.
     *
     * @param Category|null $category
     */
    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }

    /**
     * Getter for Language.
     *
     * @return Language|null
     */
    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    /**
     * Setter for Language.
     *
     * @param Language|null $language
     */
    public function setLanguage(?Language $language): void
    {
        $this->language = $language;
    }

    /**
     * Getter for translations.
     *
     * @return Collection|Translation[]
     */
    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    /**
     * Add translation to collection.
     *
     * @param Translation $translation
     */
    public function addTranslation(Translation $translation): void
    {
        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation;
        }
    }

    /**
     * Remove translation from collection.
     *
     * @param Translation $translation
     */
    public function removeTranslation(Translation $translation): void
    {
        $this->translations->removeElement($translation);
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
