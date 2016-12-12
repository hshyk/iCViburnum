<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\Form\Type;

use FOS\UserBundle\Util\LegacyFormHelper;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
             ->add('first_name', TextType::class,  array(
                 'label' => 'form.first_name', 
                 'translation_domain' => 'FOSUserBundle', 
                 'attr' => array(
                    'class' => 'form-control'
                  )
             ))
            ->add('last_name', TextType::class,  array(
                'label' => 'form.last_name', 
                'translation_domain' => 'FOSUserBundle',
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array(
                'label' => 'form.email', 
                'translation_domain' => 'FOSUserBundle',
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('username', null, array(
                'label' => 'form.username', 
                'translation_domain' => 'FOSUserBundle',
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
                'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password',                 'attr' => array(
                    'class' => 'form-control'
                )),
                'second_options' => array('label' => 'form.password_confirmation',                'attr' => array(
                    'class' => 'form-control'
                )),
                'invalid_message' => 'fos_user.password.mismatch'
            ));
    }
    		
}
