<?php

namespace AppBundle\Form\Type;

use AppBundle\Form\MultipleEntitiesType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use AppBundle\Form\EventListener\AddressLookupSubscriber;
use AppBundle\Form\EventListener\ImageUploaderSubscriber;
use AppBundle\Form\DataTransformer\DateTransformer;

class UserObservationType extends MultipleEntitiesType
{

    private $addressSubscriber;
    
    public function __construct($managerResgistry, AddressLookupSubscriber $addressSubscriber)
    {
        $this->addressSubscriber = $addressSubscriber;
        parent::__construct($managerResgistry);
    }
    
     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $locationData['label'] = 'form.observation.locationdetail';
        if ($builder->getData()->getId() == NULL) {
            $locationData['data'] = 'New observation';
        }
        $locationData['attr'] = array('class' => 'form-control');
        
        $emTaxa = $this->managerRegistry->getRepository('AppBundle:VirtualViburnum\Taxon','virtualviburnum');
        $builder
            ->add('organism', ChoiceType::class, array(
                'choices' => $emTaxa->findAll(),
                'choice_value' => 'id',
                'choice_label' => 'scientificName',
                'label' => 'form.observation.organism',
                'required' => true,
                'choice_translation_domain' => false,
                'attr' => array(
                    'class' => 'form-control'
                )
                )
           )
            ->add('dateObserved', DateType::class, 
                 ['widget' => 'single_text', 'format' => \IntlDateFormatter::LONG,
                'attr' => [
                    'class' => 'form-control input-inline datepicker',
                    'data-provide' => 'datepicker',
                    'data-date-format' => 'MM dd, yyyy'
                 ]
                ])
            ->add('howAdd', ChoiceType::class, array(
                    'choices'  => array(
                        '----------------------------' => 'none',
                        'form.observation.location.current' => 'current',
                        'form.observation.location.address' =>'address',
                        'form.observation.location.map' => 'map',
                        'form.observation.location.previous' => 'previous'
                    ),
                    'label' => 'form.observation.howadd',
                    'required' => true,
                    'mapped' => false,
                    'choice_translation_domain' => 'messages',
                    'attr' => array(
                        'class' => 'form-control'
                    )
                )
                    )
            ->add('address', TextType::class, array(
                'mapped' => false,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('previous', ChoiceType::class, array(
                'mapped' => false,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('latitude', HiddenType::class)
            ->add('longitude', HiddenType::class)
            ->add('locationdetail', TextType::class, $locationData)
            ->add('status', EntityType::class, array(
                'class' => 'AppBundle:iCViburnum\Observationstatus',
                'choice_label' => 'name',
                'attr' => array(
                    'class' => 'form-control'
                )
                
            ))
            ->addEventSubscriber($this->addressSubscriber);

            
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\iCViburnum\Observation',
            'attr' =>array('novalidate'=>'novalidate'),
        ));
    }
}
