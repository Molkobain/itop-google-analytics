<?php
/**
 * Copyright (c) 2015 - 2020 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\GoogleAnalytics\Common\Helper;

use User;
use UserRights;
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
    const DEFAULT_SETTING_IGNORED_PROFILES = array();
    const DEFAULT_SETTING_IGNORED_USERS = array();
    const DEFAULT_SETTING_IGNORED_IPS = array();

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
	    $sTrackingCode = (array_key_exists($sPortalID, $aTrackingCodes)) ? trim($aTrackingCodes[$sPortalID] ?? '') : null;

	    return (empty($sTrackingCode)) ? null : $sTrackingCode;
    }

	/**
	 * Returns true if $oUser should be tracked with GA, false otherwise.
	 * $oUser isn't tracked if its login or one of its profiles is in the "ignored_users" or "ignored_profiles" configuration parameters.
	 *
	 * @param null|\User $oUser
	 *
	 * @throws \CoreException
	 *
	 * @return bool
	 *
	 * @since 1.1.0
	 */
    public static function IsTrackedUser(User $oUser = null)
    {
    	if($oUser === null)
	    {
	    	$oUser = UserRights::GetUserObject();
	    }

	    // Check if among ignored users
	    $sLogin = $oUser->Get('login');
    	if(in_array($sLogin, static::GetSetting('ignored_users')))
	    {
	    	return false;
	    }

	    // Check if among ignored profiles
	    $aIgnoredProfiles = static::GetSetting('ignored_profiles');
    	$oProfileSet = $oUser->Get('profile_list');
    	while($oProfile = $oProfileSet->Fetch())
	    {
	    	$sProfile = $oProfile->Get('profile');
	    	if(in_array($sProfile, $aIgnoredProfiles))
		    {
		    	return false;
		    }
	    }

	    // Check if among ignored IPs
	    $aIgnoredIPs = static::GetSetting('ignored_ips');
    	$sIP = $_SERVER['REMOTE_ADDR'];
    	if(in_array($sIP, $aIgnoredIPs))
	    {
	    	return false;
	    }

    	return true;
    }
}
