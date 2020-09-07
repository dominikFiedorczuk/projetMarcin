<?php

namespace App\Entity;

use App\Repository\ImagesCompareRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImagesCompareRepository::class)
 */
class ImagesCompare
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
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $localPath;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $urlToCompare;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $localPathToCompare;

    /**
     * @ORM\ManyToOne(targetEntity=Folders::class, inversedBy="imagesCompares")
     */
    private $folder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getLocalPath(): ?string
    {
        return $this->localPath;
    }

    public function setLocalPath(string $localPath): self
    {
        $this->localPath = $localPath;

        return $this;
    }

    public function getUrlToCompare(): ?string
    {
        return $this->urlToCompare;
    }

    public function setUrlToCompare(string $urlToCompare): self
    {
        $this->urlToCompare = $urlToCompare;

        return $this;
    }

    public function getLocalPathToCompare(): ?string
    {
        return $this->localPathToCompare;
    }

    public function setLocalPathToCompare(string $localPathToCompare): self
    {
        $this->localPathToCompare = $localPathToCompare;

        return $this;
    }

    public function getFolder(): ?Folders
    {
        return $this->folder;
    }

    public function setFolder(?Folders $folder): self
    {
        $this->folder = $folder;

        return $this;
    }
}
