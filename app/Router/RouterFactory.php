<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;

/**
 * Class RouterFactory
 *
 * @package App\Router
 */
final class RouterFactory
{
	use Nette\StaticClass;

    /**
     * @return RouteList
     */
	public static function createRouter(): RouteList
	{
		$router = new RouteList();

		$router->addRoute('<presenter>/<action>[/<id>]', 'Front:Homepage:default');

		return $router;
	}
}
