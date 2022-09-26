<?php

namespace App\Entity;

use App\Repository\DireccionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DireccionRepository::class)
 */
class Direccion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $calle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numero;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $puertaPisoEscalera;

    /**
     * @ORM\Column(type="integer")
     */
    private $cod_postal;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCalle(): ?string
    {
        return $this->calle;
    }

    public function setCalle(string $calle): self
    {
        $this->calle = $calle;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getPuertaPisoEscalera(): ?string
    {
        return $this->puertaPisoEscalera;
    }

    public function setPuertaPisoEscalera(string $puertaPisoEscalera): self
    {
        $this->puertaPisoEscalera = $puertaPisoEscalera;

        return $this;
    }

    public function getCodPostal(): ?int
    {
        return $this->codPostal;
    }

    public function setCodPostal(int $codPostal): self
    {
        $this->codPostal = $codPostal;

        return $this;
    }
}
