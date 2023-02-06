<?php

namespace App\Entity;


class NotesPropertySearch{

    /**
     * @var string|null
     */
    
    private $course;

    /** 
     * @var string|null
    */
    
    private $user;
    
    /** 
     * @var string|null
    */

    private $note;

    private $apply;

     public function getCourse(): ?string
    {
        return $this->course;
    }

    public function setCourse(string $course): self
    {
        $this->course = $course;

        return $this;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }
    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getApply(): ?string
    {
        return $this->apply;
    }

    public function setApply(int $apply): self
    {
        $this->apply = $apply;

        return $this;
    }
    
}
?>