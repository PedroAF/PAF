<?php

namespace Paf\pfcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpFoundation\Response;
use Paf\pfcBundle\Form\ClienteType;
use Paf\pfcBundle\Entity\Cliente;
use Paf\pfcBundle\Entity\FiltroClientes;
use Paf\pfcBundle\Form\FiltroClientesType;
//use Paf\pfcBundle\Entity\Pedido;
//use Paf\pfcBundle\Entity\LineaPedido; 

class ClienteController extends Controller
{
    public function perfilAction()
    {        
        $cliente = $this->get('security.context')->getToken()->getUser();
        if (!$cliente) throw $this->createNotFoundException('No existe el cliente (Error 3001)');
        //Desde el cliente puedo ver los pedidos en twig mismamente con getPedidos
        
        return $this->render('PafpfcBundle:Cliente:perfil.html.twig', array('cliente' => $cliente));
    }
    
    public function loginAction()
    {
        return $this->render('PafpfcBundle:Cliente:login.html.twig',
                array('last_username' => 
                    $this->get('request')->getSession()->get(SecurityContext::LAST_USERNAME),
                    'error' => 
                    $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR)
                ));
        
        /* //segun el manual symfony symfony.com/doc/current/book/security.html#encoding-the-user-s-password
        public function loginAction()
        {
            $request = $this->getRequest();
            $session = $request->getSession();

            // get the login error if there is one
            if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
                $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
            } else {
                $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            }

            return $this->render('AcmeSecurityBundle:Security:login.html.twig', array(
                // last username entered by the user
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
            ));
        }
         */
    }
    
    public function registroAction()
    {
        // el array que dejo vacio serian los valores iniciales por defecto del formulario
        $form = $this->get('form.factory')->create(new ClienteType(), array());
        
        //recoger la peticion mediante el inyector de dependencias
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                
                // Todo OK
                $session = $this->get('request')->getSession();
                $session->setFlash('notice', 'Gracias por registrarte');
                // Obtenemos el usuario
                $usuario = $form->getData();
                
                // Codificamos el password
                $factory = $this->get('security.encoder_factory');
                $codificador = $factory->getEncoder($usuario);
                $password = $codificador->encodePassword($usuario->getPassword(), $usuario->getSalt());
                $usuario->setPassword($password);

                // Guardamos el objeto en base de datos
                $em = $this->get('doctrine')->getEntityManager();
                $em->persist($usuario);
                $em->flush();

                // Logueamos al usuario
                $token = new UsernamePasswordToken($usuario, null, 'main', $usuario->getRoles());
                $this->get('security.context')->setToken($token);
                
////CAMBIAR URL
                //return $this->redirect($this->generateUrl('estatica'));
                return $this->render('PafpfcBundle:Estaticas:inicio.html.twig');
            }
        }
        
        return $this->render('PafpfcBundle:Cliente:registro.html.twig', array('form' => $form->createView()));
    }
    
    public function showAction($id)
    {
        $em = $this->get('doctrine')->getEntityManager();
        $cliente = $em->find('PafpfcBundle:Cliente' , $id);
        $detalleError = 'El cliente con id: '.$id.' ';
        if (!$cliente) throw $this->createNotFoundException($detalleError.' no existe (Error 1027)');
        
        return $this->render('PafpfcBundle:Cliente:show.html.twig', array('cliente' => $cliente));
    }
    
    public function listaclientesAction()
    {
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
    }
    
}