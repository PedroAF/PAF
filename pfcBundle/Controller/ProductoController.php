<?php

namespace Paf\pfcBundle\Controller;

use Symfony\Component\HttpFoundation\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request; // creo que no es necesario. 
use Paf\pfcBundle\Form\FiltroProductosType;
use Paf\pfcBundle\Form\PeliculaType;
use Paf\pfcBundle\Form\SerieType;
use Paf\pfcBundle\Form\MusicaType;
use Paf\pfcBundle\Form\LibroType;
use Paf\pfcBundle\Entity\Carrito;
use Paf\pfcBundle\Entity\LineaCarrito;
use Paf\pfcBundle\Entity\FiltroProductos;


class ProductoController extends Controller
{
    public function listatodosAction()
    {
        //ponemos default las variables del filtro como es busqueda de un usuario descatalogado = FALSE;
        $descat = FALSE;    $categoria='';   $ke = '';   $at='nombre';   $or='ASC';  $pmin=0.0;   $pmax=0.0;
        $em = $this->get('doctrine')->getEntityManager();
        $defaultFiltro = new FiltroProductos();
        $defaultFiltro->setCategoria('todo');
        $defaultFiltro->setOrden('NDES');
        //el array serian los valores iniciales por defecto del formulario
        $form = $this->get('form.factory')->create(new FiltroProductosType(), $defaultFiltro);
        
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            //lincamos y recuperamos datos.
            $form->bindRequest($request);
            
            // KK no funciona para variar...if ($form->isValid()) {

                $filtro = $form->getData();
                $ke = $filtro->getKeywords();
                $orden = $filtro->getOrden();
                $categoria = $filtro->getCategoria();
                $pmin = $filtro->getPreciomin();
                $pmax = $filtro->getPreciomax();
                //modificamos orden segun el filtro
                switch ($orden){
                    case 'NASC':
                        $at='nombre';   $or='ASC';
                        break;
                    case 'PASC':
                        $at='precio';   $or='ASC';
                        break;
                    case 'NDES':
                        $at='nombre';   $or='DESC';
                        break;
                    case 'PDES':
                        $at='precio';   $or='DESC';
                        break;
                    default :
                        $at='nombre';   $or='ASC';                    
                }

    //modificamos categoria segun el filtro
    //
    // ESTA POR HACER: cuando tenga todos los buscadores generales solo tendre que 
    // Hacer todo lo que tiene hecho peliculas 
    // crear controllers para cada categoria 
    // 
    // FALTA TAMBIEN MANEJAR EN LA BUSQUEDA LOS DESCATALOGADOS, pero eso mas adelante. 
    //            
                switch ($categoria){
                    case 'pelicula':
                        $productos = $em->getRepository('PafpfcBundle:Producto')->findTodos($categoria,$ke, $at, $or, $pmin, $pmax, $descat);
                        //$productos = $em->getRepository('PafpfcBundle:Pelicula')->findPeliculas($ke, $at, $or, $pmin, $pmax);
                        break;
                    case 'serie':
                        $productos = $em->getRepository('PafpfcBundle:Producto')->findTodos($categoria,$ke, $at, $or, $pmin, $pmax, $descat);
                        break;
                    case 'musica':
                        $productos = $em->getRepository('PafpfcBundle:Producto')->findTodos($categoria,$ke, $at, $or, $pmin, $pmax, $descat);
                        break;
                    case 'libro':
                        $productos = $em->getRepository('PafpfcBundle:Producto')->findTodos($categoria,$ke, $at, $or, $pmin, $pmax, $descat);
                        break;
                    default :
                        $productos = $em->getRepository('PafpfcBundle:Producto')->findTodos($categoria,$ke, $at, $or, $pmin, $pmax, $descat);                    
                }
                return $this->render('PafpfcBundle:Producto:listaproductos.html.twig', array('productos' => $productos, 'form' => $form->createView()));
            //} //end if ($form->isValid()) {   
        }
        $productos = $em->getRepository('PafpfcBundle:Producto')->findTodos($categoria, $ke, $at, $or, $pmin, $pmax, $descat);
        return $this->render('PafpfcBundle:Producto:listaproductos.html.twig', array('productos' => $productos, 'form' => $form->createView()));        
    }
    
    public function showAction($id)
    {
        $em = $this->get('doctrine')->getEntityManager();
        $producto = $em->find('PafpfcBundle:Producto' , $id);
        $detalleError = 'El producto con id: '.$id.' ';
        if (!$producto) throw $this->createNotFoundException($detalleError.' no existe (Error 2001)');
        
        return $this->render('PafpfcBundle:Producto:show.html.twig', array('producto' => $producto)); 
    }
    
    public function listatodosAAction()
    {
        //ponemos default las variables del filtro como es busqueda de un usuario descatalogado = FALSE;
        $descat = FALSE;    $categoria='';  $ke = '';   $at='nombre';   $or='ASC';  $pmin=0.0;   $pmax=0.0;
        $em = $this->get('doctrine')->getEntityManager();
        
        //el array serian los valores iniciales por defecto del formulario
        $form = $this->get('form.factory')->create(new FiltroProductosType(), array());
        
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            //lincamos y recuperamos datos.
            $form->bindRequest($request);
            
            // KK no funciona para variar...if ($form->isValid()) {
            
                $filtro = $form->getData();
                $ke = $filtro->getKeywords();
                $orden = $filtro->getOrden();
                $categoria = $filtro->getCategoria();
                $pmin = $filtro->getPreciomin();
                $pmax = $filtro->getPreciomax();                
                $descat = $filtro->getDescatalogado();
                //modificamos orden segun el filtro
                switch ($orden){
                    case 'NASC':
                        $at='nombre';   $or='ASC';
                        break;
                    case 'PASC':
                        $at='precio';   $or='ASC';
                        break;
                    case 'NDES':
                        $at='nombre';   $or='DESC';
                        break;
                    case 'PDES':
                        $at='precio';   $or='DESC';
                        break;
                    default :
                        $at='nombre';   $or='ASC';                    
                }

                //modificamos categoria segun el filtro
                switch ($categoria){
                    case 'pelicula':
                        $productos = $em->getRepository('PafpfcBundle:Producto')->findTodos($categoria,$ke, $at, $or, $pmin, $pmax, $descat);
                        break;
                    case 'serie':
                        $productos = $em->getRepository('PafpfcBundle:Producto')->findTodos($categoria,$ke, $at, $or, $pmin, $pmax, $descat);
                        break;
                    case 'musica':
                        $productos = $em->getRepository('PafpfcBundle:Producto')->findTodos($categoria,$ke, $at, $or, $pmin, $pmax, $descat);
                        break;
                    case 'libro':
                        $productos = $em->getRepository('PafpfcBundle:Producto')->findTodos($categoria,$ke, $at, $or, $pmin, $pmax, $descat);
                        break;
                    default :
                        $productos = $em->getRepository('PafpfcBundle:Producto')->findTodos($categoria,$ke, $at, $or, $pmin, $pmax, $descat);                    
                }

                return $this->render('PafpfcBundle:Producto:listaproductos.html.twig', array('productos' => $productos, 'form' => $form->createView()));
            //} //end if ($form->isValid()) {
        }
        
        $productos = $em->getRepository('PafpfcBundle:Producto')->findTodos($categoria,$ke, $at, $or, $pmin, $pmax, $descat);
        return $this->render('PafpfcBundle:Producto:listaproductos.html.twig', array('productos' => $productos, 'form' => $form->createView()));        
    }
    
    public function editAAction($id)
    {
        $em = $this->get('doctrine')->getEntityManager();
        $producto = $em->find('PafpfcBundle:Producto' , $id);
        $detalleError = 'El producto con id: '.$id.' ';
        if (!$producto) throw $this->createNotFoundException($detalleError.' no existe (Error 2002)');
        
        switch ($producto->getCategoria()){
            case 'pelicula':
                        // Paso el producto como array al formulario para que se rellenen los campos default
                        $form = $this->get('form.factory')->create(new PeliculaType(), $producto);
                        //recoger la peticion mediante el inyector de dependencias
                        $request = $this->get('request');
                        //comprobar que el metodo es post, si es asi linkamos la peticion y comprobamos. 
                        if ($request->getMethod() == 'POST') {
                            $form->bindRequest($request);
                            
                            //KK da problemas if ($form->isValid()) {
                                // Obtenemos los datos del formulatio
                                $producto = $form->getData();
                                $producto->setSlug("ProductoEditado");
                                //El estar descatalogado se hace con la funcion deleteAAction y mas adelante implementare el recatalogarAAction.
                                //Guardamos el objeto en base de datos
                                $em->persist($producto);
                                $em->flush();
                                //Creamos un flash message para sesion en el template show para mostrar el mens de edicion correcta. Fash messages are meant to live for exactly one request
                                $this->get('session')->setFlash('notice', 'Tus cambios han sido guardados correctamente');
                                
                                return $this->render('PafpfcBundle:Producto:show.html.twig', array('producto' => $producto));  
                            //KK da problemas }
                        }
                        return $this->render('PafpfcBundle:Producto:edit.html.twig', array('form' => $form->createView(), 'producto' => $producto));                
                break;
            case 'serie':
                        // Paso el producto como array al formulario para que se rellenen los campos default
                        $form = $this->get('form.factory')->create(new SerieType(), $producto);
                        //recoger la peticion mediante el inyector de dependencias
                        $request = $this->get('request');
                        //comprobar que el metodo es post, si es asi linkamos la peticion y comprobamos. 
                        if ($request->getMethod() == 'POST') {
                            $form->bindRequest($request);
                            
                            //KK da problemas if ($form->isValid()) {
                                // Obtenemos los datos del formulatio
                                $producto = $form->getData();
                                $producto->setSlug("ProductoEditado");
                                $em->persist($producto);
                                $em->flush();

                                return $this->render('PafpfcBundle:Producto:show.html.twig', array('producto' => $producto));  
                            //KK da problemas }
                        }
                        return $this->render('PafpfcBundle:Producto:edit.html.twig', array('form' => $form->createView(), 'producto' => $producto));                
                break;
            case 'libro':
                        // Paso el producto como array al formulario para que se rellenen los campos default
                        $form = $this->get('form.factory')->create(new LibroType(), $producto);
                        //recoger la peticion mediante el inyector de dependencias
                        $request = $this->get('request');
                        //comprobar que el metodo es post, si es asi linkamos la peticion y comprobamos. 
                        if ($request->getMethod() == 'POST') {
                            $form->bindRequest($request);
                            
                            //KK da problemas if ($form->isValid()) {
                                // Obtenemos los datos del formulatio
                                $producto = $form->getData();
                                $producto->setSlug("ProductoEditado");
                                //El estar descatalogado se hace con la funcion deleteAAction y mas adelante implementare el recatalogarAAction.
                                //Guardamos el objeto en base de datos
                                $em->persist($producto);
                                $em->flush();

                                return $this->render('PafpfcBundle:Producto:show.html.twig', array('producto' => $producto));  
                            //KK da problemas }
                        }
                        return $this->render('PafpfcBundle:Producto:edit.html.twig', array('form' => $form->createView(), 'producto' => $producto));                
                break;
            case 'musica':
                        // Paso el producto como array al formulario para que se rellenen los campos default
                        $form = $this->get('form.factory')->create(new MusicaType(), $producto);
                        //recoger la peticion mediante el inyector de dependencias
                        $request = $this->get('request');
                        //comprobar que el metodo es post, si es asi linkamos la peticion y comprobamos. 
                        if ($request->getMethod() == 'POST') {
                            $form->bindRequest($request);
                            
                            //KK da problemas if ($form->isValid()) {
                                // Obtenemos los datos del formulatio 
                                $producto = $form->getData();
                                $producto->setSlug("ProductoEditado");
                                //Guardamos el objeto en base de datos
                                $em->persist($producto);
                                $em->flush();

                                return $this->render('PafpfcBundle:Producto:show.html.twig', array('producto' => $producto));  
                            //KK da problemas }
                        }
                        return $this->render('PafpfcBundle:Producto:edit.html.twig', array('form' => $form->createView(), 'producto' => $producto));                
                break;
            default:
                
                throw $this->createNotFoundException($producto->getCategoria().' no es una categoria valida (Error 2003)');
                return $this->render('PafpfcBundle:Estaticas:inicio.html.twig'); //KK aqui deberia salir mens de error... Categoria no existe.
        }
    }
    
    public function newAAction($categoria)
    {
        //Necesario marcar la zona horaria de España.
        $timezone = new \DateTimeZone("Europe/Madrid"); //$dt = new \DateTime("now", $timezone);
        //Sera diferente segun la categoria.
        switch ($categoria){
                    case 'pelicula':
                        // el array que dejo vacio serian los valores iniciales por defecto del formulario
                        $form = $this->get('form.factory')->create(new PeliculaType(), array());

                        //recoger la peticion mediante el inyector de dependencias
                        $request = $this->get('request');

                        //comprobar que el metodo es post, si es asi linkamos la peticion y comprobamos. 
                        if ($request->getMethod() == 'POST') {
                            $form->bindRequest($request);

                            //KK da problemas if ($form->isValid()) {
                                // Obtenemos los datos del formulatio y rellenamos algunos mas.
                                $pelicula = $form->getData();
                                $pelicula->setSlug("SlugAuxProdControllerNew");
                                $pelicula->setCreated(new \DateTime("now", $timezone));
                                $pelicula->setDescatalogado(false);
                                //Guardamos el objeto en base de datos
                                $em = $this->get('doctrine')->getEntityManager();
                                $em->persist($pelicula);
                                $em->flush();

                                return $this->render('PafpfcBundle:Producto:show.html.twig', array('producto' => $pelicula));  
                            //KK da problemas }
                        }
                        return $this->render('PafpfcBundle:Producto:new.html.twig', array('form' => $form->createView(), 'categoria' => $categoria));
                        break;
                    case 'serie':
                        // el array que dejo vacio serian los valores iniciales por defecto del formulario
                        $form = $this->get('form.factory')->create(new SerieType(), array());

                        //recoger la peticion mediante el inyector de dependencias
                        $request = $this->get('request');

                        //comprobar que el metodo es post, si es asi linkamos la peticion y comprobamos. 
                        if ($request->getMethod() == 'POST') {
                            $form->bindRequest($request);

                            //KK da problemas if ($form->isValid()) {
                                // Obtenemos los datos del formulatio y rellenamos algunos mas.
                                $serie = $form->getData();
                                $serie->setSlug("SlugAuxProdControllerNew");
                                $serie->setCreated(new \DateTime("now"), $timezone);
                                $serie->setDescatalogado(false);
                                //Guardamos el objeto en base de datos
                                $em = $this->get('doctrine')->getEntityManager();
                                $em->persist($serie);
                                $em->flush();

                                return $this->render('PafpfcBundle:Producto:show.html.twig', array('producto' => $serie));  
                            //KK da problemas }
                        }
                        return $this->render('PafpfcBundle:Producto:new.html.twig', array('form' => $form->createView(), 'categoria' => $categoria));
                        break;
                    case 'musica':
                        // el array que dejo vacio serian los valores iniciales por defecto del formulario
                        $form = $this->get('form.factory')->create(new MusicaType(), array());

                        //recoger la peticion mediante el inyector de dependencias
                        $request = $this->get('request');

                        //comprobar que el metodo es post, si es asi linkamos la peticion y comprobamos. 
                        if ($request->getMethod() == 'POST') {
                            $form->bindRequest($request);

                            //KK da problemas if ($form->isValid()) {
                                // Obtenemos los datos del formulatio y rellenamos algunos mas.
                                $musica = $form->getData();
                                $musica->setSlug("SlugAuxProdControllerNew");
                                $musica->setCreated(new \DateTime("now", $timezone));
                                $musica->setDescatalogado(false);
                                //Guardamos el objeto en base de datos
                                $em = $this->get('doctrine')->getEntityManager();
                                $em->persist($musica);
                                $em->flush();

                                return $this->render('PafpfcBundle:Producto:show.html.twig', array('producto' => $musica));  
                            //KK da problemas }
                        }
                        return $this->render('PafpfcBundle:Producto:new.html.twig', array('form' => $form->createView(), 'categoria' => $categoria));
                        
                        break;
                    case 'libro':
                        // el array que dejo vacio serian los valores iniciales por defecto del formulario
                        $form = $this->get('form.factory')->create(new LibroType(), array());

                        //recoger la peticion mediante el inyector de dependencias
                        $request = $this->get('request');

                        //comprobar que el metodo es post, si es asi linkamos la peticion y comprobamos. 
                        if ($request->getMethod() == 'POST') {
                            $form->bindRequest($request);

                            //KK da problemas if ($form->isValid()) {
                                // Obtenemos los datos del formulatio y rellenamos algunos mas.
                                $libro = $form->getData();
                                $libro->setSlug("SlugAuxProdControllerNew");
                                $libro->setCreated(new \DateTime("now", $timezone));
                                $libro->setDescatalogado(false);
                                //Guardamos el objeto en base de datos
                                $em = $this->get('doctrine')->getEntityManager();
                                $em->persist($libro);
                                $em->flush();

                                return $this->render('PafpfcBundle:Producto:show.html.twig', array('producto' => $libro));  
                            //KK da problemas }
                        }
                        return $this->render('PafpfcBundle:Producto:new.html.twig', array('form' => $form->createView(), 'categoria' => $categoria));
                        
                        break;
                    default :                
                        throw $this->createNotFoundException($producto->getCategoria().' no es una categoria valida (Error 2004)');
                        return $this->render('PafpfcBundle:Estaticas:inicio.html.twig'); //KK aqui deberia salir mens de error... Categoria no existe.
                        
                }
    }
    /*  $form = $this->get('form.factory')->create(new PeliculaType(), array());
        //recoger la peticion mediante el inyector de dependencias
        $request = $this->get('request');
        if($request->getMethod() == 'POST'){   }
        return $this->render('PafpfcBundle:Producto:new.html.twig', array('form' => $form->createView()));
        //return new Response('<p></p>Formulario para crear un nuevo producto: '.$categoria);*/
    
    public function deleteAAction($id)
    {        
        $em = $this->get('doctrine')->getEntityManager();
        $producto = $em->find('PafpfcBundle:Producto' , $id);
        $detalleError = 'El producto con id: '.$id.' ';
        if (!$producto) throw $this->createNotFoundException($detalleError.' no existe (Error 2005)');
        
        $texto = "ID-input:".$id." ID-prod:".$producto->getId()." Descatalogado-Antes:".$producto->getDescatalogado();
        $producto->setDescatalogado(TRUE);
        $texto = $texto." despues:".$producto->getDescatalogado();
        $em->persist($producto);
        $em->flush();
        return new Response('<p>'.$texto.'</p><p>Formulario para eliminar un producto con id:'.$id.'</br> Quiza seria 
            mejor no hacer nigun paso intermedio, solo un popup para que confirme que quiere eliminar el producto.
            </br>Tambien recordar, que no se eliminan los productos desde el programa, se descatalogan pues aparecen 
            en facturas antiguas aunque no se vuelvan a vender y se quiere conservar sus datos.</p>');
    }
    
    public function recoverAAction($id)
    {        
        $em = $this->get('doctrine')->getEntityManager();
        $producto = $em->find('PafpfcBundle:Producto' , $id);
        $detalleError = 'El producto con id: '.$id.' ';
        if (!$producto) throw $this->createNotFoundException($detalleError.' no existe (Error 2006)');
        
        $texto = "ID-input:".$id." ID-prod:".$producto->getId()." Descatalogado-Antes:".$producto->getDescatalogado();
        $producto->setDescatalogado(FALSE);
        $texto = $texto." despues:".$producto->getDescatalogado();
        $em->persist($producto);
        $em->flush();
        return new Response('<p>'.$texto.'</p><p>Formulario para eliminar un producto con id:'.$id.'</br> Quiza seria 
            mejor no hacer nigun paso intermedio, solo un popup para que confirme que quiere recatalogar el producto o para informar de que se ha recatalogado el producto.
            </br>Tambien recordar, que no se eliminan los productos desde el programa, se descatalogan/recatalogan pues aparecen 
            en facturas antiguas aunque no se vuelvan a vender y se quiere conservar sus datos.</p>');
    }
    
    public function addtocartAction($id, $cantidad)
    {   
        //recoger la peticion mediante el inyector de dependencias
        $request = $this->getRequest();
        $session = $request->getSession();

        //comprobar que el metodo es post
        if ($request->getMethod() == 'POST') {
            $cantidad = $request->request->get('cantidad');
        }
           
        //KK hay muchas trazas de texto, tendre que quitar todo lo no necesario.
        $uno = 1;
        $detalleError = 'El producto con id: '.$id.' ';
        //Con el EntityManager busco el producto
        $em = $this->get('doctrine')->getEntityManager();
        $producto = $em->find('PafpfcBundle:Producto' , $id);
        if (!$producto) throw $this->createNotFoundException($detalleError.' no existe (Error 2007)');
        if ($producto->getDescatalogado()) throw $this->createNotFoundException($detalleError.' esta descatalogado (Error 2008)');
        if ($producto->getStock() < $uno) throw $this->createNotFoundException($detalleError.' no lo tenemos disponible en estos momentos. Out of stock. (Error 2009)');
        if(!$session->has('carrito'))
        {
            //Si no hay aun carrito se crea, se genera la linea de producto y se almacena en la sesion
            $carrito = new Carrito();
            $lineacarrito = new LineaCarrito( $carrito, $producto, $cantidad);
            $carrito->addProductos($lineacarrito);
            $session->set('carrito', $carrito);
            
        }
        else{
            //Si ya existe carrito, lo cogemos de la sesion, comprobamos que el producto no esta ya en el carro 
            //y lo añadimos en forma de linea carrito
            $carrito = $session->get('carrito');
            $itemrepetido= false;
            $listaCarro = $carrito->getProductos();
            foreach($listaCarro as $item){
                if($item->getProducto()==$producto) {
                    $itemrepetido = true;
                    $newamount = $item->getCantidad() + $cantidad;
                    if( $newamount > $item->getProducto()->getStock()){
                        throw $this->createNotFoundException($detalleError.' que ya esta en tu carrito no tiene suficientes productos en stock para la compra en estos momentos. Stock('.$item->getProducto()->getStock().') (Error 20010)');
                    }
                    else{
                        $item->setCantidad($newamount);
                    }
                }
            } 
            if($itemrepetido==false)
            {
                $lineacarrito = new LineaCarrito( $carrito, $producto, $cantidad);
                $carrito->addProductos($lineacarrito);

                $session->set('carrito', $carrito);
            }
            //else throw $this->createNotFoundException($detalleError.' ya esta en tu carrito de la compra en estos momentos. (Error 20010)');
        }
        /*
        $lineacarro = array('id' => $id, 'cantidad' => $cantidad);
        $session->set('linea', $lineacarro);
        $texto = "Se ha añadido el elemento ID-input:".$id." ID-prod:".$producto->getId()." Con cantidad: ".$cantidad." Al carrito";
        */
        $texto = "";
        $session->get('carrito', $carrito);
        $listaCarro = $carrito->getProductos();
        foreach($listaCarro as $item){
            $texto = $texto." producto: ".$item->getProducto()->getNombre()." </br>";
        }
        
        return $this->redirect($request->headers->get('referer')); //Envia a la pagina anterior segun la URL!!!
        //NO ENTIENDO PORQUE AKI SACA OTRA VENTANA Y EN PedidoControler clearCart sale en la misma. 
        
        
        //return new Response('<p>'.var_dump($this).'</p>');
        //return $this->redirect($this->getRequestParameter('referer', '@homepage')); //sf1
        /*
        //el array serian los valores iniciales por defecto del formulario
        $form = $this->get('form.factory')->create(new FiltroProductosType(), array());
        
        return $this->render('PafpfcBundle:Producto:listaproductos.html.twig', array('productos' => $productos, 'form' => $form->createView())); 
        */
        //$request = $this->getRequest();
        //.' - '.$request->query.get('cantidad')
        //return new Response('<p>'.$texto.'</p>');
        
        //$referer = $request->headers->get('referer'); //si va
        //return new Response('<p>'.$referer.'</p>'); //si va
        
        //return $this->forward('PafpfcBundle:Producto:listatodos');
        // Esto ejecuta el controlador y muestra listatodos pero no cambia la url... lo cual genera problemas. 
        //return $this->render('PafpfcBundle:Producto:listaproductos.html.twig', array('productos' => $productos, 'form' => $form->createView()));  
    }
//http://symfony.com/doc/current/book/controller.html //cookbook controller
//this->render y new Response abren una nueva ventana.
//
//return $this->redirect($this->generateUrl('listaproductos'), 301);
//return $this->redirect($this->generateUrl('listaproductos'), 302); // Tambien me abre una ventana nueva.
//By default, the redirect() method performs a 302 (temporary) redirect. To perform a 301 (permanent) redirect, modify the second argument:
//The redirect() method is simply a shortcut that creates a Response object that specializes in redirecting the user. It's equivalent to:
//use Symfony\Component\HttpFoundation\RedirectResponse;
//return new RedirectResponse($this->generateUrl('homepage'));
//
//return $this->forward('PafpfcBundle:Producto:addtocart', array('id' => 9998, 'cantidad' => 10));
// tambien abre nueva ventana porque el propio addtochart lo hace con lo que el forwarding realmente no es el responsable
}