<?php
/**
 * Sentence entity.
 */

namespace App\Entity;

use App\Repository\SentenceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Sentence.
 *
 * @ORM\Entity(repositoryClass=SentenceRepository::class)
 * @ORM\Table(name="sentences")
 *
 * @UniqueEntity(fields={"name"})
 */
class Sentence
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
     * @ORM\Column(type="text")
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     * )
     */
    private $name;

    /**
     * Translation.
     *
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     * )
     */
    private $translation;

    /**
     * Category.
     *
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="sentences")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * Language.
     *
     * @ORM\ManyToOne(targetEntity=Language::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $language;

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
     * Getter for Translation.
     *
     * @return string|null Name
     */
    public function getTranslation(): ?string
    {
        return $this->translation;
    }

    /**
     * Setter for Translation.
     *
     * @param string $translation Translation
     */
    public function setTranslation(string $translation): void
    {
        $this->translation = $translation;
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
