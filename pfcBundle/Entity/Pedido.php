<?php
//src/Paf/pfcBundle/Entity/Pedido.php
namespace Paf\pfcBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Paf\pfcBundle\Entity\PedidoRepository")
 */
class Pedido
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer") 
     * @ORM\GeneratedValue(strategy="AUTO") 
     */
    protected $id;
    
    /** 
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="pedidos")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     */
    protected $cliente;

    /** 
     * @ORM\OneToMany(targetEntity="LineaPedido", mappedBy="pedido") 
     */
    protected $productos;
    //targetEntity="LineaPedido", mappedBy="Pedido") 

    /** 
     * @ORM\Column(type="boolean") 
     */
    protected $pagado = false;
    
    /** 
     * @ORM\Column(type="boolean") 
     */
    protected $enviado = false;
    
    /** 
     * @ORM\Column(type="datetime") 
     * @Assert\Date()
     */
    protected $created;

    /**
     * @var text $direccion
     * @ORM\Column( type="text")
     */
    protected $direccion;    

    public function __construct()
    {
        $timezone = new \DateTimeZone("Europe/Madrid"); //$dt = new \DateTime("now", $timezone);
        $this->cliente = null;
        $this->productos = new ArrayCollection();
        $this->created = new \DateTime("now", $timezone);
    }

    /**
     * Add productos
     *
     * @param Paf\pfcBundle\Entity\LineaPedido $productos
     */
    public function addItems(\Paf\pfcBundle\Entity\LineaPedido $productos)
    {
        $this->productos[] = $productos;
    }

    /**
     * Get productos
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getProductos()
    {
        return $this->productos;
    }
    
    /**
     * Get PrecioTotal
     *
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set pagado
     *
     * @param boolean $pagado
     */
    public function setPagado($pagado)
    {
        $this->pagado = $pagado;
    }

    /**
     * Get pagado
     *
     * @return boolean 
     */
    public function getPagado()
    {
        return $this->pagado;
    }

    /**
     * Set enviado
     *
     * @param boolean $enviado
     */
    public function setEnviado($enviado)
    {
        $this->enviado = $enviado;
    }

    /**
     * Get enviado
     *
     * @return boolean 
     */
    public function getEnviado()
    {
        return $this->enviado;
    }

    /**
     * Set created
     *
     * @param datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return datetime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set direccion
     *
     * @param text $direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    /**
     * Get direccion
     *
     * @return text 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Add productos
     *
     * @param Paf\pfcBundle\Entity\LineaPedido $productos
     */
    public function addProductos(\Paf\pfcBundle\Entity\LineaPedido $productos)
    {
        $this->productos[] = $productos;
    }
    
    /**
     * Set cliente
     *
     * @param Paf\pfcBundle\Entity\Cliente $cliente
     */
    public function setCliente(\Paf\pfcBundle\Entity\Cliente $cliente)
    {
        $this->cliente = $cliente;
    }

    /**
     * Get cliente
     *
     * @return Paf\pfcBundle\Entity\Cliente 
     */
    public function getCliente()
    {
        return $this->cliente;
    }
    
    /**
     * Get fecha
     *
     * @return text $fecha 
     */
    public function getFecha()
    {
        $fecha = $this->created->format('d-m-y'); 
        //$fecha = $this->created->format('Y-m-d H:i:s');
        return $fecha; 
    }
    
    /**
     * Get fecha
     *
     * @return text $hora 
     */
    public function getHora()
    {
        $hora = $this->created->format('H:i');
        
        return $hora; 
    } 
}