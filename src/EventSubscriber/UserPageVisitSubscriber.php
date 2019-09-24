<?php

namespace Drupal\simple_ip_login\EventSubscriber;

use Drupal\simple_ip_login\Controller\LoginController;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class UserPageVisitSubscriber.
 */
class UserPageVisitSubscriber implements EventSubscriberInterface {

  /**
   * @var \Symfony\Component\HttpFoundation\Session\SessionInterface
   */
  private $sessionService;

  /**
   * Constructs a new UserPageVisitSubscriber object.
   *
   * @param \Symfony\Component\HttpFoundation\Session\SessionInterface $sessionService
   */
  public function __construct(SessionInterface $sessionService) {
    $this->sessionService = $sessionService;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events['kernel.request'] = ['auto_logout'];

    return $events;
  }

  /**
   * This method is called whenever the kernel.request event is
   * dispatched.
   *
   * @param \Symfony\Component\EventDispatcher\Event $event
   *
   */
  public function auto_logout(Event $event): void {
    $isAutoLogin = (bool) $this->sessionService->get('autologin');
    if ($isAutoLogin && !LoginController::isWildcardUser()) {
      user_logout();
    }
  }

}