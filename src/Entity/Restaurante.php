<?php

namespace App\Entity;

use App\Repository\RestauranteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RestauranteRepository::class)
 */
class Restaurante
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
    private $logoUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagenUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $destacado;

    /**
     * @ORM\OneToMany(targetEntity=Plato::class, mappedBy="restaurante", orphanRemoval=true)
     */
    private $plato;

    /**
     * @ORM\OneToMany(targetEntity=Horario::class, mappedBy="restaurante", orphanRemoval=true)
     */
    private $horario;

    /**
     * @ORM\ManyToMany(targetEntity=Categoria::class)
     */
    private $categoria;

    /**
     * @ORM\OneToMany(targetEntity=Pedido::class, mappedBy="restaurante", orphanRemoval=true)
     */
    private $pedidos;

    public function __construct()
    {
        $this->plato = new ArrayCollection();
        $this->horario = new ArrayCollection();
        $this->categoria = new ArrayCollection();
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

    public function getLogoUrl(): ?string
    {
        return $this->logoUrl;
    }

    public function setLogoUrl(string $logoUrl): self
    {
        $this->logoUrl = $logoUrl;

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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function isDestacado(): ?bool
    {
        return $this->destacado;
    }

    public function setDestacado(bool $destacado): self
    {
        $this->destacado = $destacado;

        return $this;
    }

    /**
     * @return Collection<int, Plato>
     */
    public function getPlato(): Collection
    {
        return $this->plato;
    }

    public function addPlato(Plato $plato): self
    {
        if (!$this->plato->contains($plato)) {
            $this->plato[] = $plato;
            $plato->setRestaurante($this);
        }

        return $this;
    }

    public function removePlato(Plato $plato): self
    {
        if ($this->plato->removeElement($plato)) {
            // set the owning side to null (unless already changed)
            if ($plato->getRestaurante() === $this) {
                $plato->setRestaurante(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Horario>
     */
    public function getHorario(): Collection
    {
        return $this->horario;
    }

    public function addHorario(Horario $horario): self
    {
        if (!$this->horario->contains($horario)) {
            $this->horario[] = $horario;
            $horario->setRestaurante($this);
        }

        return $this;
    }

    public function removeHorario(Horario $horario): self
    {
        if ($this->horario->removeElement($horario)) {
            // set the owning side to null (unless already changed)
            if ($horario->getRestaurante() === $this) {
                $horario->setRestaurante(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Categoria>
     */
    public function getCategoria(): Collection
    {
        return $this->categoria;
    }

    public function addCategorium(Categoria $categorium): self
    {
        if (!$this->categoria->contains($categorium)) {
            $this->categoria[] = $categorium;
        }

        return $this;
    }

    public function removeCategorium(Categoria $categorium): self
    {
        $this->categoria->removeElement($categorium);

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
            $pedido->setRestaurante($this);
        }

        return $this;
    }

    public function removePedido(Pedido $pedido): self
    {
        if ($this->pedidos->removeElement($pedido)) {
            // set the owning side to null (unless already changed)
            if ($pedido->getRestaurante() === $this) {
                $pedido->setRestaurante(null);
            }
        }

        return $this;
    }

}
