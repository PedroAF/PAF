<?php
namespace Paf\pfcBundle\Entity;

//use Doctrine\Common\Collections\ArrayCollection;
//use Doctrine\ORM\Mapping as ORM;
//
//use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
//
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

class FiltroProductos
{
    /**
    */
    protected $keywords;
    
    /**
    */
    protected $orden;

    /**
    */
    protected $categoria;

    /**
     * @Assert\Type("decimal")
     * @Assert\Min(0)
    */
    protected $preciomin;
    
    /**
     * @Assert\Type("decimal")
     * @Assert\Min(0)
    */
    protected $preciomax;
    
    /**
     * @Assert\Type("boolean")
    */
    protected $descatalogado;

    public function __construct()
    {
    }
    
    public function getKeywords()
    {
        return $this->keywords;
    }
    
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }
    
    public function getOrden()
    {
        return $this->orden;
    }
    
    public function setOrden($orden)
    {
        $this->orden = $orden;
    }
    
    public function getCategoria()
    {
        return $this->categoria;
    }
    
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }
    
    public function getPreciomin()
    {
        return $this->preciomin;
    }
    
    public function setPreciomin($preciomin)
    {
        $this->preciomin = $preciomin;
    }
    
    public function getPreciomax()
    {
        return $this->preciomax;
    }
    
    public function setPreciomax($preciomax)
    {
        $this->preciomax = $preciomax;
    }
    
    public function getDescatalogado()
    {
        return $this->descatalogado;
    }
    
    public function setDescatalogado($descatalogado)
    {
        $this->descatalogado = $descatalogado;
    }
}