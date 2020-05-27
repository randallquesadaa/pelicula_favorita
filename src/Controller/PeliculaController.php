<?php

namespace Drupal\pelicula\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Config\ConfigFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PeliculaController extends ControllerBase
{
	/**
	 * @var ConfigFactory
	 */
    protected $config_factory;

	public function __construct(ConfigFactory $config_factory)
	{
        $this->config_factory = $config_factory;
    }
    public static function create(ContainerInterface $container)
	{
    	return new static($container->get('config.factory'));
    }

	public function index()
	{
		$config = $this->config_factory->get('pelicula.configuration');

		return [
			'#theme' => 'pelicula',
			'#title' => 'Muestra tu pelicula favorita',
			'#movie' => $config->get('pelicula'),
			'#attached' => [
				'library' => [
					'pelicula/pelicula_css_js'
				]
			]
		];
	}
}
