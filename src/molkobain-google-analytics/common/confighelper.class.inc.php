<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\GoogleAnalytics\Common\Helper;

use Molkobain\iTop\Extension\HandyFramework\Common\Helper\ConfigHelper as BaseConfighelper;

/**
 * Class ConfigHelper
 *
 * @package Molkobain\iTop\Extension\GoogleAnalytics\Common\Helper
 */
class ConfigHelper extends BaseConfighelper
{
    const MODULE_NAME = 'molkobain-google-analytics';
    const SETTING_CONST_FQCN = 'Molkobain\\iTop\\Extension\\GoogleAnalytics\\Common\\Helper\\ConfigHelper';

    const DEFAULT_SETTING_TRACKING_CODES = array();

	/**
	 * Returns true if $sPortalID has a tracking code defined, false otherwise.
	 *
	 * @param string $sPortalID
	 *
	 * @return bool
	 */
    public static function HasPortalTrackingCode($sPortalID)
    {
    	return !empty(static::GetPortalTrackingCode($sPortalID));
    }

	/**
	 * Returns the tracking for $sPortalID if something is defined, null otherwise (eg. For '', null, false)
	 *
	 * @param string $sPortalID The portal ID ('backoffice' for the admin console, 'itop-portal' for the default end-user portal, 'XXX' for other portals)
	 *
	 * @return null|string
	 */
    public static function GetPortalTrackingCode($sPortalID)
    {
	    $aTrackingCodes = static::GetSetting('tracking_codes');
	    $sTrackingCode = (array_key_exists($sPortalID, $aTrackingCodes)) ? trim($aTrackingCodes[$sPortalID]) : null;

	    return (empty($sTrackingCode)) ? null : $sTrackingCode;
    }
}
