<?php
namespace Paf\pfcBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class LineaCarrito
{
    //Es relativamente inecesario 
    protected $carrito;

    /**
     */
    protected $producto;

    /** 
     * @Assert\Type("integer")
     * @Assert\Min(1)
     */
    protected $cantidad = 1;

    /**
     * @Assert\Type("decimal")
     * @Assert\Min(0)
     */
    protected $precioPagado;

    public function __construct(Carrito $carrito, Producto $producto, $cantidad )
    {
        $this->carrito = $carrito;
        $this->producto = $producto;
        $this->cantidad = $cantidad;
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

