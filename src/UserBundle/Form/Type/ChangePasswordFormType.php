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
use FOS\UserBundle\Form\Type\ChangePasswordFormType as BaseType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;


class ChangePasswordFormType extends BaseType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('current_password', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'), array(
            'label' => 'form.current_password',
            'translation_domain' => 'FOSUserBundle',
            'mapped' => false,
            'constraints' => new UserPassword(),
            'attr' => array(
                    'class' => 'form-control'
                  )
        ));
        $builder->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
            'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
            'options' => array('translation_domain' => 'FOSUserBundle'),
            'first_options' => array('label' => 'form.new_password','attr' => array(
                    'class' => 'form-control'
                  )),
            'second_options' => array('label' => 'form.new_password_confirmation','attr' => array(
                    'class' => 'form-control'
                  )),
            'invalid_message' => 'fos_user.password.mismatch',
        ));
    }
}
