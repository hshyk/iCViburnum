<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
	use ContainerAwareTrait;

	public function mainMenu(FactoryInterface $factory, array $options)
	{
		$menu = $factory->createItem('root', array(
            'childrenAttributes'    => array(
                'class'             => 'nav navbar-nav navbar-right',
            ),
        ));

		$menu->addChild('menu.home', array('route' => 'homepage'));
		
		$securityContext = $this->container->get('security.authorization_checker');
		if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY') || $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
		    $menu->addChild('menu.user', array('route' => 'user_main'));
		}
		else {
		  $menu->addChild('menu.login', array('route' => 'fos_user_security_login'));
		  $menu->addChild('menu.register', array('route' => 'fos_user_registration_register'));
		}
		
		$menu->addChild('menu.search', array('route' => 'search'));
		$menu->addChild('menu.about', array('route' => 'search'));
		
		return $menu;
	}
}