<?php

namespace App\Entity;

use App\Repository\CantidadPlatosPedidoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CantidadPlatosPedidoRepository::class)
 */
class CantidadPlatosPedido
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantidad;

    /**
     * @ORM\ManyToOne(targetEntity=Pedido::class, inversedBy="lineaPedido")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pedido;

    /**
     * @ORM\ManyToOne(targetEntity=Plato::class, inversedBy="cantidadPlato")
     * @ORM\JoinColumn(nullable=false)
     */
    private $plato;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPedido(): ?Pedido
    {
        return $this->pedido;
    }

    public function setPedido(?Pedido $pedido): self
    {
        $this->pedido = $pedido;

        return $this;
    }

    public function getPlato(): ?Plato
    {
        return $this->plato;
    }

    public function setPlato(?Plato $plato): self
    {
        $this->plato = $plato;

        return $this;
    }
}
