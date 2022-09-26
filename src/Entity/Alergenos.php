<?php

namespace App\Entity;

use App\Repository\AlergenosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlergenosRepository::class)
 */
class Alergenos
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
    private $alergenos;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlergenos(): ?string
    {
        return $this->alergenos;
    }

    public function setAlergenos(string $alergenos): self
    {
        $this->alergenos = $alergenos;

        return $this;
    }
}
