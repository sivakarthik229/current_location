<?php

namespace Drupal\current_location\Service;

use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Constructs a CurrentDateTime service.
 *
 * @package \Drupal\current_location\Service
 */
class CurrentDateTime {

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a CurrentDateTime service.
   */
  public function __construct(
    ConfigFactoryInterface $config_factory
    ) {
    $this->configFactory = $config_factory->get('current_location.settings');
  }

  /**
   * Build current date and time.
   */
  public function getCurrentDateTime() {
    $timezone = $this->configFactory->get('timezone');
    if (!empty($timezone)) {
      $date = new \DateTime('now', new \DateTimeZone($timezone));
      $time = $date->format('h:i a');
      $date = $date->format('l, j F Y');
      $format = [
        'time' => $time,
        'date' => $date,
      ];
      return $format;
    }
  }

}
