<?php

namespace App\Entity;

use App\Repository\RegistrationToCourseRepository;
use Symfony\Component\Form\FormTypeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RegistrationToCourseRepository::class)
 */
class RegistrationToCourse
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
    private $Student;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Course;

    private $courseKey;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?string
    {
        return $this->Student;
    }

    public function setStudent(string $Student): self
    {
        $this->Student = $Student;

        return $this;
    }

    public function getCourse(): ?string
    {
        return $this->Course;
    }

    public function setCourse(string $Course): self
    {
        $this->Course = $Course;

        return $this;
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
    public function __toString() {

        return $this->getCourse();
      }
}
