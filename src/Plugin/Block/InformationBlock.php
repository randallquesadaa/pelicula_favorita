<?php

namespace Drupal\pelicula\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Bloque de información
 *
 * @Block(
 *   id = "information_block",
 *   admin_label = @Translation("Pelicula Favorita"),
 * )
 */
class InformationBlock extends BlockBase implements ContainerFactoryPluginInterface
{

	/**
	 * @var AccountProxyInterface
	 */
	protected $current_user;

	/**
	 *@var ConfigFactory
	 */
	protected $config_factory;

	public function __construct(
		array $configuration,
		$plugin_id,
		$plugin_definition,
		AccountProxyInterface $current_user,
		ConfigFactory $config_factory
	) {
		parent::__construct($configuration, $plugin_id, $plugin_definition);

		$this->current_user = $current_user;
		$this->config_factory = $config_factory;
	}

	/**
	 * @param ContainerInterface $container
	 * @param array $configuration
	 * @param string $plugin_id
	 * @param mixed $plugin_definition
	 * @return static
	 */
	public static function create(
		ContainerInterface $container,
		array $configuration,
		$plugin_id,
		$plugin_definition
	) {

		return new static(
			$configuration,
			$plugin_id,
			$plugin_definition,
			$container->get('current_user'),
			$container->get('config.factory')
		);
	}

	public function build()
	{
		$build = [];

		$config = $this->config_factory->get('pelicula.configuration');

		$build['information_block'] = [
			'#markup' => $this->t("Hola @user, tu pelicula favorito es: @movie", [
				'@user' => $this->current_user->getAccountName(),
				'@movie' => $config->get('pelicula')
			]),
			'#attached' => [
				'library' => [
					'pelicula/pelicula_css_js'
				]
			]
		];

		return $build;
	}
}