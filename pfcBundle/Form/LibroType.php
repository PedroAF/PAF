<?php

namespace Paf\pfcBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class LibroType extends AbstractType {
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('nombre', 'text', array( 'label' => 'Titulo del libro'));
        $builder->add('autor', 'text');
        $builder->add('descripcion', 'textarea');
        $builder->add('precio', 'money');
        $builder->add('descuento', 'number');
        $builder->add('stock', 'integer');
    }
    //, array('currency' => "EUR",)

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Paf\pfcBundle\Entity\Libro',
        );
    }
    
    public function getName()
    {
        return 'libro';
    }
    
}
