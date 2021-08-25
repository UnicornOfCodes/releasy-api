<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="projects")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Git::class, mappedBy="project", orphanRemoval=true)
     */
    private $gits;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->gits = new ArrayCollection();
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
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }

    /**
     * @return Collection|Git[]
     */
    public function getGits(): Collection
    {
        return $this->gits;
    }

    public function addGit(Git $git): self
    {
        if (!$this->gits->contains($git)) {
            $this->gits[] = $git;
            $git->setProject($this);
        }

        return $this;
    }

    public function removeGit(Git $git): self
    {
        if ($this->gits->removeElement($git)) {
            // set the owning side to null (unless already changed)
            if ($git->getProject() === $this) {
                $git->setProject(null);
            }
        }

        return $this;
    }
}
