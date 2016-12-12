<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\Type\RegionsType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class SearchByLocationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {	
		$builder->add('searchOptions', ChoiceType::class, array(
                    'choices'  => array(
                        '----------------------------' => true,
                        'form.observation.location.current' => 'current',
                        'form.observation.location.region' =>'region',
                        'form.observation.location.map' => 'map'
                    ),
                    'label' => 'form.search.locationoptions',
                    'required' => true,
                    'mapped' => false,
                    'choice_translation_domain' => 'messages',
        		    'attr' => array(
        		        'class' => 'form-control'
        		    )
                )
                    )
            ->add('regions', RegionsType::class)
            ->add('latitude', HiddenType::class)
            ->add('longitude', HiddenType::class);
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
