<?php

namespace Paf\pfcBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ClienteType extends AbstractType {
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('nombre', 'text', array());
        $builder->add('apellidos', 'textarea');
        $builder->add('alias');
        $builder->add('password', 'repeated', array('type' => 'password'));
        $builder->add('email');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Paf\pfcBundle\Entity\Cliente',
        ); 
    }
    
    public function getName()
    {
        return 'cliente';
    }
    
}