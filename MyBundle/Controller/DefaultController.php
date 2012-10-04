<?php

namespace Paf\MyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Paf\MyBundle\Entity\ProductEjemplo;

class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('PafMyBundle:Default:index.html.twig', array('name' => $name));
    }
}
