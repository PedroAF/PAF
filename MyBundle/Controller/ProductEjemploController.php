<?php

namespace Paf\MyBundle\Controller;

use Paf\MyBundle\Entity\ProductEjemplo2;
use Paf\MyBundle\Entity\FilmE2;
use Paf\MyBundle\Entity\BookE2;

use Paf\MyBundle\Entity\ProductEjemplo;
use Paf\MyBundle\Entity\OrderE;
use Paf\MyBundle\Entity\OrderItemE;
use Paf\MyBundle\Entity\FilmE;
use Paf\MyBundle\Entity\BookE;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ProductEjemploController extends Controller
{
    //funcion para crear un ProductoEjemplo
    public function createAction()  
    {
        $product1 = new ProductEjemplo();//$product1 = new ProductEjemplo('New Film 1','30.44','Lorem ipsum dolor');
        $r = 'testing id'.$product1->getId().'</p>';
        
        $product1->setName('New Film 1'); $product1->setPrice('30.44'); $product1->setDescription('Lorem ipsum dolor');
        
        $product2 = new ProductEjemplo();
        $product2->setName('New Book 1');
        $product2->setPrice('50.00');
        $product2->setDescription('Lorem ipsum dolor');

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($product1);
        $em->persist($product2);
        $em->flush();
        $film = new FilmE($product1, 'dir1', 'gui1', 'rep1',2010);
        $book = new BookE($product2, 'aut1', 'cat1', 'edi1',2010);
        $em->persist($film);
        $em->persist($book);
        $em->flush();
        
        $r = $r.'Created products id '.$film->getId().' - '.$book->getId();

        return new Response($r);
    }
    
    //funcion para crear un ProductoEjemplo2
    public function create2Action()  
    {
        $em = $this->getDoctrine()->getEntityManager();
        $r = 'R: </p>';
        /*
        $product1 = new ProductEjemplo2();
        $product1->setName('New Film 1p'); $product1->setPrice('25.00'); $product1->setDescription('Lorem dolor p'); 
        $r = $r.' P1 new ID '.$product1->getId().' - '.$product1->getName().'</p>';*/
        //$em->persist($product1);// no se puede persistir un producto sin tipo porque sino seria disc null
        //$em->flush();
        $film = new FilmE2();
        $film->setName('New Film 1'); $film->setPrice('25.00'); $film->setDescription('Lorem dolor'); $film->setDirector('dir1');
        //$film->setId(20); //No se puede marcar el ID porque aunque deje al hacer FLUSH() mete la clave autogenerada por sql.
        $r = $r.'Id new film '.$film->getId().' - '.$film->getName().'</p>';
        $em->persist($film);
        $r = $r.'Id persisted film '.$film->getId().' - '.$film->getName().'</p>';
        $em->flush();
        $r = $r.'Id flushed film '.$film->getId().' - '.$film->getName().'</p>';
        $book = new BookE2();
        $book->setName('New book 1'); $book->setPrice('33.00'); $book->setDescription('Lorem dolor'); $book->setAutor('aut1');
        //$book->setId(20); //No se puede marcar el ID porque aunque deje al hacer FLUSH() mete la clave autogenerada por sql.
        $r = $r.'Id new book '.$book->getId().' - '.$book->getName().'</p>';
        $em->persist($book);
        $r = $r.'Id persisted film '.$book->getId().' - '.$book->getName().'</p>';
        $em->flush();
        $r = $r.'Id flushed film '.$book->getId().' - '.$book->getName().'</p>';
        return new Response($r);
        /*
        $film = new FilmE2();
        $film->setName('New Film 1'); $film->setPrice('25.00'); $film->setDescription('Lorem dolor'); $film->setDirector('dir1');
        $film->setId(55);*/
        //$em->persist($film);
        //$em->flush();
        /*
        $product1 = new ProductEjemplo2();//$product1 = new ProductEjemplo('New Film 1','30.44','Lorem ipsum dolor');
        $product1->setName('New Film 1'); $product1->setPrice('25.00'); $product1->setDescription('Lorem dolor');
        
        $product2 = new ProductEjemplo2(); $product2->setName('New Book 1');  $product2->setPrice('26.00'); $product2->setDescription('Lorem dolor');
        */
        //$product2->setDirector('dir1');
        

        //$em = $this->getDoctrine()->getEntityManager();
        //$em->persist($product1);
        //$em->flush();
        //$em->persist($product2);
        //$em->flush();
        //$film = new FilmE2();        $film->setDirector('dir1');
        //$film->setName('New Film 1');
        //$film->setPrice('30.00');
        //$em->persist($film);
        //$em->flush();

        //return new Response('Created products id '.$film->getId());//.$film->getId().' - '.$product1->getId().' - '.$product2->getId());
    }
    
    //buscar Producto por ID. 
    public function showAction($id)
    {

        //Una forma de hacerlo. 
        $product = $this->getDoctrine() -> getRepository('PafMyBundle:ProductEjemplo') -> find($id);
        //Otra forma.
        /*
        $repository = $this->getDoctrine() -> getRepository('PafMyBundle:ProductEjemplo');
        $product = $repository->find($id);
        */  

        if (!$product) {
            throw $this->createNotFoundException('No product found for id '.$id);
        }
        else {
            return new Response('id '.$product->getId().'  nombre '.$product->getName());
        }
    }
    
    //buscar Productos por Nombre. 
    public function show2Action()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery( 'SELECT p FROM PafMyBundle:ProductEjemplo p WHERE p.price >= :price ORDER BY p.price ASC') 
                ->setParameter('price', '19.99');
        $products = $query->getResult();
        
        if (!$products) {
            throw $this->createNotFoundException('Not found');
        }
        else {
            $lista = 'Ids de producto <p></p>';
            foreach($products as $product){
                $lista =  $lista.'<p></p> -> '.$product->getID().' - '.$product->getName().' - '.$product->getPrice().'$ ';
            }
            return new Response($lista.'<p></p>Consulta precios >= 19.99 con precio ascendente');//'id '.$product->getId().'  nombre '.$product->getName());
        }
        
        /*
        //FUNCIONA
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery( 'SELECT p FROM PafMyBundle:ProductEjemplo p WHERE p.price >= :price ORDER BY p.price ASC') 
                ->setParameter('price', '19.99') ->setMaxResults(1);
                //-> setParameters(array( 'name'  => 'Foo', 'price' => '19.99',));
        //$products = $query->getResult();
        $product = $query->getSingleResult();
        
        try {
            $product = $query->getSingleResult();
        } catch (\Doctrine\Orm\NoResultException $e) {
            $product = null;
        }
        if (!$product) {
            throw $this->createNotFoundException('Not found');
        }
        else {
            return new Response('id '.$product->getId().'  nombre '.$product->getName());
        }*/
    
        //Una forma de hacerlo. 
        //$product = $this->getDoctrine() -> getRepository('PafMyBundle:ProductEjemplo') -> find($id);
        //Otra forma.
        /*
        $repository = $this->getDoctrine() -> getRepository('PafMyBundle:ProductEjemplo');
        $product = $repository->find($id);
        return new Response('id '.$product->getId().'  nombre '.$product->getName());
        */
    }
    
    //Actualizar o Modificar un elemento.
    public function updateAction($id)
    {
        $em = $this -> getDoctrine() -> getEntityManager();
        $product = $em -> getRepository('PafMyBundle:ProductEjemplo') -> find($id);

        if (!$product) {
            throw $this -> createNotFoundException('No product found for id '.$id);
        }

        $product -> setName('New product name!');
        $em -> flush();
        //return $this->render('AcmeHelloBundle:Hello:index.html.twig', array('name' => $id));

    }
    
    //funcion para crear 
    public function createOrderEAction()  
    {
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery( 'SELECT p FROM PafMyBundle:ProductEjemplo p WHERE p.price >= :price ORDER BY p.price ASC') 
                ->setParameter('price', '25.00');
        $products = $query->getResult();
        
        if (!$products) {
            throw $this->createNotFoundException('Not found');
        }
        else {
            
            $order = new OrderE();
            $em->persist($order);
            $em->flush();
            
            $arrCol = new ArrayCollection();
            $lista = ' '.$order->getId().' Created Ids de producto <p></p>';
            
            foreach($products as $product){
                $lista =  $lista.'<p></p> -> '.$product->getID().' - '.$product->getName().' - '.$product->getPrice().'$ ';
                $orderitem = new OrderItemE($order,$product,2);
                $em->persist($orderitem);
                $em->flush();
                $arrcol = $orderitem;
            }
            $order->addItems($arrcol);
            $em->flush();
            
            return new Response($lista.'<p></p> Pedido con elementos de precios >= 25 con precio ascendente</p> Price payed'.$order->getPricePayed());
            
        }
        
        
        /*
        $product = new ProductEjemplo();
        $product->setName('A Foo Bar');
        $product->setPrice('19.99');
        $product->setDescription('Lorem ipsum dolor');

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($product);
        $em->flush();

        return new Response('Created product id '.$product->getId());*/
    }
    
}
//delete object
/*
$em->remove($product);
$em->flush();
 */

//Los URLS que pongo no me van... no se porke.
//return new Response('id '.$product->getId().'  nombre '.$product->getName());
//return $this->redirect($this->generateUrl('http://localhost:2020/testing/Pedro'));
   
//Cosas interesantes para recuperar de el repositorio. 
/*
// dynamic method names to find based on a column value
$product = $repository->findOneById($id);
$product = $repository->findOneByName('foo');

// find *all* products
$products = $repository->findAll();

// find a group of products based on an arbitrary column value
$products = $repository->findByPrice(19.99);
 
// You can also take advantage of the useful findBy and findOneBy methods to easily fetch objects based 
//on multiple conditions:

// query for one product matching be name and price
$product = $repository->findOneBy(array('name' => 'foo', 'price' => 19.99));

// query for all products matching the name, ordered by price
$product = $repository->findBy(
    array('name' => 'foo'),
    array('price' => 'ASC')
);

 */