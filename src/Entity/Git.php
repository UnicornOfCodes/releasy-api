<?php

namespace App\Entity;

use App\Repository\GitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GitRepository::class)
 */
class Git
{
    const PROVIDER_GITLAB = "gitlab";

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $repositoryName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $baseUrl;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $provider;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="gits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $lastScanAt;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $members = [];

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $apiId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $branch;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fullUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $accessToken;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $lastPipelineStatus = [];

    /**
     * @ORM\OneToMany(targetEntity=Package::class, mappedBy="git", orphanRemoval=true)
     */
    private $packages;

    public function __construct()
    {
        $this->packages = new ArrayCollection();
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

    public function getRepositoryName(): ?string
    {
        return $this->repositoryName;
    }

    public function setRepositoryName(string $repositoryName): self
    {
        $this->repositoryName = $repositoryName;

        return $this;
    }

    public function getBaseUrl(): ?string
    {
        return $this->baseUrl;
    }

    public function setBaseUrl(string $baseUrl): self
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    public function getProvider(): ?string
    {
        return $this->provider;
    }

    public function setProvider(string $provider): self
    {
        $this->provider = $provider;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getLastScanAt(): ?\DateTimeImmutable
    {
        return $this->lastScanAt;
    }

    public function setLastScanAt(\DateTimeImmutable $lastScanAt): self
    {
        $this->lastScanAt = $lastScanAt;

        return $this;
    }

    public function getMembers(): ?array
    {
        return $this->members;
    }

    public function setMembers(?array $members): self
    {
        $this->members = $members;

        return $this;
    }

    public function getApiId(): ?int
    {
        return $this->apiId;
    }

    public function setApiId(?int $apiId): self
    {
        $this->apiId = $apiId;

        return $this;
    }

    public function getBranch(): ?string
    {
        return $this->branch;
    }

    public function setBranch(?string $branch): self
    {
        $this->branch = $branch;

        return $this;
    }

    public function getFullUrl(): ?string
    {
        return $this->fullUrl;
    }

    public function setFullUrl(?string $fullUrl): self
    {
        $this->fullUrl = $fullUrl;

        return $this;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function setAccessToken(?string $accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    public function getLastPipelineStatus(): ?array
    {
        return $this->lastPipelineStatus;
    }

    public function setLastPipelineStatus(?array $lastPipelineStatus): self
    {
        $this->lastPipelineStatus = $lastPipelineStatus;

        return $this;
    }

    /**
     * @return Collection|Package[]
     */
    public function getPackages(): Collection
    {
        return $this->packages;
    }

    public function addPackage(Package $package): self
    {
        if (!$this->packages->contains($package)) {
            $this->packages[] = $package;
            $package->setGit($this);
        }

        return $this;
    }

    public function removePackage(Package $package): self
    {
        if ($this->packages->removeElement($package)) {
            // set the owning side to null (unless already changed)
            if ($package->getGit() === $this) {
                $package->setGit(null);
            }
        }

        return $this;
    }
}
