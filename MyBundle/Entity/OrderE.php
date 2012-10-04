<?php
// src/Paf/MyBundle/Entity/Product.php
namespace Paf\MyBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table()
 */
class OrderE
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer") 
     * @ORM\GeneratedValue(strategy="AUTO") 
     */
    protected $id;

    /** @ORM\OneToMany(targetEntity="OrderItemE", mappedBy="OrderE") */
    protected $items;

    /** 
     * @ORM\Column(type="boolean") 
     */
    protected $payed = false;
    /** 
     * @ORM\Column(type="boolean") 
     */
    protected $shipped = false;
    /** 
     * @ORM\Column(type="datetime") 
     */
    protected $created;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->created = new \DateTime("now");
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
     * Set payed
     *
     * @param boolean $payed
     */
    public function setPayed($payed)
    {
        $this->payed = $payed;
    }

    /**
     * Get payed
     *
     * @return boolean 
     */
    public function getPayed()
    {
        return $this->payed;
    }

    /**
     * Set shipped
     *
     * @param boolean $shipped
     */
    public function setShipped($shipped)
    {
        $this->shipped = $shipped;
    }

    /**
     * Get shipped
     *
     * @return boolean 
     */
    public function getShipped()
    {
        return $this->shipped;
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
     * Add items
     *
     * @param Paf\MyBundle\Entity\OrderItemE $items
     */
    public function addItems(\Paf\MyBundle\Entity\OrderItemE $items)
    {
        $this->items[] = $items;
    }

    /**
     * Get items
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getItems()
    {
        return $this->items;
    }
    
    /**
     * Get price payed
     *
     * @param decimal $pricepayed
     */
    public function getPricePayed()
    {
        $pricepayed = 0.00;
        foreach($this->items as $items){
            $pricepayed = $pricepayed + $items->getOfferedPrice()  ;
        }
        return $pricepayed;
    }
}