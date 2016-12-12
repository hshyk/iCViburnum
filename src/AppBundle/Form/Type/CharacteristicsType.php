<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use AppBundle\Entity\VirtualViburnum\CharacterType;
use AppBundle\Entity\VirtualViburnum\Character;
use AppBundle\Form\MultipleEntitiesType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CharacteristicsType extends MultipleEntitiesType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	
		$emCharacterType = $this->managerRegistry->getRepository('AppBundle:VirtualViburnum\CharacterType','virtualviburnum');
		
		$builder->add('character_types', ChoiceType::class, array(
		    'choices' => $emCharacterType->findAllOrderAsc(),
			'choice_value' => 'id',
			'choice_label' => 'characterType',
		    'attr' => array(
		        'class' => 'form-control'
		    )
		));
		
		$characterFormModifier = function (FormInterface $form, CharacterType $characterType = null) {
			$characters = null === $characterType ? array() :  $characterType->getCharacters();
		
			$form->add('characters', ChoiceType::class, array(
					'choices'     => $characters,
					'choice_value' => 'id',
					'choice_label' => 'characterName',
    			    'attr' => array(
    			        'class' => 'form-control'
    			    )
			));
			
		};
		
		$stateFormModifier = function (FormInterface $form, CharacterType $characterType = null) {
			$emCharacter = $this->managerRegistry->getRepository('AppBundle:VirtualViburnum\Character','virtualviburnum');
			$data = !empty($_POST["search_by_description"]) ? reset($_POST["search_by_description"]["characteristics"]) : null;
			
			$states = array();
			$character = (null === $characterType) || (empty($data["characters"])) ? array() :  $emCharacter->find($data["characters"]);
			
			if (!empty($character) && count($character) > 0) {
			 $states = $character->getStates();
			}

			$form->add('states', ChoiceType::class, array(
					'choices'     => $states,
					'choice_value' => 'id',
					'choice_label' => 'stateName',
    			    'attr' => array(
    			        'class' => 'form-control'
    			    ),
			       //  'choice_attr' => $statesattributes
			    'choice_attr' => function ($state, $key, $value) { 
			        return array(
			            'data-help-definition' => $state->getDefinition(),
			            'data-help-url' => $state->getURL(),
			            'data-help-credit' => $state->getCredit()
			        );
			    }
			    
			));
			
			if (!empty($character) && $character->getIsNumeric()) {
			     $form->add('value', TextType::class, array(
			         'attr' => array(
			             'class' => 'form-control'
			         )
			     ));
			}
		};
		
		$builder->addEventListener(
				FormEvents::PRE_SET_DATA,
				function (FormEvent $event) use ($characterFormModifier, $stateFormModifier) {
					// this would be your entity, i.e. SportMeetup
					$data = $event->getData();

					$characterFormModifier($event->getForm(), $data);
					$stateFormModifier($event->getForm(), $data);
				}
				);
		
		$builder->get('character_types')->addEventListener(
				FormEvents::POST_SUBMIT,
				function (FormEvent $event) use ($characterFormModifier,$stateFormModifier) {
					// It's important here to fetch $event->getForm()->getData(), as
					// $event->getData() will get you the client data (that is, the ID)
					$data = $event->getForm()->getData();
					
					// since we've added the listener to the child, we'll have to pass on
					// the parent to the callback functions!

						
					$characterFormModifier($event->getForm()->getParent(), $data);
					$stateFormModifier($event->getForm()->getParent(), $data);
				}
				);
    }

}
