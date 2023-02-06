<?php

namespace App\Entity;

use App\Repository\CoursesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CoursesRepository::class)
 */
class Courses
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $UE;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $courseKey;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getUE(): ?string
    {
        return $this->UE;
    }

    public function setUE(string $UE): self
    {
        $this->UE = $UE;

        return $this;
    }

    public function __toString() {

        return $this->getName();
      }

    public function getCourseKey(): ?string
    {
        return $this->courseKey;
    }

    public function setCourseKey(string $courseKey): self
    {
        $this->courseKey = $courseKey;

        return $this;
    }
}
