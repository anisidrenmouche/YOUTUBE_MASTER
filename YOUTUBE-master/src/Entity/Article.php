<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

   /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     * min = 5,
     * max = 255,
     * minMessage = "Bolos ton Titre est trop court {{ limit }} characters minumunm",
     * maxMessage = "Bolos ton Titre est trop long {{ limit }} characters")
     * 
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     * min = 10,
     * max = 255,
     * minMessage = "NON NON ton contenu est trop court {{ limit }} characters minumunm",
     * maxMessage = "Bolos ton Titre est trop long {{ limit }} characters")
     * 
     */
    private $content;

    /**
     * @Assert\Url()
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     * 
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
