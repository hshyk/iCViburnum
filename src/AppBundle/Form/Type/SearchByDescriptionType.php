<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Form\Type\CharacteristicsType;
use AppBundle\Form\Type\SearchByLocationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchByDescriptionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('characteristics', CollectionType::class, array(
            'entry_type' => CharacteristicsType::class,
            'allow_add' => true,
        ));
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'attr' =>array('novalidate'=>'novalidate'),
        ));
    }

}
