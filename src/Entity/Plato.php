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
     * @ORM\Column(type="integer")
     */
    private $precio;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurante::class, inversedBy="plato")
     */
    private $restaurante;

    /**
     * @ORM\ManyToMany(targetEntity=Alergenos::class)
     */
    private $alergenos;

    /**
     * @ORM\OneToMany(targetEntity=Pedido::class, mappedBy="platos")
     */
    private $pedidos;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantidad;

    public function __construct()
    {
        $this->alergenos = new ArrayCollection();
        $this->pedidos = new ArrayCollection();
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

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getImagenUrl(): ?string
    {
        return $this->imagenUrl;
    }

    public function setImagenUrl(string $imagenUrl): self
    {
        $this->imagenUrl = $imagenUrl;

        return $this;
    }

    public function getPrecio(): ?int
    {
        return $this->precio;
    }

    public function setPrecio(int $precio): self
    {
        $this->precio = $precio;

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
     * @return Collection<int, Alergenos>
     */
    public function getAlergenos(): Collection
    {
        return $this->alergenos;
    }

    public function addAlergeno(Alergenos $alergeno): self
    {
        if (!$this->alergenos->contains($alergeno)) {
            $this->alergenos[] = $alergeno;
        }

        return $this;
    }

    public function removeAlergeno(Alergenos $alergeno): self
    {
        $this->alergenos->removeElement($alergeno);

        return $this;
    }

    /**
     * @return Collection<int, Pedido>
     */
    public function getPedidos(): Collection
    {
        return $this->pedidos;
    }

    public function addPedido(Pedido $pedido): self
    {
        if (!$this->pedidos->contains($pedido)) {
            $this->pedidos[] = $pedido;
            $pedido->setPlatos($this);
        }

        return $this;
    }

    public function removePedido(Pedido $pedido): self
    {
        if ($this->pedidos->removeElement($pedido)) {
            // set the owning side to null (unless already changed)
            if ($pedido->getPlatos() === $this) {
                $pedido->setPlatos(null);
            }
        }

        return $this;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }
}
