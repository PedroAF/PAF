<?php
//src/Paf/pfcBundle/Entity/Cliente.php
namespace Paf\pfcBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
//
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
//
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

// implements UserInterface, \Serializable
/**
 * @ORM\Entity(repositoryClass="Paf\pfcBundle\Entity\ClienteRepository")
 * @ORM\Table()
 */
class Cliente implements UserInterface, \Serializable
{
    /*
     * Implementation of UserInterface
     */

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function getSalt()
    {
        return false;
    }

    public function getUsername()
    {
        return $this->alias;
    }

    public function eraseCredentials()
    {
        return false;
    }

    public function equals(UserInterface $user)
    {
        return $user->getUsername() == $this->getUsername();
    }

    /*
     * Implementation of Serializable
     */
    public function serialize()
    {
        return serialize(array(
            $this->getAlias()
        ));
    }

    public function unserialize($serialized)
    {
        $arr = unserialize($serialized);
        $this->setAlias($arr[0]);
    }

    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer") 
     * @ORM\GeneratedValue(strategy="AUTO") 
     * @ORM\OneToMany(targetEntity="Pedido")
     */
    protected $id;
    
    //Como en ponente de ponencias
    /** 
     * @ORM\OneToMany(targetEntity="Pedido", mappedBy="cliente")
     */
    protected $pedidos;
    
    /**
    * @ORM\Column(type="string")
    * @Assert\NotBlank()
    * @Assert\MinLength(3)
    * @Assert\MaxLength(20)
    */
    protected $nombre;

    /**
    * @ORM\Column(type="string")
    * @Assert\NotBlank()
    * @Assert\MinLength(3)
    * @Assert\MaxLength(20)
    */
    protected $apellidos;
    
    /**
    * @ORM\Column(type="string")
    * @Assert\NotBlank()
    * @Assert\MinLength(3)
    * @Assert\MaxLength(20)
    */
    protected $alias;

    /**
    * @ORM\Column(type="string")
    * @Assert\NotBlank()
    * @Assert\MinLength(5)
    * @Assert\MaxLength(10)
    */
    protected $password;

    /**
    * @ORM\Column(type="string")
    * @Assert\NotBlank()
    * @Assert\Email()
    */
    protected $email;
    
    /** 
     * @ORM\Column(type="datetime") 
     * @Assert\Date()
     */
    protected $created; 

    public function __construct()
    {
        $timezone = new \DateTimeZone("Europe/Madrid"); //$dt = new \DateTime("now", $timezone);
        $this->pedidos = new ArrayCollection();
        $this->created = new \DateTime("now", $timezone);
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
     * Set apellidos
     *
     * @param string $apellidos
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set alias
     *
     * @param string $alias
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    /**
     * Get alias
     *
     * @return string 
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
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
     * Add pedidos
     *
     * @param Paf\pfcBundle\Entity\Pedido $pedidos
     */
    public function addPedidos(\Paf\pfcBundle\Entity\Pedido $pedidos)
    {
        $this->pedidos[] = $pedidos;
    }

    /**
     * Get pedidos
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPedidos()
    {
        return $this->pedidos;
    }
    
    /**
     * Get fecha
     *
     * @return text $fecha 
     */
    public function getFecha()
    {
        $fecha = $this->created->format('d-m-y'); 
        return $fecha;
    }
    
    /**
     * Get numeropedidos
     *
     * @return text $fecha 
     */
    public function getNumeropedidos()
    {
        $numeropedidos = count($this->pedidos);
        return $numeropedidos;
    }
    
    /**
     * Get fechaultimo
     *
     * @return text $fechaultimo 
     */
    public function getFechaultimo()
    {
        $fechaultimo = "ERR";
        $dt1 = new \DateTime();
        $dt1->setDate(1970, 1, 1);
        $ultimopedido = new \Paf\pfcBundle\Entity\Pedido();
        foreach($this->pedidos as $pedido){
            if ($pedido->getCreated() > $dt1){
                $fechaultimo = $pedido->getFecha();
            }
        }
        return $fechaultimo;
    }
}