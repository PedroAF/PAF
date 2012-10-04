<?php

namespace Paf\pfcBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class FiltroProductosType extends AbstractType {
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('keywords', 'text', array('required'  => false, 'max_length'  => 30,));
        $builder->add('categoria', 'choice', 
                array('choices'   => array(
                    'todo' => 'Todas',
                    'pelicula' => 'Peliculas', 
                    'musica' => 'Musica',
                    'serie' => 'Series', 
                    'libro' => 'Libros'),
                'required'  => false,));
        $builder->add('orden', 'choice', 
                array('choices'   => array(
                    'NASC' => 'Nombre Ascendente', 
                    'NDES' => 'Nombre Descendente',
                    'PASC' => 'Precio Ascendente', 
                    'PDES' => 'Precio Descendente'),
                'required'  => false,));
        $builder->add('descatalogado', 'checkbox', array('label' => 'P. Descatalogados', 'required'  => false,));
        $builder->add('preciomin', 'money', array('required'  => false,));
        $builder->add('preciomax', 'money', array('required'  => false,));
    }

    public function getDefaultOptions(array $options)
    {
        return array('data_class' => 'Paf\pfcBundle\Entity\FiltroProductos',);
    }
    
    public function getName()
    {
        return 'filtroproductos';
    }
    
}