<?php

namespace Drupal\estatus_derechos\Form;

use Drupal\Core\Form\ConfigFormBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Form\FormStateInterface;
use \Drupal\Core\Url;

/**
 * Defines a form that configures forms module settings.
 */
class ModuleConfigurationForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'estatus_derechos_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'estatus_derechos.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) {

  global $base_url;

    $config = \Drupal::service('config.factory')->getEditable('estatus_derechos.settings');
    $form['plazo_derechos_autor'] = array(
      '#type' => 'number',
      '#title' => $this->t('Plazo de derechos de autor'),
      '#default_value' => $config->get('plazo_derechos_autor'),
    );

    $form['vida_maxima'] = array(
      '#type' => 'number',
      '#title' => $this->t('Vida máxima estimada del autor'),
      '#default_value' => $config->get('vida_maxima'),
    );

    $form['actividad_significativa'] = array(
      '#type' => 'number',
      '#title' => $this->t('Edad mínima de actividad significativa'),
      '#default_value' => $config->get('actividad_significativa'),
    );


    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::service('config.factory')->getEditable('estatus_derechos.settings');
    $values = $form_state->getValues();

    $config->set('plazo_derechos_autor', $values['plazo_derechos_autor'])
           ->save();
    $config->set('vida_maxima', $values['vida_maxima'])
           ->save();
    $config->set('actividad_significativa', $values['actividad_significativa'])
           ->save();

    $url = Url::fromRoute('estatus_derechos.content');
    $form_state->setRedirectUrl($url);

    parent::submitForm($form, $form_state);
  }
}
