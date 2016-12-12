<?php

namespace AppBundle\Form\Type;

use AppBundle\Form\MultipleEntitiesType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class RegionsType extends MultipleEntitiesType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $emGadm = $this->managerRegistry->getRepository('AppBundle:iCViburnum\Gadm','icviburnum');

        $builder->add('name_0', ChoiceType::class, array(
            'label' => 'Country',
            'choices' => $emGadm->findByParentId(null),
            'placeholder' => '----- Select a country -----',
            'choice_value' => 'id',
            'choice_label' => 'country',
            'attr' => array(
                'class' => 'regions form-control'
            ),
            'mapped' => false, 
            'data' => isset(reset($_POST)['regions']) ? $this->managerRegistry->getEntityManager()->getReference("AppBundle:iCViburnum\Gadm", reset($_POST)['regions']['name_0']) : null
        ));
            
        $counter = 1;
        if (isset(reset($_POST)['regions'])) {         
            foreach(reset($_POST)['regions'] as $item) {
                    $area = $emGadm->findByParentId($item);
                    if (count($area) > 0) {
                        $name = reset($area)->getAdminType();
                        $builder->add('name_'.$counter, ChoiceType::class, array(
                            'label' => $name,
                            'choices' => $area,
                            'placeholder' => '----- Select '.$name.' -----',
                            'choice_value' => 'id',
                            'choice_label' => 'currentname',
                            'attr' => array(
                                'class' => 'regions form-control'
                            ),
                            'data' => isset(reset($_POST)['regions']['name_'.$counter]) ? $this->managerRegistry->getEntityManager()->getReference("AppBundle:iCViburnum\Gadm", reset($_POST)['regions']['name_'.$counter]) : null
                        ));
                    }
                $counter++;
            }
        }
 
    }
}
