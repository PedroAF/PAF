<?php

namespace Paf\pfcBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MusicaType extends AbstractType {
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('nombre', 'text', array( 'label' => 'Titulo del disco'));
        $builder->add('autor', 'text');
        $builder->add('discografica', 'text');
        $builder->add('descripcion', 'textarea');
        $builder->add('precio', 'money');
        $builder->add('descuento', 'number');
        $builder->add('stock', 'integer');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Paf\pfcBundle\Entity\Musica',
        );
    }
    
    public function getName()
    {
        return 'musica';
    }
    
}
