<?php

namespace App\Entity;

use App\Repository\UERepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UERepository::class)
 */
class UE
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
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 0,
     *      notInRangeMessage = "You must be over 0 to enter",
     * )
     */
    private $Cr_Nbr;

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

    public function getCrNbr(): ?int
    {
        return $this->Cr_Nbr;
    }

    public function setCrNbr(int $Cr_Nbr): self
    {
        $this->Cr_Nbr = $Cr_Nbr;

        return $this;
    }
    public function __toString() {

        return $this->getName();
      }
}
