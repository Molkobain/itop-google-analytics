<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\GoogleAnalytics\Portal\Extension;

use AbstractPortalUIExtension;
use Silex\Application;
use Molkobain\iTop\Extension\GoogleAnalytics\Common\Helper\ConfigHelper;

/**
 * Class PortalUIExtension
 *
 * @package Molkobain\iTop\Extension\GoogleAnalytics\Portal\Extension
 */
class PortalUIExtension extends AbstractPortalUIExtension
{
	/**
	 * @inheritdoc
	 */
	public function GetJSFiles(Application $oApp)
	{
		$aJSFiles = array();

		// Check if enabled
		if(ConfigHelper::IsEnabled() === false)
		{
			return $aJSFiles;
		}

		// Check if tracking code defined
		$sTrackingCode = ConfigHelper::GetPortalTrackingCode(PORTAL_ID);
		if(empty($sTrackingCode))
		{
			return $aJSFiles;
		}

		$aJSFiles[] = 'https://www.googletagmanager.com/gtag/js?id=' . $sTrackingCode;

		return $aJSFiles;
	}

	/**
	 * @inheritdoc
	 */
	public function GetJSInline(Application $oApp)
	{
		$sJSInline = '';

		// Check if enabled
		if(ConfigHelper::IsEnabled() === false)
		{
			return $sJSInline;
		}

		// Check if tracking code defined
		$sTrackingCode = ConfigHelper::GetPortalTrackingCode(PORTAL_ID);
		if(empty($sTrackingCode))
		{
			return $sJSInline;
		}

		$sJSInline .= <<<EOF
// Molkobain Google Analytics
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', '{$sTrackingCode}');
EOF
		;

		return $sJSInline;
	}
}
