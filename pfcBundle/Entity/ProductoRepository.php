<?php
//Paf\pfcBundle\Entity\ProductoRepository
namespace Paf\pfcBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ProductoRepository extends EntityRepository
{
    public function findTodos($cat, $keywords, $atributo, $orden, $pmin, $pmax, $descat) 
    {
        $keywords = trim($keywords);
        $like = ''; //"WHERE p.nombre LIKE '%".$keywords."%' ";//'';
        $descatalogado = '';
        $vacio = '';
        $espacio = ' ';
        switch ($cat){
            case 'pelicula':
                $cat = 'Paf\pfcBundle\Entity\Pelicula';  
                break;
            case 'serie':
                $cat = 'Paf\pfcBundle\Entity\Serie';  
                break;
            case 'musica':
                $cat = 'Paf\pfcBundle\Entity\Musica';  
                break;
            case 'libro':
                $cat = 'Paf\pfcBundle\Entity\Libro';  
                break;
            default :
                $cat = 'Paf\pfcBundle\Entity\Producto';                     
        }
        
///////         PALABRAS CLAVE          ///////
        //Si las palabra clave no es un campo vacio
        if(strcasecmp($keywords, $vacio)!=0){
            //SELECT * FROM `producto` WHERE (`nombre` Like '%30%' or `descripcion` Like '%30%') AND (`nombre` Like '%30%' or `descripcion` Like '%30%') 
            //$like = " (p.nombre LIKE '%".$keywords."%' OR p.descripcion LIKE '%".$keywords."%') ";//$like = $like." p.nombre LIKE '%".$keywords."%' ";
        
            
            $pos = strpos($keywords, $espacio);
            // Nótese el uso de ===. Puesto que == simple no funcionará como se espera porque la posición de 'a' está en el 1° (primer) caracter.
            //Si no hay ningun espacio dentro de las palabras claves
            if ($pos === false) {
                //No hay espacios... por lo que solo es una palabra.
                $like = " (p.nombre LIKE '%".$keywords."%' OR p.descripcion LIKE '%".$keywords."%') ";
            } 
            else {
                //Si hay espacios... por lo que habra que truncar el string en diferentes palabras y buscarlas todas. 
                $buscando = TRUE;
                $resto = $keywords;
                $palabra = "";
                while ($buscando) {
                    $palabra = stristr($resto, $espacio, true);//Conseguir la primera palabra... sacamos todo el string desde el principio hasta el primer espacio
                    $resto = stristr($resto, $espacio); //todo lo que esta a partir del espacio incluyendolo
                    $resto = substr($resto, 1);  //quitamos el espacio
                    $like = $like." (p.nombre LIKE '%".$palabra."%' OR p.descripcion LIKE '%".$palabra."%') ";
                    $pos = strpos($resto, $espacio);
                    if ($pos === false) {
                        // se acabo la busqueda. Tratamos el resto ultimo y salimos
                        $buscando = FALSE;
                        $like = $like." AND (p.nombre LIKE '%".$resto."%' OR p.descripcion LIKE '%".$resto."%') ";
                    }
                    else {
                        //quedan mas espacios con lo que mas palabras.
                        $like = $like." AND ";
                    }
                }    
            }
        }
///////////    DESCATALOGADO O EN CATALOGO     ///////////// 
        
        if ($descat == FALSE) {
            $descatalogado = ' p.descatalogado = 0 ';
        }
        else {
            $descatalogado = ' p.descatalogado = 1 ';
        }
        
//////////         RANGO DE PRECIOS            ////////////
        if ($pmin == 0 && $pmax == 0){
            //Si las palabra clave no es un campo vacio
            //if(strcasecmp($keywords, $vacio)!=0) $like = 'WHERE'.$like;
            if(strcasecmp($keywords, $vacio)!=0) $like = $like.'AND';
            return $this->getEntityManager()
                    ->createQuery('SELECT p FROM '.$cat.' p WHERE '.$like.' '.$descatalogado.' ORDER BY p.'.$atributo.' '.$orden)
                    ->getResult();
        }
        if ($pmin != 0 && $pmax == 0){
            //Si las palabra clave no es un campo vacio
            if(strcasecmp($keywords, $vacio)!=0) $like = $like.'AND';
            return $this->getEntityManager()
                    ->createQuery('SELECT p FROM '.$cat.' p WHERE '.$like.' '.$descatalogado.' AND p.precio >= :pmin ORDER BY p.'.$atributo.' '.$orden)
                    ->setParameter('pmin', $pmin)
                    ->getResult();
        }
        if ($pmin == 0 && $pmax != 0){
            //Si las palabra clave no es un campo vacio
            if(strcasecmp($keywords, $vacio)!=0) $like = $like.'AND';
            return $this->getEntityManager()
                    ->createQuery('SELECT p FROM '.$cat.' p WHERE '.$like.' '.$descatalogado.' AND p.precio <= :pmax ORDER BY p.'.$atributo.' '.$orden)
                    ->setParameter('pmax', $pmax)
                    ->getResult();
        }
        if ($pmin != 0 && $pmax != 0){
            //Si las palabra clave no es un campo vacio
            if(strcasecmp($keywords, $vacio)!=0) $like = $like.'AND';
            return $this->getEntityManager()
                    ->createQuery('SELECT p FROM '.$cat.' p WHERE '.$like.' '.$descatalogado.' AND p.precio >= :pmin AND p.precio <= :pmax ORDER BY p.'.$atributo.' '.$orden)
                    ->setParameters(array( 'pmin' => $pmin,'pmax' => $pmax,))
                    ->getResult();
        }
    }
}

