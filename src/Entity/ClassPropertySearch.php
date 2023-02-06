<?php

namespace App\Entity;


class ClassPropertySearch{


    
    /** 
     * @var string|null
    */

    private $class;

    /** 
     * @var string|null
    */

    private $course;

    /** 
     * @var string|null
    */

    private $student;

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getCourse(): ?string
    {
        return $this->course;
    }

    public function setCourse(string $course): self
    {
        $this->course = $course;

        return $this;
    }

    public function getStudent(): ?string
    {
        return $this->student;
    }

    public function setStudent(string $student): self
    {
        $this->student = $student;

        return $this;
    }
    
}
?>