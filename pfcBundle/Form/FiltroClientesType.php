<?php

namespace Paf\pfcBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class FiltroClientesType extends AbstractType {
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('id', 'integer', array('required'  => false,));
        $builder->add('keywords', 'text', array('required'  => false, 'max_length'  => 30,));
    }

    public function getDefaultOptions(array $options)
    {
        return array('data_class' => 'Paf\pfcBundle\Entity\FiltroClientes',);
    }
    
    public function getName()
    {
        return 'filtroclientes';
    }
    
}