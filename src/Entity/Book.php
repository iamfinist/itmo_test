<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[UniqueEntity(
    fields: ['name', 'isbn'],
    message: 'The book with this combination of name and ISBN already exists.',
    errorPath: 'name',
)]
#[UniqueEntity(
    fields: ['publication_year', 'isbn'],
    message: 'The book with this combination of publication year and ISBN already exists.',
    errorPath: 'publication_year',
)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $publication_year = null;

    #[ORM\Column(length: 255)]
    #[Assert\Isbn]
    private ?string $isbn = null;

    #[ORM\Column]
    private ?int $pages_count = null;

    #[ORM\ManyToMany(targetEntity: Author::class, inversedBy: 'books')]
    #[Assert\Count(min: 1, minMessage: "You must specify at least one author.")]
    private Collection $authors;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPublicationYear(): ?int
    {
        return $this->publication_year;
    }

    public function setPublicationYear(int $publication_year): static
    {
        $this->publication_year = $publication_year;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getPagesCount(): ?int
    {
        return $this->pages_count;
    }

    public function setPagesCount(int $pages_count): static
    {
        $this->pages_count = $pages_count;

        return $this;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(Author $author): static
    {
        if (!$this->authors->contains($author)) {
            $this->authors->add($author);
        }

        return $this;
    }

    public function removeAuthor(Author $author): static
    {
        $this->authors->removeElement($author);

        return $this;
    }

    public function __toString() {
        return $this->name;
    }
}
