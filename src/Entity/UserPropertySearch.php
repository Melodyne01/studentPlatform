<?php

namespace App\Entity;


class UserPropertySearch{

    /**
     * @var string|null
     */
    
    private $username;

    /** 
     * @var string|null
    */
    
    private $class;

    /** 
     * @var string|null
    */
    
    private $type;

     public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(string $class): self
    {
        $this->class = $class;

        return $this;
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
    
}
?>