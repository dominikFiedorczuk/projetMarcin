<?php

namespace App\Entity;

use App\Repository\FoldersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FoldersRepository::class)
 */
class Folders
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Images::class, mappedBy="folder")
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity=ImagesCompare::class, mappedBy="folder")
     */
    private $imagesCompares;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->imagesCompares = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Images[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setFolder($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getFolder() === $this) {
                $image->setFolder(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ImagesCompare[]
     */
    public function getImagesCompares(): Collection
    {
        return $this->imagesCompares;
    }

    public function addImagesCompare(ImagesCompare $imagesCompare): self
    {
        if (!$this->imagesCompares->contains($imagesCompare)) {
            $this->imagesCompares[] = $imagesCompare;
            $imagesCompare->setFolder($this);
        }

        return $this;
    }

    public function removeImagesCompare(ImagesCompare $imagesCompare): self
    {
        if ($this->imagesCompares->contains($imagesCompare)) {
            $this->imagesCompares->removeElement($imagesCompare);
            // set the owning side to null (unless already changed)
            if ($imagesCompare->getFolder() === $this) {
                $imagesCompare->setFolder(null);
            }
        }

        return $this;
    }
}
