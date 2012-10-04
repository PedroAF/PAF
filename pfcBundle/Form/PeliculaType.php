<?php

namespace Paf\pfcBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PeliculaType extends AbstractType {
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('nombre', 'text', array( 'label' => 'Titulo de la pelicula'));
        $builder->add('director', 'text');
        $builder->add('descripcion', 'textarea');
        $builder->add('precio', 'money');
        $builder->add('descuento', 'number');
        $builder->add('stock', 'integer');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Paf\pfcBundle\Entity\Pelicula',
        );
    }
    
    public function getName()
    {
        return 'pelicula';
    }
    
}
