<?php

namespace Drupal\simple_ip_login\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;

/**
 * Class IPWildcardForm.
 */
class IPWildcardForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    /**
     * @var $ip_wildcard \Drupal\simple_ip_login\Entity\IPWildcard
     */
    $ip_wildcard = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $ip_wildcard->label(),
      '#description' => $this->t('Label for the login rule.'),
      '#required' => TRUE,
    ];

    $form['uid'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('User'),
      '#description' => $this->t('The account that will be logged in'),
      '#weight' => '0',
      '#target_type' => 'user',
      '#default_value' => User::load($ip_wildcard->getUserId()),
    ];

    $form['ip_wildcard'] = [
      '#type' => 'textfield',
      '#title' => $this->t('IP Wildcard (regex pattern)'),
      '#maxlength' => 255,
      '#default_value' => $ip_wildcard->getIPWildcard(),
      '#description' => $this->t('Enter a <a href=":href">regular expression</a>', [':href' => 'https://www.php.net/manual/de/reference.pcre.pattern.syntax.php']),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $ip_wildcard->id(),
      '#machine_name' => [
        'exists' => '\Drupal\simple_ip_login\Entity\IPWildcard::load',
      ],
      '#disabled' => !$ip_wildcard->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $ip_wildcard = $this->entity;
    $status = $ip_wildcard->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label IP Wildcard.', [
          '%label' => $ip_wildcard->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label IP Wildcard.', [
          '%label' => $ip_wildcard->label(),
        ]));
    }
    $form_state->setRedirectUrl($ip_wildcard->toUrl('collection'));
  }

}
