<?php

namespace Paf\pfcBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class FiltroPedidosType extends AbstractType {
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('id', 'integer', array('label' => 'Identificador del pedido', 'required'  => false,));
        $builder->add('dt1', 'date', array('label' => 'Fecha inicial de busqueda', 'required'  => false,));
        $builder->add('dt2', 'date', array('label' => 'Fecha final de busqueda', 'required'  => false,));
    }

    public function getDefaultOptions(array $options)
    {
        return array('data_class' => 'Paf\pfcBundle\Entity\FiltroPedidos',);
    }
    
    public function getName()
    {
        return 'filtropedidos';
    }
    
}