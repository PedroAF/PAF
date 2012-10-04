<?php
//Paf\pfcBundle\Entity\Musica
namespace Paf\pfcBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table()
 * @ORM\Entity
 */
class Musica extends Producto
{
    /**
     * @var integer $id
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $autor;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $discografica;
    /**
     * @var string $nombre
     */
    protected $nombre;

    /**
     * @var string $slug
     */
    protected $slug;

    /**
     * @var decimal $precio
     */
    protected $precio;

    /**
     * @var integer $stock
     */
    protected $stock;

    /**
     * @var text $descripcion
     */
    protected $descripcion;

    /**
     * @var date $created
     */
    protected $created;

    /**
     * @var decimal $descuento
     */
    protected $descuento;

    /**
     * @var boolean $descatalogado
     */
    protected $descatalogado;


    /**
     * Set id
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * Set autor
     *
     * @param string $autor
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;
    }

    /**
     * Get autor
     *
     * @return string 
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * Set discografica
     *
     * @param string $discografica
     */
    public function setDiscografica($discografica)
    {
        $this->discografica = $discografica;
    }

    /**
     * Get discografica
     *
     * @return string 
     */
    public function getDiscografica()
    {
        return $this->discografica;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set precio
     *
     * @param decimal $precio
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    /**
     * Get precio
     *
     * @return decimal 
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    /**
     * Get stock
     *
     * @return integer 
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set descripcion
     *
     * @param text $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * Get descripcion
     *
     * @return text 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set created
     *
     * @param date $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return date 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set descuento
     *
     * @param decimal $descuento
     */
    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;
    }

    /**
     * Get descuento
     *
     * @return decimal 
     */
    public function getDescuento()
    {
        return $this->descuento;
    }

    /**
     * Set descatalogado
     *
     * @param boolean $descatalogado
     */
    public function setDescatalogado($descatalogado)
    {
        $this->descatalogado = $descatalogado;
    }

    /**
     * Get descatalogado
     *
     * @return boolean 
     */
    public function getDescatalogado()
    {
        return $this->descatalogado;
    }

    /**
     * Get categoria
     *
     * @return string 
     */
    public function getCategoria()
    {
        return "musica";
    }
}