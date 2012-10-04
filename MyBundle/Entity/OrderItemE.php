<?php
// src/Paf/MyBundle/Entity/Product.php
namespace Paf\MyBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table()
 */
class OrderItemE
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="OrderE")
     */
    protected $order;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="ProductEjemplo")
     */
    protected $product;

    /** @ORM\Column(type="integer") */
    protected $amount = 1;

    /** @ORM\Column(type="decimal") */
    protected $offeredPrice;

    public function __construct(OrderE $order, ProductEjemplo $product, $amount = 1)
    {
        $this->order = $order;
        $this->product = $product;
        $this->offeredPrice = $product->getPrice();
    }

    /**
     * Set amount
     *
     * @param integer $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Get amount
     *
     * @return integer 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set offeredPrice
     *
     * @param decimal $offeredPrice
     */
    public function setOfferedPrice($offeredPrice)
    {
        $this->offeredPrice = $offeredPrice;
    }

    /**
     * Get offeredPrice
     *
     * @return decimal 
     */
    public function getOfferedPrice()
    {
        return $this->offeredPrice;
    }

    /**
     * Set order
     *
     * @param Paf\MyBundle\Entity\OrderE $order
     */
    public function setOrder(\Paf\MyBundle\Entity\OrderE $order)
    {
        $this->order = $order;
    }

    /**
     * Get order
     *
     * @return Paf\MyBundle\Entity\OrderE 
     */
    public function getOrder()
    {
        return $this->order;
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