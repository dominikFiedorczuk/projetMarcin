<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImagesRepository::class)
 */
class Images
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Folders::class, inversedBy="images")
     */
    private $folder;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $localPath;

    public function getId(): ?int
    {
        return $this->id;
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
}
