<?php

// src/Acme/StoreBundle/Entity/Product.php
namespace Paf\MyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table()
 */
class BookE
{
    /**
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="ProductEjemplo") 
     */
    protected $product;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $autor;
    /**
     * @ORM\Column(type="string", length=100)
     */
    
    protected $categoria;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $edicion;

    /**
     * @ORM\Column(type="integer")
     */
    protected $anyo;
    
    
    public function __construct(ProductEjemplo $product, $autor = '', $categoria = '', $edicion = '', $anyo = 0)
    {
        $this->product = $product;
        $this->autor = $autor;
        $this->categoria = $categoria;
        $this->edicion = $edicion;
        $this->anyo = $anyo;
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
     * Set categoria
     *
     * @param string $categoria
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

    /**
     * Get categoria
     *
     * @return string 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set edicion
     *
     * @param string $edicion
     */
    public function setEdicion($edicion)
    {
        $this->edicion = $edicion;
    }

    /**
     * Get edicion
     *
     * @return string 
     */
    public function getEdicion()
    {
        return $this->edicion;
    }

    /**
     * Set anyo
     *
     * @param integer $anyo
     */
    public function setAnyo($anyo)
    {
        $this->anyo = $anyo;
    }

    /**
     * Get anyo
     *
     * @return integer 
     */
    public function getAnyo()
    {
        return $this->anyo;
    }

    /** //NO CREO Q SEA BUENA IDEA
     * Set id
     *
     * @param Paf\MyBundle\Entity\ProductEjemplo $id
     *
    public function setId(\Paf\MyBundle\Entity\ProductEjemplo $id)
    {
        $this->id = $id;
    }*/

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->getProduct()->getId();
    }

    /**
     * Set product
     *
     * @param Paf\MyBundle\Entity\ProductEjemplo $product
     */
    public function setProduct(\Paf\MyBundle\Entity\ProductEjemplo $product)
    {
        $this->product = $product;
    }

    /**
     * Get product
     *
     * @return Paf\MyBundle\Entity\ProductEjemplo 
     */
    public function getProduct()
    {
        return $this->product;
    }
}