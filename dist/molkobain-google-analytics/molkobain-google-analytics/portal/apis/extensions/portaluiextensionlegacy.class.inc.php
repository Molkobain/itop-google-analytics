<?php
/**
 * Copyright (c) 2015 - 2020 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\GoogleAnalytics\Portal\Extension;

use AbstractPortalUIExtension;
use Molkobain\iTop\Extension\GoogleAnalytics\Common\Helper\ConfigHelper;
use Silex\Application;

// Protection for iTop 2.3- and iTop 2.7+
if(class_exists('\AbstractPortalUIExtension') && version_compare(ITOP_VERSION, '2.7', '<') && (ITOP_VERSION !== 'develop'))
{
	/**
	 * Class PortalUIExtensionLegacy
	 *
	 * @package Molkobain\iTop\Extension\GoogleAnalytics\Portal\Extension
	 */
	class PortalUIExtensionLegacy extends AbstractPortalUIExtension
	{
		/**
		 * @inheritdoc
		 * @throws \CoreException
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

			// Check if user should be tracked
			if(ConfigHelper::IsTrackedUser() === false)
			{
				return $aJSFiles;
			}

			$aJSFiles[] = 'https://www.googletagmanager.com/gtag/js?id=' . $sTrackingCode;

			return $aJSFiles;
		}

		/**
		 * @inheritdoc
		 * @throws \CoreException
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

			// Check if user should be tracked
			if(ConfigHelper::IsTrackedUser() === false)
			{
				return $sJSInline;
			}

			$sJSInline .= <<<EOF
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', '{$sTrackingCode}');
EOF;

			return $sJSInline;
		}
	}
}
