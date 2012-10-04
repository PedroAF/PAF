<?php
namespace Paf\pfcBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class Carrito
{
    //KK1 Tendre que usar algun tipo de identificador, lo mejor sera usar el campo usuario de symfony
    // ya que aun con anonimo utiliza un identificador unico para cada anonimo.
    // SesionID
    
    /*
    protected $id;
    protected $cliente; */

    /**es linea carrito*/
    protected $productos;
    
    
    /**
     * @Assert\Type("boolean")
    */
    protected $pasadoApedido = false;
    
    /** 
     * @Assert\Date()
     */
    protected $created;
    
    public function __construct()
    {
        $this->productos = new ArrayCollection();
        $this->created = new \DateTime("now");
    }

    /**
     * Add productos
     * @param Paf\pfcBundle\Entity\LineaCarrito $productos
     */
    public function addItems(\Paf\pfcBundle\Entity\LineaCarrito $productos)
    {
        $this->productos[] = $productos;
    }

    /**
     * Get productos
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getProductos()
    {
        return $this->productos;
    }

    /**
     * Add productos
     * @param Paf\pfcBundle\Entity\LineaCarrito $productos
     */
    public function addProductos(\Paf\pfcBundle\Entity\LineaCarrito $productos)
    {
        $this->productos[] = $productos;
    }
    
    /**
     * Get PrecioTotal
     * @param decimal $price
     */
    public function getPrecioTotal()
    {
        $price = 0.00;
        foreach($this->productos as $producto){
            $price = $price + ($producto->getPrecioPagado() * $producto->getCantidad());
        }
        return $price;
    }

    /**
     * Set pasadoApedido
     * @param boolean $pasadoApedido
     */
    public function setPasadoApedido($pasadoApedido)
    {
        $this->pasadoApedido = $pasadoApedido;
    }

    /**
     * Get pasadoApedido
     * @return boolean 
     */
    public function getPasadoApedido()
    {
        return $this->pasadoApedido;
    }

    /**
     * Set created
     * @param datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     * @return datetime 
     */
    public function getCreated()
    {
        return $this->created;
    }
    
    /**
     * Get id
     * @return integer 
    public function getId()
    {
        return $this->id;
    }
     */
    
    /**
     * Set cliente
     * @param Paf\pfcBundle\Entity\Cliente $cliente
    public function setCliente(\Paf\pfcBundle\Entity\Cliente $cliente)
    {
        $this->cliente = $cliente;
    }
    /**
     * Get cliente
     * @return Paf\pfcBundle\Entity\Cliente 
    public function getCliente()
    {
        return $this->cliente;
    }
     */
    
}
