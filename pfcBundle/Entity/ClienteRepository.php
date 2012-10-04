<?php
//Paf\pfcBundle\Entity\ClienteRepository
namespace Paf\pfcBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ClienteRepository extends EntityRepository
{
    public function findClientes()
    {
        return $this->getEntityManager()
                ->createQuery('SELECT c FROM Paf\pfcBundle\Entity\Cliente c')
                ->getResult();
    }
    
    public function findTodos($i, $keywords)
    {
        $keywords = trim($keywords);
        $like = ''; 
        $vacio = '';
        $espacio = ' ';
        //$em = $this->get('doctrine')->getEntityManager();
        
        ///////         IDENTIFICADOR          ///////
        //Si el identificador esta informado
        if($i!=0 && $i != NULL){
            
            
            return $this->getEntityManager()
                    ->createQuery('SELECT c FROM Paf\pfcBundle\Entity\Cliente c WHERE c.id = '.$i.' ' )
                    ->getResult();
        }
        
        
        ///////         PALABRAS CLAVE          ///////
        //Si las palabra clave no es un campo vacio
        if(strcasecmp($keywords, $vacio)!=0){
            //SELECT * FROM `producto` WHERE (`nombre` Like '%30%' or `descripcion` Like '%30%') AND (`nombre` Like '%30%' or `descripcion` Like '%30%') 
            //$like = " (c.nombre LIKE '%".$keywords."%' OR c.aapellidos LIKE '%".$keywords."%') ";//$like = $like." c.nombre LIKE '%".$keywords."%' ";
        
            
            $pos = strpos($keywords, $espacio);
            // Nótese el uso de ===. Puesto que == simple no funcionará como se espera porque la posición de 'a' está en el 1° (primer) caracter.
            //Si no hay ningun espacio dentro de las palabras claves
            if ($pos === false) {
                //No hay espacios... por lo que solo es una palabra.
                $like = " (c.nombre LIKE '%".$keywords."%' OR c.apellidos LIKE '%".$keywords."%') ";
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
                    $like = $like." (c.nombre LIKE '%".$palabra."%' OR c.apellidos LIKE '%".$palabra."%') ";
                    $pos = strpos($resto, $espacio);
                    if ($pos === false) {
                        // se acabo la busqueda. Tratamos el resto ultimo y salimos
                        $buscando = FALSE;
                        $like = $like." AND (c.nombre LIKE '%".$resto."%' OR c.apellidos LIKE '%".$resto."%') ";
                    }
                    else {
                        //quedan mas espacios con lo que mas palabras.
                        $like = $like." AND ";
                    }
                }    
            } 
            
            
            return $this->getEntityManager()
                    ->createQuery('SELECT c FROM Paf\pfcBundle\Entity\Cliente c WHERE '.$like.' ') 
                    ->getResult();   
        }
        
        
        return $this->getEntityManager()
                ->createQuery('SELECT c FROM Paf\pfcBundle\Entity\Cliente c')
                ->getResult();
    }    
}