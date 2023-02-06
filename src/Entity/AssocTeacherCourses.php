<?php

namespace App\Entity;

use App\Repository\AssocTeacherCoursesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AssocTeacherCoursesRepository::class)
 */
class AssocTeacherCourses
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
    private $Course;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Teacher;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTeacher(): ?string
    {
        return $this->Teacher;
    }

    public function setTeacher(string $Teacher): self
    {
        $this->Teacher = $Teacher;

        return $this;
    }
    public function __toString() {

        return $this->getCourse();
    }
}
