# iTop extension: molkobain-google-analytics
* [Description](#description)
* [Compatibility](#compatibility)
* [Downloads](#downloads)
* [Installation](#installation)
* [Configuration](#configuration)

## Description
Enable Google Analytics reporting on your iTop instance within seconds! Just put your tracking code in the configuration file and your are good to go. Reporting can be enabled on both the admin. console and the end-user portal.

Features:
* Works on both the admin. console and end-user portal.
* Different tracking codes can be set to the admin. console and end-user portal.
* Supports multi end-user portal setups, just add portal IDs in the configuration file.

## Compatibility
Compatible with iTop 2.4+

## Downloads
Stable releases can be found on the [releases page](https://github.com/Molkobain/itop-google-analytics/releases).

Downloading it directly from the *Clone or download* will get you the version under development which might be unstable.

## Installation
* Unzip the extension
* Copy the ``dist/molkobain-google-analytics`` folder under ``<PATH_TO_ITOP>/extensions`` folder of your iTop
* Run iTop setup & select extension *Google Analytics: Tracking code integration*

*Your folders should look like this*

![Extensions folder](https://raw.githubusercontent.com/Molkobain/itop-google-analytics/develop/docs/mga-install.png)

## Configuration
Get tracking codes from Google Analytics' website and put them in the tracking_codes parameter (see below).

### Parameters
The extension has only 2 configuration parameters:
  * `enabled`: Enable or disable extension. Possible values are `true`|`false`, default is `true`.
  * `tracking_codes`: Tracking code for each iTop "portal". `backoffice` being the admin. console, `itop-portal` the standard end-user portal. You can add any other end-user portal instance you have by adding `'PORTAL_ID' => 'TRACKING_CODE',` to the list.

*Example:*
```
'molkobain-google-analytics' => array (
  'enabled' => true,
  'tracking_codes' => array (
    'backoffice' => 'FIRST_TRACKING_CODE',
    'itop-portal' => 'SECOND_TRACKING_CODE',
  ),
),
```


## Licensing
This extension is under [MIT license](https://en.wikipedia.org/wiki/MIT_License).
