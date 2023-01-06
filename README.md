# Current Location

## INTRODUCTION
- Displays current date and time for the timezone selected in Timezone settings.

## INSTALLATION
- Consult [Drupal Module](https://www.drupal.org/docs/extending-drupal/installing-modules) to see how to install and manage modules in Drupal 8.

### Composer
If you use Composer, you can install 'Current Location' module using below command:
```bash
composer require sivakarthik229/current_location
```

## CONFIGURATION
- If you go to `admin/config/timezone/settings` you will see a fairly simple interface.
- Add the Country, City name.
- Select Timezone.
- Click the "Save configuration" button and you are good to go.

## Block Configuration
- If you go to `admin/structure/block` then click on place the block.
- Search for `Current Time Zone` and select the respective region.
- Please make the machine name to `current_location` to get the fields from twig file.
- Click the "Save block" button.
- Arrange the block according to the required weight.
- Click the "Save blocks" and you are good to go.
