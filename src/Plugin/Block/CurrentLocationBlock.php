<?php

namespace Drupal\current_location\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\current_location\Service\CurrentDateTime;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'CurrentTimeZoneBlock' block.
 *
 * @block(
 *   id = "current_location",
 *   admin_label = @Translation("Current Time Zone"),
 *   category = @Translation("Current Location"),
 * )
 */
class CurrentLocationBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The current date time.
   *
   * @var \Drupal\current_location\Service\CurrentDateTime
   */
  protected $currentDateTime;

  /**
   * Creates a CurrentTimeZoneBlock instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\current_location\Service\CurrentDateTime $current_date_time
   *   The current date time.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    CurrentDateTime $current_date_time
    ) {
    $this->currentDateTime = $current_date_time;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_location.service'),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    if ($account->isAuthenticated()) {
      return AccessResult::allowed()
        ->addCacheContexts([
          'user.roles:authenticated',
        ]);
    }
    return AccessResult::forbidden();
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#type' => 'markup',
      '#markup' => $this->currentDateTime->getCurrentDateTime(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

}
