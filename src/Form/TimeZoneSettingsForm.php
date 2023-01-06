<?php

namespace Drupal\current_location\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a setting UI for Time Zone.
 *
 * @package \Drupal\current_location\Form
 */
class TimeZoneSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'current_location.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'current_location_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);

    $config = $this->config('current_location.settings');
    $form['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#default_value' => $config->get('country'),
      '#required' => TRUE,
    ];
    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#default_value' => $config->get('city'),
      '#required' => TRUE,
    ];

    $time_zones = $this->buildTimeZones();
    $form['timezone'] = [
      '#title' => $this->t('Timezone'),
      '#type' => 'select',
      '#default_value' => $config->get('timezone'),
      '#options' => $time_zones,
      '#required' => TRUE,
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $country = $form_state->getValue('country');
    $city = $form_state->getValue('city');
    $timezone = $form_state->getValue('timezone');
    $this->config('current_location.settings')
      ->set('country', $country)
      ->set('city', $city)
      ->set('timezone', $timezone)
      ->save();
    parent::submitForm($form, $form_state);
  }

  /**
   * Build Timezones.
   */
  public function buildTimeZones(): array {
    $time_zones = [
      'America/Chicago' => 'America/Chicago',
      'America/New_York' => 'America/New_York',
      'Asia/Tokyo' => 'Asia/Tokyo',
      'Asia/Dubai' => 'Asia/Dubai',
      'Asia/Kolkata' => 'Asia/Kolkata',
      'Europe/Amsterdam' => 'Europe/Amsterdam',
      'Europe/Oslo' => 'Europe/Oslo',
      'Europe/London' => 'Europe/London',
    ];

    $grouped_zones = [];
    foreach ($time_zones as $key => $value) {
      $new_value = str_replace('_', ' ', $value);
      $split = explode('/', $new_value);
      $city = array_pop($split);
      $region = array_shift($split);
      if (!empty($region)) {
        $grouped_zones[$region][$key] = empty($split) ? $city : $city . ' (' . implode('/', $split) . ')';
      }
      else {
        $grouped_zones[$key] = $value;
      }
    }

    foreach ($grouped_zones as $key => $value) {
      if (is_array($grouped_zones[$key])) {
        asort($grouped_zones[$key]);
      }
    }

    return $grouped_zones;
  }

}
