<?php
namespace App;

use DI\ContainerBuilder;
use DI\Bridge\Slim\App as DiBridge;

/**
 * App handler
 */
class App extends DIBridge
{
	/**
	 * Adds the app definitions
	 * @param  ContainerBuilder $builder
	 */
	protected function configureContainer(ContainerBuilder $builder)
	{
		$builder->addDefinitions([
			'settings.displayErrorDetails' => true,
		]);

		$builder->addDefinitions(__DIR__ . '/Container.php');
	}
}
