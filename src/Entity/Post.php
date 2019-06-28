<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @Assert\NotBlank(message="Please enter the post title")
     * @ORM\Column(type="string", length=255)
     */
    private $title;
    /**
     * @Assert\NotBlank(message="Please enter the description")
     * @ORM\Column(type="text")
     */
    private $description;
    /**
     * @Assert\NotBlank(message="Please enter the post body")
     * @ORM\Column(type="text", )
     */
    private $body;
    /**
     * @ORM\Column(type="date", )
     */
    private $creationDate;
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="post")
     */
    public $comments;
    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $updatedDate;
    /**
     * @var UploadedFile
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload the picture")
     * @Assert\File(mimeTypes={ "image/png" })
     */
    private $img;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", mappedBy="posts")
     */
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $updatedDate): self
    {
        $this->creationDate = $updatedDate;
        return $this;
    }

    public function getUpdatedDate(): ?\DateTimeInterface
    {
        return $this->updatedDate;
    }

    public function setUpdatedDate(\DateTimeInterface $updatedDate): self
    {
        $this->updatedDate = $updatedDate;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getComments(): ArrayCollection
    {
        return $this->comments;
    }

    /**
     * @param ArrayCollection $comments
     */
    public function setComments(ArrayCollection $comments): void
    {
        $this->comments = $comments;
    }

    public function addComments(Comment $comment): void
    {
        $this->comments->add($comment);
    }

    public function getImg()
    {
        return $this->img;
    }

    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body): void
    {
        $this->body = $body;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addPost($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
            $tag->removePost($this);
        }

        return $this;
    }

}
