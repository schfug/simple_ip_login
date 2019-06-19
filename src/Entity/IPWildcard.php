<?php

namespace Drupal\simple_ip_login\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the IP Wildcard entity.
 *
 * @ConfigEntityType(
 *   id = "ip_wildcard",
 *   label = @Translation("IP Wildcard"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\simple_ip_login\IPWildcardListBuilder",
 *     "form" = {
 *       "add" = "Drupal\simple_ip_login\Form\IPWildcardForm",
 *       "edit" = "Drupal\simple_ip_login\Form\IPWildcardForm",
 *       "delete" = "Drupal\simple_ip_login\Form\IPWildcardDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\simple_ip_login\IPWildcardHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "ip_wildcard",
 *   admin_permission = "administer simple ip login rules",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/config/ip_wildcard/{ip_wildcard}",
 *     "add-form" = "/admin/config/ip_wildcard/add",
 *     "edit-form" = "/admin/config/ip_wildcard/{ip_wildcard}/edit",
 *     "delete-form" = "/admin/config/ip_wildcard/{ip_wildcard}/delete",
 *     "collection" = "/admin/config/ip_wildcard"
 *   }
 * )
 */
class IPWildcard extends ConfigEntityBase implements IPWildcardInterface {

  /**
   * The IP Wildcard ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The IP Wildcard label.
   *
   * @var string
   */
  protected $label;


  /**
   * The IP Wildcard
   *
   * @var string
   */
  protected $ip_wildcard;

  /**
   * The User ID
   *
   * @var int
   */
  protected $user_id;

  /**
   * @param int $userId
   */
  public function setUserId(int $userId): void {
    $this->set('uid', (string) $userId);
    $this->save();
  }

  /**
   * Returns IP Wildcard
   *
   * @return string|null
   */
  public function getIPWildcard(): ?string {
    return $this->ip_wildcard;
  }

  /**
   * Returns user id
   *
   * @return int|null
   */
  public function getUserId(): int {
    return $this->get('uid') ?? 1;
  }
}
