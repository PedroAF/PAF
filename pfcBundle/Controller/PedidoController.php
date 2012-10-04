<?php

namespace Paf\pfcBundle\Controller;

use Symfony\Component\HttpFoundation\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Paf\pfcBundle\Form\FiltroProductosType;
use Paf\pfcBundle\Form\PeliculaType;
use Paf\pfcBundle\Form\SerieType;
use Paf\pfcBundle\Form\MusicaType;
use Paf\pfcBundle\Form\LibroType;
use Paf\pfcBundle\Entity\Carrito;
use Paf\pfcBundle\Entity\LineaCarrito;
use Paf\pfcBundle\Entity\Pedido;
use Paf\pfcBundle\Entity\LineaPedido;
use Paf\pfcBundle\Entity\Cliente;
use Paf\pfcBundle\Entity\FiltroPedidos;
use Paf\pfcBundle\Form\FiltroPedidosType;

class PedidoController extends Controller
{
    public function showcarritoAction()
    {
        return $this->render('PafpfcBundle:Pedido:carrito.html.twig');
    }
    
    public function listatodosAction()
    {
        $em = $this->get('doctrine')->getEntityManager();
        $id = 0; $dt1 = new \DateTime('now'); $dt2 = new \DateTime('now');
        $defaultFiltro = new FiltroPedidos();
        $form = $this->get('form.factory')->create(new FiltroPedidosType(), $defaultFiltro);
        
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            //lincamos y recuperamos datos.
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                $filtro = $form->getData();
                $id = $filtro->getId();
                $dt1 = $filtro->getDt1();
                $dt2 = $filtro->getDt2(); 
                $pedidos = $em->getRepository('PafpfcBundle:Pedido')->findTodos($id, $dt1, $dt2); 
        
                return $this->render('PafpfcBundle:Pedido:index.html.twig', array('pedidos' => $pedidos, 'form' => $form->createView()));
            }
        } 
        /*
        $i = 0; $ke = '';
        $em = $this->get('doctrine')->getEntityManager();
        $defaultFiltro = new FiltroClientes();
        $form = $this->get('form.factory')->create(new FiltroClientesType(), $defaultFiltro);
        
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            //lincamos y recuperamos datos.
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                $filtro = $form->getData();
                $ke = $filtro->getKeywords();
                $i = $filtro->getId();
                $clientes = $em->getRepository('PafpfcBundle:Cliente')->findTodos($i, $ke);
        
                return $this->render('PafpfcBundle:Cliente:listaclientes.html.twig', array('clientes' => $clientes, 'form' => $form->createView()));
            }
        }
        
        $clientes = $em->getRepository('PafpfcBundle:Cliente')->findClientes();
        
        return $this->render('PafpfcBundle:Cliente:listaclientes.html.twig', array('clientes' => $clientes, 'form' => $form->createView()));
         */
        
        /*
        // create a task and give it some dummy data for this example
        $task = new Task();
        $task->setTask('Write a blog post');
        $task->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($task)
            ->add('task', 'text')
            ->add('dueDate', 'date')
            ->getForm();
         */
        
        $pedidos = $em->getRepository('PafpfcBundle:Pedido')->findPedidos();
        
        return $this->render('PafpfcBundle:Pedido:index.html.twig', array('pedidos' => $pedidos, 'form' => $form->createView()));
    }
    
    public function listaClienteLogedAction()
    {
        $em = $this->get('doctrine')->getEntityManager();
        //$pedidos = $em->getRepository('PafpfcBundle:Pedido')->findPedidos(); //findPedidosCliente($cliente_id)
        
        $cliente = $this->get('security.context')->getToken()->getUser();
        if (!$cliente) throw $this->createNotFoundException('No existe el cliente (Error 1013)');
        $pedidos = $em->getRepository('PafpfcBundle:Pedido')->findPedidosCliente($cliente->getId());
        
        return $this->render('PafpfcBundle:Pedido:index.html.twig', array('pedidos' => $pedidos));
    }
    
    public function showAction($id)
    {
        $em = $this->get('doctrine')->getEntityManager();
        $pedido = $em->find('PafpfcBundle:Pedido' , $id);
        
        $cliente = $this->get('security.context')->getToken()->getUser();
        if (!$cliente) throw $this->createNotFoundException('No existe el cliente (Error 1013)');
        
        $detalleError = 'El pedido con id: '.$id.' ';
        if (!$pedido) throw $this->createNotFoundException($detalleError.' no existe (Error 1027)');
        
        
        $detalleError = 'El pedido con id: '.$id.' del Cliente: '.$cliente->getId();
        //El pedido no tiene el cliente asignado
        if (!$pedido->getCliente()) throw $this->createNotFoundException($detalleError.' no tiene cliente asignado en el pedido (Error 1033)');
        //El cliente del pedido no coincide con el cliente registrado. Con lo que no tendra acceso
        //a los datos de otros clientes
        if ($pedido->getCliente()->getId() != $cliente->getId() ) throw $this->createNotFoundException($detalleError.' no existe o no coincide (Error 1035)');
        
        return $this->render('PafpfcBundle:Pedido:show.html.twig', array('pedido' => $pedido)); 
    }
    
    public function showAAction($id)
    {
        $em = $this->get('doctrine')->getEntityManager();
        $pedido = $em->find('PafpfcBundle:Pedido' , $id);
        $detalleError = 'El pedido con id: '.$id.' ';
        if (!$pedido) throw $this->createNotFoundException($detalleError.' no existe (Error 1027)');
        
        return $this->render('PafpfcBundle:Pedido:show.html.twig', array('pedido' => $pedido)); 
    }
    
    public function clearcartAction()
    {   
        //Recupero la request, la sesion, y borro el carrito. 
        $request = $this->getRequest();
        $session = $request->getSession();
        $session->remove('carrito'); 
        
        return $this->redirect($request->headers->get('referer')); //Envia a la pagina anterior segun la URL!!!
        //return $this->forward('PafpfcBundle:Producto:listatodos'); 
        // Esto ejecuta el controlador y muestra listatodos pero no cambia la url... lo cual genera problemas. 
    }
    
    public function datospagoAction()
    {   
        return $this->render('PafpfcBundle:Pedido:datospago.html.twig'); 
    }
    
    public function enviadoAction($id)
    {        
        $request = $this->getRequest();
        $em = $this->get('doctrine')->getEntityManager();
        $pedido = $em->find('PafpfcBundle:Pedido' , $id);
        $detalleError = 'El pedido con id: '.$id.' ';
        if (!$pedido) throw $this->createNotFoundException($detalleError.' no existe (Error 1031)');
        
        $pedido->setEnviado(TRUE);
        $em->persist($pedido);
        $em->flush();
        
        return $this->redirect($request->headers->get('referer')); //Envia a la pagina anterior segun la URL!!!
    }
    
    public function noenviadoAction($id)
    {        
        $request = $this->getRequest();
        $em = $this->get('doctrine')->getEntityManager();
        $pedido = $em->find('PafpfcBundle:Pedido' , $id);
        $detalleError = 'El pedido con id: '.$id.' ';
        if (!$pedido) throw $this->createNotFoundException($detalleError.' no existe (Error 1031)');
        
        $pedido->setEnviado(FALSE);
        $em->persist($pedido);
        $em->flush();
        
        return $this->redirect($request->headers->get('referer')); //Envia a la pagina anterior segun la URL!!!
    }
    
    public function pagadoAction($id)
    {        
        $request = $this->getRequest();
        $em = $this->get('doctrine')->getEntityManager();
        $pedido = $em->find('PafpfcBundle:Pedido' , $id);
        $detalleError = 'El pedido con id: '.$id.' ';
        if (!$pedido) throw $this->createNotFoundException($detalleError.' no existe (Error 1031)');
        
        $pedido->setPagado(TRUE);
        $em->persist($pedido);
        $em->flush();
        
        return $this->redirect($request->headers->get('referer')); //Envia a la pagina anterior segun la URL!!!
    }
    
    public function nopagadoAction($id)
    {        
        $request = $this->getRequest();
        $em = $this->get('doctrine')->getEntityManager();
        $pedido = $em->find('PafpfcBundle:Pedido' , $id);
        $detalleError = 'El pedido con id: '.$id.' ';
        if (!$pedido) throw $this->createNotFoundException($detalleError.' no existe (Error 1031)');
        
        $pedido->setPagado(FALSE);
        $em->persist($pedido);
        $em->flush();
        
        return $this->redirect($request->headers->get('referer')); //Envia a la pagina anterior segun la URL!!!
    }
    
    public function compradoAction()
    {   
        //Comprobamos que existe el cliente... Sino no puede comprar.
        $cliente = $this->get('security.context')->getToken()->getUser();
        if (!$cliente) throw $this->createNotFoundException('No existe el cliente (Error 1013)');
        $texto = ""; $texto = $texto." Cliente: ".$cliente->getNombre()." - ";
        //Cojo el Entity Manager, asi como los datos Request y Session.
        $em = $this->get('doctrine')->getEntityManager();
        $request = $this->getRequest();
        $session = $request->getSession();
        //Si no existe el carrito en la session salimos.
        if(!$session->has('carrito'))
        {   
            throw $this->createNotFoundException('No existe el carrito (Error 1014)');
        }
        else{
            //Si existe el carrito en la session, si no tiene productos salimos y si si tiene productos 
            //realizamos la compra (creamos un pedido en nuestro sistema y lo guardamos.)
            $carrito = $session->get('carrito'); //$session->get('carrito', $carrito);
            if(!$carrito->getProductos())
            {
                throw $this->createNotFoundException('Error el carrito esta vacio (Error 1015)');
            }
            else{
                //KK estas lineas van todas fuera.
                /*
                ////////////////////////////////////////
                //////////////////////////////////////
                // AQUI ESTARIAN TODAS LAS COMPROVACIONES ASI COMO HAY QUE 
                // RECORDAR QUE VENDRA DE UN FORMULARIO, Y habra multitud de parametros mas.
                //////////////////////////////////////
                //////////////////////////////////////
                */
                //Recuperamos la lista del carrito y comprobamos que todos los productos existen,
                //no estan descatalogados y hay suficiente stock para cumplir con la demanda. 
                $listaCarro = $carrito->getProductos();
                foreach($listaCarro as $item){
                    $texto = $texto." producto: ".$item->getProducto()->getNombre()." - ".$item->getCantidad();
                    $producto = $em->find('PafpfcBundle:Producto' , $item->getProducto()->getId());
                    $detalleError = 'El producto: '.$item->getProducto()->getId().' - '.$item->getProducto()->getNombre().' ';
                    if (!$producto) throw $this->createNotFoundException($detalleError.' no existe (Error 1018)');
                    if ($producto->getDescatalogado()) throw $this->createNotFoundException('El producto '.$producto->getId().' - '.$producto->getNombre().' esta descatalogado (Error 1019)');
                    if ($producto->getStock() < $item->getCantidad()) throw $this->createNotFoundException('No hay suficientes elementos en stock para '.$detalleError.' (Error 1020)');
                }

////////AQUI ESTARIA LA COMPRA DE PAYPAL.../////////////
////////AQUI ESTARIA LA COMPRA DE PAYPAL.../////////////
////////AQUI ESTARIA LA COMPRA DE PAYPAL.../////////////
                //Asi conseguimos la consistencia... si no se paga no se modifica la base de datos y no se generan pedidos. 
                
                $pedido = new Pedido();
                $pedido->setDireccion('Direccion pruebas nuevas');
                $pedido->setCliente($cliente);
                $pedido->setPagado(true);
                $em->persist($pedido);
                $em->flush();
               
                $texto = $texto." Pedido: ".$pedido->getId()." - ";
                foreach($listaCarro as $item){
                    //Tengo que recuperar el producto original para tener la referencia correcta a la hora de hacer 
                    //el flush en el pedido o no dejara ya q el objeto producto q esta dentro de listacarro es una copia.
                    $producto = $em->find('PafpfcBundle:Producto' , $item->getProducto()->getId());
                    //Comprobaciones sobre el producto y el pedido. Existe, es valido y hay en stock.
                    $detalleError = 'El producto: '.$item->getProducto()->getId().' - '.$item->getProducto()->getNombre().' ';
                    if (!$producto) throw $this->createNotFoundException($detalleError.' no existe (Error 1021)');
                    if ($producto->getDescatalogado()) throw $this->createNotFoundException('El producto '.$producto->getId().' - '.$producto->getNombre().' esta descatalogado (Error 1022)');
                    if ($producto->getStock() < $item->getCantidad()) throw $this->createNotFoundException('No hay suficientes elementos en stock para '.$detalleError.' (Error 1023)');
//Megamarron si aqui generamos errores en la compra AL CLIENTE YA SE LE HA COBRADO...
//Asi que aunque esten las comprobaciones pertinentes... todas ellas han de haber sido hechas tambien 
//antes de mandar los datos a paypal. Para mantener una consistencia casi total ¿haciendo dos 
//compras con diferencia de microsegundos y usuarios diferentes podria darse un error por falta de stock?
                    //Generar la linea del pedido con precio calculado, reducir el stock del producto y persistir los dos elementos.
                    $lineaped = new LineaPedido($pedido, $producto, $item->getCantidad());
                    $precioPagado = $producto->getPrecioActual() * $item->getCantidad();
                    $lineaped->setPrecioPagado($precioPagado);
                    $newStock = $producto->getStock() - $item->getCantidad();
                    $producto->setStock($newStock);
                    $em->persist($producto);
                    $texto = $texto." ListaPedido - producto: ".$lineaped->getProducto()->getNombre()." - ".$lineaped->getCantidad()." - ";
                    $em->persist($lineaped);
                }
                //Al hacer flush en este punto consigo que no se almacenen ni la linea del pedido ni la modificacion en el producto si se produjo algun error.
                $em->flush();
                $this->get('session')->setFlash('notice', $texto);
                $session->remove('carrito'); 
            }
        }
        return $this->render('PafpfcBundle:Pedido:compracorrecta.html.twig'); 
    }
    
    public function errorcompraAction()
    {   
        return $this->render('PafpfcBundle:Pedido:errorcompra.html.twig'); 
    }
}