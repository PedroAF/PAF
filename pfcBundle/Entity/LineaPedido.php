<?php
// src/Paf/pfcBundle/Entity/LineaPedido.php
namespace Paf\pfcBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table()
 */
class LineaPedido
{    
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Pedido")
     */
    protected $pedido;
    //falta , inversedBy="productos"   ??¿?¿

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Producto")
     */
    protected $producto;

    /** @ORM\Column(type="integer") 
     * @Assert\Type("integer")
     * @Assert\Min(1)
     */
    protected $cantidad = 1;

    /** @ORM\Column(type="decimal", scale = 2) 
     * @Assert\Type("decimal")
     * @Assert\Min(0)
     */
    protected $precioPagado;

    public function __construct(Pedido $pedido, Producto $producto, $cantidad )
    {
        $this->cantidad = $cantidad;
        $this->pedido = $pedido;
        $this->producto = $producto;
        $this->precioPagado = $producto->getPrecioActual();
    }


    /**
     * Set precioPagado
     * @param decimal $precioPagado
     */
    public function setPrecioPagado($precioPagado)
    {
        $this->precioPagado = $precioPagado;
    }

    /**
     * Get precioPagado
     * @return decimal 
     */
    public function getPrecioPagado()
    {
        return $this->precioPagado;
    }

    /**
     * Set pedido
     * @param Paf\pfcBundle\Entity\Pedido $pedido
     */
    public function setPedido(\Paf\pfcBundle\Entity\Pedido $pedido)
    {
        $this->pedido = $pedido;
    }

    /**
     * Get pedido
     * @return Paf\pfcBundle\Entity\Pedido
     */
    public function getPedido()
    {
        return $this->pedido;
    }

    /**
     * Set Producto
     * @param Paf\pfcBundle\Entity\Producto $producto
     */
    public function setProducto(\Paf\pfcBundle\Entity\Producto $producto)
    {
        $this->producto = $producto;
    }

    /**
     * Get producto
     * @return Paf\pfcBundle\Entity\Producto
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Set cantidad
     * @param integer $cantidad
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    /**
     * Get cantidad
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }
    
}