/*
class ProductoRepository extends EntityRepository
{
    public function findTodos($keywords, $atributo, $orden, $pmin, $pmax, $descat) 
    {
        $keywords = trim($keywords);
        $like = ''; //"WHERE p.nombre LIKE '%".$keywords."%' ";//'';
        $descatalogado = '';
        $vacio = '';
        $espacio = ' ';
///////         PALABRAS CLAVE          ///////
        //Si las palabra clave no es un campo vacio
        if(strcasecmp($keywords, $vacio)!=0){
            //SELECT * FROM `producto` WHERE (`nombre` Like '%30%' or `descripcion` Like '%30%') AND (`nombre` Like '%30%' or `descripcion` Like '%30%') 
            //$like = " (p.nombre LIKE '%".$keywords."%' OR p.descripcion LIKE '%".$keywords."%') ";//$like = $like." p.nombre LIKE '%".$keywords."%' ";
        
            
            $pos = strpos($keywords, $espacio);
            // Nótese el uso de ===. Puesto que == simple no funcionará como se espera porque la posición de 'a' está en el 1° (primer) caracter.
            //Si no hay ningun espacio dentro de las palabras claves
            if ($pos === false) {
                //No hay espacios... por lo que solo es una palabra.
                $like = " (p.nombre LIKE '%".$keywords."%' OR p.descripcion LIKE '%".$keywords."%') ";
            } 
            else {
                //Si hay espacios... por lo que habra que truncar el string en diferentes palabras y buscarlas todas. 
                $buscando = TRUE;
                $resto = $keywords;
                $palabra = "";
                while ($buscando) {
                    $palabra = stristr($resto, $espacio, true);//Conseguir la primera palabra... sacamos todo el string desde el principio hasta el primer espacio
                    $resto = stristr($resto, $espacio); //todo lo que esta a partir del espacio incluyendolo
                    $resto = substr($resto, 1);  //quitamos el espacio
                    $like = $like." (p.nombre LIKE '%".$palabra."%' OR p.descripcion LIKE '%".$palabra."%') ";
                    $pos = strpos($resto, $espacio);
                    if ($pos === false) {
                        // se acabo la busqueda. Tratamos el resto ultimo y salimos
                        $buscando = FALSE;
                        $like = $like." AND (p.nombre LIKE '%".$resto."%' OR p.descripcion LIKE '%".$resto."%') ";
                    }
                    else {
                        //quedan mas espacios con lo que mas palabras.
                        $like = $like." AND ";
                    }
                }    
            }
        }
///////////    DESCATALOGADO O EN CATALOGO     ///////////// 
        
        if ($descat == FALSE) {
            $descatalogado = ' p.descatalogado = 0 ';
        }
        else {
            $descatalogado = ' p.descatalogado = 1 ';
        }
        
//////////         RANGO DE PRECIOS            ////////////
        if ($pmin == 0 && $pmax == 0){
            //Si las palabra clave no es un campo vacio
            //if(strcasecmp($keywords, $vacio)!=0) $like = 'WHERE'.$like;
            if(strcasecmp($keywords, $vacio)!=0) $like = $like.'AND';
            return $this->getEntityManager()
                    ->createQuery('SELECT p FROM Paf\pfcBundle\Entity\Producto p WHERE '.$like.' '.$descatalogado.' ORDER BY p.'.$atributo.' '.$orden)
                    ->getResult();
        }
        if ($pmin != 0 && $pmax == 0){
            //Si las palabra clave no es un campo vacio
            if(strcasecmp($keywords, $vacio)!=0) $like = $like.'AND';
            return $this->getEntityManager()
                    ->createQuery('SELECT p FROM Paf\pfcBundle\Entity\Producto p WHERE '.$like.' '.$descatalogado.' AND p.precio >= :pmin ORDER BY p.'.$atributo.' '.$orden)
                    ->setParameter('pmin', $pmin)
                    ->getResult();
        }
        if ($pmin == 0 && $pmax != 0){
            //Si las palabra clave no es un campo vacio
            if(strcasecmp($keywords, $vacio)!=0) $like = $like.'AND';
            return $this->getEntityManager()
                    ->createQuery('SELECT p FROM Paf\pfcBundle\Entity\Producto p WHERE '.$like.' '.$descatalogado.' AND p.precio <= :pmax ORDER BY p.'.$atributo.' '.$orden)
                    ->setParameter('pmax', $pmax)
                    ->getResult();
        }
        if ($pmin != 0 && $pmax != 0){
            //Si las palabra clave no es un campo vacio
            if(strcasecmp($keywords, $vacio)!=0) $like = $like.'AND';
            return $this->getEntityManager()
                    ->createQuery('SELECT p FROM Paf\pfcBundle\Entity\Producto p WHERE '.$like.' '.$descatalogado.' AND p.precio >= :pmin AND p.precio <= :pmax ORDER BY p.'.$atributo.' '.$orden)
                    ->setParameters(array( 'pmin' => $pmin,'pmax' => $pmax,))
                    ->getResult();
        }
    }
}
 */

 /*
//Restricting a JOIN clause by additional conditions:
//$query = $em->createQuery("SELECT u FROM CmsUser u LEFT JOIN u.articles a WITH a.topic LIKE '%foo%'");
//$users = $query->getResult();


//Get all instances of a specific type, for use with inheritance hierarchies:
//$query = $em->createQuery('SELECT u FROM Doctrine\Tests\Models\Company\CompanyPerson u WHERE u INSTANCE OF Doctrine\Tests\Models\Company\CompanyEmployee');
//$query = $em->createQuery('SELECT u FROM Doctrine\Tests\Models\Company\CompanyPerson u WHERE u INSTANCE OF ?1');
//$query = $em->createQuery('SELECT u FROM Doctrine\Tests\Models\Company\CompanyPerson u WHERE u NOT INSTANCE OF ?1');

  */
