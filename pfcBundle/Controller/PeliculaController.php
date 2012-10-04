<?php

namespace Paf\pfcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PeliculaController extends Controller
{
    public function indexAction()
    {
        $em = $this->get('doctrine')->getEntityManager();
        //he añadido al getRepository Paf
        $peliculas = $em->getRepository('PafpfcBundle:Pelicula')->findTodosAlfabeticamente();
        
        return $this->render('PafpfcBundle:Pelicula:index.html.twig', array('peliculas' => $peliculas));
    }
}
 