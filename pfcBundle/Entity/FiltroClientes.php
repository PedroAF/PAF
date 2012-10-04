<?php
namespace Paf\pfcBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class FiltroClientes
{
    /**
     * @Assert\Type("integer") 
     * @Assert\Min(1)
    */
    protected $id;
    
    /**
    */
    protected $keywords;

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
    
    public function getKeywords()
    {
        return $this->keywords;
    }
    
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }
}