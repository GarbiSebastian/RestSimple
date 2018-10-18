<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactoRepository")
 */
class Contacto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Apellido;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $createdAt;

//    public function getId(): ?int
    public function getId()
    {
        return $this->id;
    }

//    public function getNombre(): ?string
    public function getNombre()
    {
        return $this->nombre;
    }

//    public function setNombre(string $nombre): self
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

//    public function getApellido(): ?string
    public function getApellido()
    {
        return $this->Apellido;
    }

//    public function setApellido(?string $Apellido): self
    public function setApellido($Apellido)
    {
        $this->Apellido = $Apellido;

        return $this;
    }

//    public function getEmail(): ?string
    public function getEmail()
    {
        return $this->email;
    }

//    public function setEmail(string $email): self
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

//    public function getCreatedAt(): ?\DateTimeImmutable
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

//    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    public function setCreatedAt(\DateTimeImmutable $createdAt=null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
