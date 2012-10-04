<?php

namespace Paf\pfcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    
    public function estaticaAction($nombre)
    {
        return $this->render('PafpfcBundle:Estaticas:'.$nombre.'.html.twig');
    }
    /*
    public function estatica2Action()
    {
        $em = $this->get('doctrine')->getEntityManager();
        $peliculas = $em->getRepository('pfcBundle:Pelicula')->findTodosAlfabeticamente();
        return $this->render('pfcBundle:Pelicula:index2.html.twig', array('peliculas' => $peliculas));
    }*/
}
