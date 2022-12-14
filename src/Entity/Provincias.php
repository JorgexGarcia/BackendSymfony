<?php

namespace App\Entity;

use App\Repository\ProvinciasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Provincias
 *
 * @ORM\Table(name="provincias")
 * @ORM\Entity(repositoryClass=ProvinciasRepository::class)
 */
class Provincias
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="provincia", type="string", length=255, nullable=false)
     */
    private $provincia;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProvincia(): ?string
    {
        return $this->provincia;
    }

    public function setProvincia(string $provincia): self
    {
        $this->provincia = $provincia;

        return $this;
    }


}
