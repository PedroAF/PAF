<?php
//Paf\pfcBundle\Entity\PeliculaRepository
namespace Paf\pfcBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PeliculaRepository extends EntityRepository
{
    /*
    public function findPeliculas($atributo ,$orden) 
    {
        return $this->getEntityManager()
                ->createQuery('SELECT p FROM Paf\pfcBundle\Entity\Pelicula p ORDER BY p.'.$atributo.' '.$orden)
                ->getResult();
    }*/
    
    public function findPeliculas($keywords, $atributo, $orden, $pmin, $pmax) 
    {
        $like = '';
        if ($pmin == 0 && $pmax == 0){
            return $this->getEntityManager()
                    ->createQuery('SELECT p FROM Paf\pfcBundle\Entity\Pelicula p '.$like.' ORDER BY p.'.$atributo.' '.$orden)
                    ->getResult();
        }
        if ($pmin != 0 && $pmax == 0){
            return $this->getEntityManager()
                    ->createQuery('SELECT p FROM Paf\pfcBundle\Entity\Pelicula p WHERE '.$like.' p.precio >= :pmin ORDER BY p.'.$atributo.' '.$orden)
                    ->setParameter('pmin', $pmin)
                    ->getResult();
        }
        if ($pmin == 0 && $pmax != 0){
            return $this->getEntityManager()
                    ->createQuery('SELECT p FROM Paf\pfcBundle\Entity\Pelicula p WHERE '.$like.' p.precio <= :pmax ORDER BY p.'.$atributo.' '.$orden)
                    ->setParameter('pmax', $pmax)
                    ->getResult();
        }
        if ($pmin != 0 && $pmax != 0){
            return $this->getEntityManager()
                    ->createQuery('SELECT p FROM Paf\pfcBundle\Entity\Pelicula p WHERE '.$like.' p.precio >= :pmin AND p.precio <= :pmax ORDER BY p.'.$atributo.' '.$orden)
                    ->setParameters(array( 'pmin' => $pmin,'pmax' => $pmax,))
                    ->getResult();
        }
        /*
        if ($pmin == 0 && $pmax == 0){
            return $this->getEntityManager()
                    ->createQuery('SELECT p FROM Paf\pfcBundle\Entity\Pelicula p ORDER BY p.'.$atributo.' '.$orden)
                    ->getResult();
        }
        if ($pmin != 0 && $pmax == 0){
            return $this->getEntityManager()
                    ->createQuery('SELECT p FROM Paf\pfcBundle\Entity\Pelicula p WHERE p.precio >= :pmin ORDER BY p.'.$atributo.' '.$orden)
                    ->setParameter('pmin', $pmin)
                    ->getResult();
        }
        if ($pmin == 0 && $pmax != 0){
            return $this->getEntityManager()
                    ->createQuery('SELECT p FROM Paf\pfcBundle\Entity\Pelicula p WHERE p.precio <= :pmax ORDER BY p.'.$atributo.' '.$orden)
                    ->setParameter('pmax', $pmax)
                    ->getResult();
        }
        if ($pmin != 0 && $pmax != 0){
            return $this->getEntityManager()
                    ->createQuery('SELECT p FROM Paf\pfcBundle\Entity\Pelicula p WHERE p.precio >= :pmin AND p.precio <= :pmax ORDER BY p.'.$atributo.' '.$orden)
                    ->setParameters(array( 'pmin' => $pmin,'pmax' => $pmax,))
                    ->getResult();
        }*/
    }
    
}