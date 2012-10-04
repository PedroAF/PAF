<?php

namespace Paf\MyBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class testingController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PafMyBundle:testing:index.html.twig', array('name' => $name));
        // render a template
    }
}