//Antes de añadir las keywords
        /*
        if ($pmin == 0 && $pmax == 0){
            return $this->getEntityManager()
                    ->createQuery('SELECT p FROM Paf\pfcBundle\Entity\Producto p ORDER BY p.'.$atributo.' '.$orden)
                    ->getResult();
        }
        if ($pmin != 0 && $pmax == 0){
            return $this->getEntityManager()
                    ->createQuery('SELECT p FROM Paf\pfcBundle\Entity\Producto p WHERE p.precio >= :pmin ORDER BY p.'.$atributo.' '.$orden)
                    ->setParameter('pmin', $pmin)
                    ->getResult();
        }
        if ($pmin == 0 && $pmax != 0){
            return $this->getEntityManager()
                    ->createQuery('SELECT p FROM Paf\pfcBundle\Entity\Producto p WHERE p.precio <= :pmax ORDER BY p.'.$atributo.' '.$orden)
                    ->setParameter('pmax', $pmax)
                    ->getResult();
        }
        if ($pmin != 0 && $pmax != 0){
            return $this->getEntityManager()
                    ->createQuery('SELECT p FROM Paf\pfcBundle\Entity\Producto p WHERE p.precio >= :pmin AND p.precio <= :pmax ORDER BY p.'.$atributo.' '.$orden)
                    ->setParameters(array( 'pmin' => $pmin,'pmax' => $pmax,))
                    ->getResult();
        }
         */