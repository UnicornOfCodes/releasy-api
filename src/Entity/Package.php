<?php

namespace App\Entity;

use App\Repository\PackageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PackageRepository::class)
 */
class Package
{
    const TYPE_COMPOSER = "composer";
    const TYPE_NPM      = "npm";
    const TYPE_YARN     = "yarn";

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $content = [];

    /**
     * @ORM\ManyToOne(targetEntity=Git::class, inversedBy="packages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $git;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $security = [];

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updateAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getContent(): ?array
    {
        return $this->content;
    }

    public function setContent(array $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getGit(): ?Git
    {
        return $this->git;
    }

    public function setGit(?Git $git): self
    {
        $this->git = $git;

        return $this;
    }

    public function getSecurity(): ?array
    {
        return $this->security;
    }

    public function setSecurity(?array $security): self
    {
        $this->security = $security;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeImmutable $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }
}
