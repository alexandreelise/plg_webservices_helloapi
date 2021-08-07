<?php
/**
 * Web Services - Helloapi
 * 
 * @package    Helloapi
 *
 * @author     Alexandre ELISÉ <contact@alexandre-elise.fr>
 * @copyright  Copyright(c) 2009 - 2021 Alexandre ELISÉ. All rights reserved
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       Alexandre ELISÉ
 */

defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Router\ApiRouter;
use Joomla\Router\Route;

/**
 * Web Services adapter for com_example.
 *
 * @since  4.0.0
 */
class PlgWebservicesHelloapi extends CMSPlugin
{
	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 * @since  4.0.0
	 */
	protected $autoloadLanguage = true;

	/**
	 * Registers com_example's API's routes in the application
	 *
	 * @param   ApiRouter  &$router  The API Routing object
	 *
	 * @return  void
	 *
	 * @since   4.0.0
	 */
	public function onBeforeApiRoute(&$router)
	{
		$router->createCRUDRoutes(
			'v1/helloapi/helloapi',
			'helloapi',
			['component' => 'com_example']
		);

		$router->createCRUDRoutes(
			'v1/helloapi/categories',
			'categories',
			['component' => 'com_categories', 'extension' => 'com_example']
		);

		$this->createFieldsRoutes($router);

		$this->createContentHistoryRoutes($router);
	}

	/**
	 * Create fields routes
	 *
	 * @param   ApiRouter  &$router  The API Routing object
	 *
	 * @return  void
	 *
	 * @since   4.0.0
	 */
	private function createFieldsRoutes(&$router)
	{
		$router->createCRUDRoutes(
			'v1/fields/helloapi/helloapi',
			'fields',
			['component' => 'com_fields', 'context' => 'com_example.helloapi']
		);

		$router->createCRUDRoutes(
			'v1/fields/helloapi/categories',
			'fields',
			['component' => 'com_fields', 'context' => 'com_example.categories']
		);

		$router->createCRUDRoutes(
			'v1/fields/groups/helloapi/helloapi',
			'groups',
			['component' => 'com_fields', 'context' => 'com_example.helloapi']
		);

		$router->createCRUDRoutes(
			'v1/fields/groups/helloapi/categories',
			'groups',
			['component' => 'com_fields', 'context' => 'com_example.categories']
		);
	}

	/**
	 * Create contenthistory routes
	 *
	 * @param   ApiRouter  &$router  The API Routing object
	 *
	 * @return  void
	 *
	 * @since   4.0.0
	 */
	private function createContentHistoryRoutes(&$router)
	{
		$defaults    = [
			'component'  => 'com_contenthistory',
			'type_alias' => 'com_example.helloapi',
			'type_id'    => 1,
		];
		$getDefaults = array_merge(['public' => false], $defaults);

		$routes = [
			new Route(['GET'], 'v1/helloapi/helloapi/:id/contenthistory', 'history.displayList', ['id' => '(\d+)'], $getDefaults),
			new Route(['PATCH'], 'v1/helloapi/helloapi/:id/contenthistory/keep', 'history.keep', ['id' => '(\d+)'], $defaults),
			new Route(['DELETE'], 'v1/helloapi/helloapi/:id/contenthistory', 'history.delete', ['id' => '(\d+)'], $defaults),
		];

		$router->addRoutes($routes);
	}
}
