<?php

namespace Paf\pfcBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Paf\pfcBundle\Entity\ProductoRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({ "pelicula" = "Pelicula" , "libro" = "Libro" , "musica" = "Musica" , "serie" = "Serie" })
 */
class Producto
{
    /**
     * @var integer $id
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $nombre
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\MinLength(6)
     * @Assert\MaxLength(255)
     */
    protected $nombre;
    
    /**
     * @var string $slug
     * @ORM\Column(type="string", length=255)
     */
    protected $slug;

    /**
     * @var decimal precio
     * @ORM\Column( type="decimal", scale = 2)
     * @Assert\Type("decimal")
     * @Assert\Min(0)
     */
    protected $precio;
    
    /**
     * @var integer $stock
     * @ORM\Column( type="integer")
     * @Assert\Type("integer")
     * @Assert\Min(0)
     */
    protected $stock;

    /**
     * @var text $descripcion
     * @ORM\Column( type="text")
     */
    protected $descripcion;
    
    /** 
     * @ORM\Column(type="date") 
     * @Assert\Date()
     */
    protected $created;
    
    /**
     * @var decimal $descuento
     * @ORM\Column(type="decimal",scale= 2)
     * @Assert\Type("decimal")
     * @Assert\Min(0)
     */
    protected $descuento;
    
    /** 
     * @ORM\Column(type="boolean") 
     */
    protected $descatalogado = false;

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
        //$this->slug = Util::slugify($nombre);
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
     * Get nombreCorto
     * @param integer $tamaño
     * @return text 
     */
    public function getNombreCorto($tamaño)
    {
        //KK quiza meterle un -3 al atamaño para que no se den casos como quitarle una letra solo al nombre y "..."
        if(strlen($this->nombre) > ($tamaño + 3)){
            $nom = substr($this->nombre, 0, $tamaño)."...";
            return $nom;
        }
        else{
            return $this->nombre;
        }
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
     * Get descripcionCorta
     *
     * @param integer $tamaño
     * @return text 
     */
    public function getDescripcionCorta($tamaño)
    {
        if(strlen($this->descripcion) > $tamaño){
            $desc= substr($this->descripcion, 0, $tamaño)."...";
            return $desc;
        }
        else{
            return $this->descripcion;
        }
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
        /*if($this->descatalogado == TRUE)return "descatalogado";
        else return "en catalogo";*/
        return $this->descatalogado;
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
     * Get precioActual
     *
     * @return decimal 
     */
    public function getPrecioActual()
    {
        $aux = $this->precio * (1 - $this->descuento);
        return $aux;
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
     * @return boolean 
     */
    public function getIsReciente()
    { 
        $diasParaSerReciente = 20;
        $tz = new \DateTimeZone("Europe/Madrid");
  
        $dt1 = new \DateTime("now", $tz);
        $dt2 = $this->created;//new \DateTime("2011-11-28", $tz);
        //$dt2 = new \DateTime("now", $tz);//$dt2 = new \DateTime("tomorrow", $tz);  
        
        // use the DateTime datediff function IF we have a non-buggy version
        // there is a bug in many Windows implementations that diff() always returns
        // 6015  
        if( $dt1->diff($dt1)->format("%a") != 6015 ) {
            $diff = $dt1->diff($dt2)->format("%a");
            return $diff;
        }
        // else Bugged version, asi que a hacerlo a manubrio

        $y1 = $dt1->format('Y');  
        $y2 = $dt2->format('Y');
        $z1 = $dt1->format('z');
        $z2 = $dt2->format('z');

        $diff = intval($y1 * 365.2425 + $z1) - intval($y2 * 365.2425 + $z2);
        
        if($diff <= $diasParaSerReciente){
            return true;
        }
        else{
            return false;
        }
    }
        /*
        $string = $diff." menor o igual ".$diasParaSerReciente;
        if($diff <= $diasParaSerReciente){
            return $string."true";
        }
        else{
            return $string."false";
        }*/
        /*
        //No puedo hacerlo de forma convencional porque la version de Win , Apache o lo que sea esta buggeada
        // report del bug: https://bugs.php.net/bug.php?id=51184 
        
        $ahora = new \DateTime("now"); //Fecha actual
        $ahora->sub(new \DateInterval('P10D')); //$fecha->sub(new DateInterval('P10D'));
        //$intervalo = new \DatePeriod($ahora, null,$this->created);
        $isreciente = $ahora->format('Y-m-d')." y ".$this->created->format('Y-m-d');//.$ahora.toString();

        $tz = new \DateTimeZone("Europe/Madrid");
        $dt1 = date_create('2009-10-11', $tz);
        $dt2 = date_create('2009-10-13', $tz);
        $dt3 = new \DateTime("now", $tz);
        $dt4 = new \DateTime("tomorrow", $tz);
        $interval = $dt3->diff($dt4)->d;//date_diff($dt3,$dt4);
        $isreciente = $dt3->format('Y-m-d')."a ".$dt4->format('Y-m-d')."b intervalo:".$interval;//->format('%R%a days');

         */
        
        //$today = new \DateTime("now");
           /*     list($month, $day, $year) = split('-', $created);
        function compare_dates($date1, $date2) {
        list($month, $day, $year) = split('/', $date1);
        $new_date1 = sprintf('%04d%02d%02d', $year, $month, $day);

        list($month, $day, $year) = split('/', $date2);
        $new_date2 = sprintf('%04d%02d%02d', $year, $month, $day);

        return ($new_date1 > $new_date2);
        }*/
}