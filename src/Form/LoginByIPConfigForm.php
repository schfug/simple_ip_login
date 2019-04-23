<?php

namespace Drupal\simple_ip_login\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class LoginByIPConfigForm.
 */
class LoginByIPConfigForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'login_by_i_p_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['user'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('User'),
      '#description' => $this->t('The user account that will be used for login'),
      '#weight' => '0',
    ];
    $form['ip_address'] = [
      '#type' => 'string',
      '#title' => $this->t('IP Address (ipv4)'),
      '#description' => $this->t('The IP address that will be used for checking users permission'),
      '#weight' => '0',
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    foreach ($form_state->getValues() as $key => $value) {
      drupal_set_message($key . ': ' . $value);
    }

  }

}
