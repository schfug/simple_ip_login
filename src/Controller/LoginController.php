<?php

namespace Drupal\simple_ip_login\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\simple_ip_login\Entity\IPWildcard;
use Drupal\user\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class LoginController.
 */
class LoginController extends ControllerBase {

  /**
   * @var \Symfony\Component\HttpFoundation\Session\Session
   */
  private $session;

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *
   * @return \Drupal\simple_ip_login\Controller\LoginController
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('session')
    );
  }


  /**
   * LoginController constructor.
   *
   * @param \Symfony\Component\HttpFoundation\Session\Session $session
   */
  public function __construct(Session $session) {
    $this->session = $session;
  }

  /**
   * Logs user in or show an error message
   *
   * @return mixed
   *   Return Hello string.
   */
  public function iplogin() {

    if ($userID = self::isWildcardUser()) {
      user_login_finalize(User::load($userID));
      $this->session->set('autologin', TRUE);

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
   * @return bool|int
   */
  public static function isWildcardUser() {
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