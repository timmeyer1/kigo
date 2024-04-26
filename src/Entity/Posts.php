<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdsRepository;
use App\Repository\PostsRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\JoinTable;
use Vich\UploaderBundle\Mapping\Annotation as Vich;



#[ORM\Entity(repositoryClass: PostsRepository::class)]
class Posts
{

    #[Vich\UploadableField(mapping: 'house', fileNameProperty: 'imagePath')]
    private ?File $imageFile = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToOne]
    private ?User $user_id = null;

    #[ORM\ManyToMany(targetEntity: Section::class, inversedBy: 'posts')]
    private Collection $section_id;

    #[ORM\OneToMany(mappedBy: 'posts', targetEntity: Image::class)]
    private Collection $image;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    private ?Type $typeId = null;

    #[ORM\Column(length: 255)]
    private ?string $imagePath = null;

    #[ORM\ManyToMany(targetEntity: User::class)]
    #[JoinTable('user_post_like')]
    private Collection $likes;

    public function __construct()
    {
        $this->section_id = new ArrayCollection();
        $this->image = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return Collection<int, Section>
     */
    public function getSectionId(): Collection
    {
        return $this->section_id;
    }

    public function addSectionId(Section $sectionId): static
    {
        if (!$this->section_id->contains($sectionId)) {
            $this->section_id->add($sectionId);
        }

        return $this;
    }

    public function removeSectionId(Section $sectionId): static
    {
        $this->section_id->removeElement($sectionId);

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(Image $image): static
    {
        if (!$this->image->contains($image)) {
            $this->image->add($image);
            $image->setPosts($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->image->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getPosts() === $this) {
                $image->setPosts(null);
            }
        }

        return $this;
    }

    public function getTypeId(): ?Type
    {
        return $this->typeId;
    }

    public function setTypeId(?Type $typeId): static
    {
        $this->typeId = $typeId;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): static
    {
        $this->imagePath = $imagePath;

        return $this;
    }
    
    public function getImageFile(): ?string
    {
        return $this->imageFile;
    }

    public function setImageFile(string $imageFile): static
    {
        $this->imageFile = $imageFile;

        return $this;
    }

    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(User $like): self
    {
        if(!$this->likes->contains($like)) {
            $this->likes[] = $like;
        }

        return $this;
    }

    public function removeLike(User $like): self
    {
        $this->likes->removeElement($like);

        return $this;
    }

    public function isLikedByUser(User $user): bool
    {
        return $this->likes->contains($user);
    }

}
