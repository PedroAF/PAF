<?php
namespace Paf\pfcBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class FiltroPedidos
{
    /**
     * @Assert\Type("integer") 
     * @Assert\Min(1)
    */
    protected $id;
    
    /** 
    */
    protected $dt1;
    
    /**
    */
    protected $dt2;

    public function __construct()
    {
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getDt1()
    {
        return $this->dt1;
    }
    
    public function setDt1(\DateTime $dt1 = null)
    {
        $this->dt1 = $dt1;
    }
    
    public function getDt2()
    {
        return $this->dt2;
    }
    
    public function setDt2(\DateTime $dt2 = null)
    {
        $this->dt2 = $dt2;
    } 
}