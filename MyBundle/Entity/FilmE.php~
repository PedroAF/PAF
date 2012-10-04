<?php

// src/Acme/StoreBundle/Entity/Product.php
namespace Paf\MyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table()
 */
class FilmE
{
    /**
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="ProductEjemplo") 
     */
    protected $product;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $director;
    /**
     * @ORM\Column(type="string", length=100)
     */
    
    protected $guionistas;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $reparto;

    /**
     * @ORM\Column(type="integer")
     */
    protected $anyo;
    
    public function __construct(ProductEjemplo $product, $director = '', $guionistas = '', $reparto = '', $anyo = 0)
    {
        $this->product = $product;
        $this->director = $director;
        $this->guionistas = $guionistas;
        $this->reparto = $reparto;
        $this->anyo = $anyo;
    }

    /**
     * Set director
     *
     * @param string $director
     */
    public function setDirector($director)
    {
        $this->director = $director;
    }

    /**
     * Get director
     *
     * @return string 
     */
    public function getDirector()
    {
        return $this->director;
    }

    /**
     * Set guionistas
     *
     * @param string $guionistas
     */
    public function setGuionistas($guionistas)
    {
        $this->guionistas = $guionistas;
    }

    /**
     * Get guionistas
     *
     * @return string 
     */
    public function getGuionistas()
    {
        return $this->guionistas;
    }

    /**
     * Set reparto
     *
     * @param string $reparto
     */
    public function setReparto($reparto)
    {
        $this->reparto = $reparto;
    }

    /**
     * Get reparto
     *
     * @return string 
     */
    public function getReparto()
    {
        return $this->reparto;
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
}