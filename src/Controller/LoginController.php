<?php

namespace Drupal\simple_ip_login\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\simple_ip_login\Entity\IPWildcard;
use Drupal\user\Entity\User;

/**
 * Class LoginController.
 */
class LoginController extends ControllerBase {

  /**
   * Logs user in or show an error message
   *
   * @return mixed
   *   Return Hello string.
   */
  public function iplogin() {

    if ($userID = self::isWildcartUser()) {
      user_login_finalize(User::load($userID));
      \Drupal::service('session')->set('autologin', TRUE);

      return $this->redirect('<front>');
    }

    return [
      'failed' =>
        [
          '#markup' => $this->t('Login failed...') . '<br />',
        ],
      'link' => Link::createFromRoute('Back to login page', 'user.login')
        ->toRenderable(),
    ];
  }

  /**
   * Checks if user has a ip login
   * @return bool
   */
  public static function isWildcartUser() {
    $ipWildcards = IPWildcard::loadMultiple();

    foreach ($ipWildcards as $ipWildcard) {
      if ((bool) preg_match($ipWildcard->getIPWildcard(), \Drupal::request()
        ->getClientIp())) {
        return $ipWildcard->getUserId();
      }
    }
    return FALSE;
  }

}