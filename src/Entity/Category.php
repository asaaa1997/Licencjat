<?php
/**
 * Category entity.
 */
namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Category.
 *
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @ORM\Table(name="categories")
 *
 * @UniqueEntity(fields={"name"})
 */
class Category
{
    /**
     * Primary key.
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
     * @ORM\Column(type="string", length=64)
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="64",
     * )
     */
    private $name;

    /**
     * Words.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection|\App\Entity\Word[] $words Words
     *
     * @ORM\OneToMany(targetEntity=Word::class, mappedBy="category")
     */
    private $words;

    /**
     * Sentences.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection|\App\Entity\Sentence[] $sentences Sentences
     *
     * @ORM\OneToMany(targetEntity=Sentence::class, mappedBy="category")
     */
    private $sentences;

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
     * Category constructor.
     */
    public function __construct()
    {
        $this->words = new ArrayCollection();
        $this->sentences = new ArrayCollection();
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
     * Getter for Words.
     *
     * @return Collection|Word[]
     */
    public function getWords(): Collection
    {
        return $this->words;
    }

    /**
     * Add Word.
     *
     * @param Word $word
     * @return $this
     */
    public function addWord(Word $word): self
    {
        if (!$this->words->contains($word)) {
            $this->words[] = $word;
            $word->setCategory($this);
        }

        return $this;
    }

    /**
     * Remove Word.
     *
     * @param Word $word
     * @return $this
     */
    public function removeWord(Word $word): self
    {
        if ($this->words->removeElement($word)) {
            // set the owning side to null (unless already changed)
            if ($word->getCategory() === $this) {
                $word->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * Getter for Sentences.
     *
     * @return Collection|Sentence[]
     */
    public function getSentences(): Collection
    {
        return $this->sentences;
    }

    /**
     * Add Sentence.
     *
     * @param Sentence $sentence
     * @return $this
     */
    public function addSentence(Sentence $sentence): self
    {
        if (!$this->sentences->contains($sentence)) {
            $this->sentences[] = $sentence;
            $sentence->setCategory($this);
        }

        return $this;
    }

    /**
     * Remove Sentence.
     *
     * @param Sentence $sentence
     * @return $this
     */
    public function removeSentence(Sentence $sentence): self
    {
        if ($this->sentences->removeElement($sentence)) {
            // set the owning side to null (unless already changed)
            if ($sentence->getCategory() === $this) {
                $sentence->setCategory(null);
            }
        }

        return $this;
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
