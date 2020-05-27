<?php

namespace Drupal\pelicula\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class ConfigurationForm extends ConfigFormBase
{

	/**
	 * {@inheritdoc}
	 */
	public function getFormId()
	{
		return 'pelicula.configuration_form';
	}

	/**
	 * {@inheritdoc}
	 */
	public function buildForm(array $form, FormStateInterface $form_state)
	{
		$form = parent::buildForm($form, $form_state);

		$config = $this->config('pelicula.configuration');

		$form['pelicula'] = [
			'#type' => 'textfield',
			'#title' => $this->t('Ingrese su pelicula favorita'),
			'#default_value' => $config->get('pelicula'),
			'#size' => 64,
			'#maxlength' => 64,
		];

		return $form;
	}

	/**
	 * {@inheritdoc}
	 */
	public function submitForm(array &$form, FormStateInterface $form_state)
	{
		$this->config('pelicula.configuration')
			->set('pelicula', $form_state->getValue('pelicula'))
			->save();

		return parent::submitForm($form, $form_state);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getEditableConfigNames()
	{
		return [
			'pelicula.configuration'
		];
	}
}
