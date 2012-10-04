<?php
//Paf\pfcBundle\Entity\PedidoRepository
namespace Paf\pfcBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PedidoRepository extends EntityRepository
{
    public function findPedidos()
    {
    //public function findPedidos($atributo ,$orden){
        return $this->getEntityManager()
                ->createQuery('SELECT p FROM Paf\pfcBundle\Entity\Pedido p ORDER BY p.created DESC ')
                ->getResult(); 
    }
    
    public function findPedidosCliente($cliente_id)
    {
    //public function findPedidos($atributo ,$orden){
        return $this->getEntityManager()
                ->createQuery('SELECT p FROM Paf\pfcBundle\Entity\Pedido p WHERE p.cliente = '.$cliente_id.' ORDER BY p.created DESC ')
                ->getResult();
    }
    
    
    public function findTodos($id, $dt1, $dt2)
    {
        /////////////////////////////////////////////////////////////////////////////////////
        //// Condiciones: 
        /// 1 Id informado
        /// 2,3,4 Fecha minima informada, fecha maxima informada, las 2 fechas informadas
        /// Si nada esta informado simplemente saca todos los pedidos
        /// Siempre esta ordenado por pedido del mas reciente al mas antiguo
        /////////////////////////////////////////////////////////////////////////////////////
        
        
        ///////   1      IDENTIFICADOR          /////////Si el identificador esta informado
        if($id !=0 && $id != NULL){
            
            return $this->getEntityManager()
                    ->createQuery('SELECT p FROM Paf\pfcBundle\Entity\Pedido p WHERE p.id = '.$id.' ORDER BY p.created DESC ' )
                    ->getResult();
        }        
       
        ///////   2   Fecha inicial       ///////
        if($dt1 != NULL && $dt2 == NULL){
            
            return $this->getEntityManager() 
                    ->createQuery('SELECT p FROM Paf\pfcBundle\Entity\Pedido p WHERE p.created >= :datefrom ORDER BY p.created DESC ' )
                    ->setParameter('datefrom', $dt1)
                    ->getResult();
        }
        
        ///////   3   Fecha final     ///////
        if($dt1 == NULL && $dt2 != NULL){
            
            return $this->getEntityManager() 
                    ->createQuery('SELECT p FROM Paf\pfcBundle\Entity\Pedido p WHERE p.created <= :dateto ORDER BY p.created DESC ' )
                    ->setParameter('dateto', $dt2)
                    ->getResult();
        }
        
        ///////    4     Intervalo de fechas         ///////
        if($dt1 != NULL && $dt2 != NULL){
            
            return $this->getEntityManager() 
                    ->createQuery('SELECT p FROM Paf\pfcBundle\Entity\Pedido p WHERE p.created BETWEEN :datefrom AND :dateto ORDER BY p.created DESC ' )
                    ->setParameters(array('datefrom' => $dt1, 'dateto' => $dt2,))
                    ->getResult();
            /*//FUNCIONA PERFECTAMENTE
            return $this->getEntityManager() 
                    ->createQuery('SELECT p FROM Paf\pfcBundle\Entity\Pedido p WHERE p.created >= :datefrom AND p.created <= :dateto ' )
                    ->setParameter('datefrom', $dt1)
                    ->setParameter('dateto', $dt2)
                    ->getResult();*/
        }
        ///////    5 En caso de que no haya nada informado         ////////
        return $this->getEntityManager()
                ->createQuery('SELECT p FROM Paf\pfcBundle\Entity\Pedido p ORDER BY p.created DESC ')
                ->getResult();
    }    
     
}