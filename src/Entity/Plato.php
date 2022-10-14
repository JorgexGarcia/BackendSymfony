<?php

namespace App\Entity;

use App\Repository\PlatoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlatoRepository::class)
 */
class Plato
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
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagenUrl;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurante::class, inversedBy="platos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $restaurante;

    /**
     * @ORM\ManyToMany(targetEntity=Alergeno::class)
     */
    private $alergenos;

    /**
     * @ORM\OneToMany(targetEntity=CantidadPlatosPedido::class, mappedBy="plato", orphanRemoval=false)
     */
    private $cantidadPlato;

    /**
     * @ORM\Column(type="float")
     */
    private $precio;

    public function __construct()
    {
        $this->alergenos = new ArrayCollection();
        $this->cantidadPlato = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getImagenUrl(): ?string
    {
        return $this->imagenUrl;
    }

    public function setImagenUrl(?string $imagenUrl): self
    {
        $this->imagenUrl = $imagenUrl;

        return $this;
    }

    public function getRestaurante(): ?Restaurante
    {
        return $this->restaurante;
    }

    public function setRestaurante(?Restaurante $restaurante): self
    {
        $this->restaurante = $restaurante;

        return $this;
    }

    /**
     * @return Collection<int, Alergeno>
     */
    public function getAlergenos(): Collection
    {
        return $this->alergenos;
    }

    public function addAlergeno(Alergeno $alergeno): self
    {
        if (!$this->alergenos->contains($alergeno)) {
            $this->alergenos[] = $alergeno;
        }

        return $this;
    }

    public function removeAlergeno(Alergeno $alergeno): self
    {
        $this->alergenos->removeElement($alergeno);

        return $this;
    }

    /**
     * @return Collection<int, CantidadPlatosPedido>
     */
    public function getCantidadPlato(): Collection
    {
        return $this->cantidadPlato;
    }

    public function addCantidadPlato(CantidadPlatosPedido $cantidadPlato): self
    {
        if (!$this->cantidadPlato->contains($cantidadPlato)) {
            $this->cantidadPlato[] = $cantidadPlato;
            $cantidadPlato->setPlato($this);
        }

        return $this;
    }

    public function removeCantidadPlato(CantidadPlatosPedido $cantidadPlato): self
    {
        if ($this->cantidadPlato->removeElement($cantidadPlato)) {
            // set the owning side to null (unless already changed)
            if ($cantidadPlato->getPlato() === $this) {
                $cantidadPlato->setPlato(null);
            }
        }

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }
}
