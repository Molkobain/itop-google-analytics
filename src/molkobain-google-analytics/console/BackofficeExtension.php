<?php
/**
 * Copyright (c) 2015 - 2020 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\GoogleAnalytics\Console\Extension;

use iBackofficeLinkedScriptsExtension;
use iBackofficeReadyScriptExtension;
use Molkobain\iTop\Extension\GoogleAnalytics\Common\Helper\ConfigHelper;
use utils;

// Protection for API breaking changes
if (interface_exists("iBackofficeLinkedScriptsExtension") && interface_exists("iBackofficeReadyScriptExtension")) {
	/**
	 * Class BackofficeExtension
	 *
	 * @package Molkobain\iTop\Extension\GoogleAnalytics\Console\Extension
	 * @since 1.5.0
	 */
	class BackofficeExtension implements iBackofficeLinkedScriptsExtension, iBackofficeReadyScriptExtension
	{
		/**
		 * @inheritDoc
		 */
		public function GetLinkedScriptsAbsUrls() : array
		{
			// Check if enabled
			if(ConfigHelper::IsEnabled() === false)
			{
				return [];
			}

			// Check if tracking code defined
			$sTrackingCode = ConfigHelper::GetPortalTrackingCode("backoffice");
			if(utils::IsNullOrEmptyString($sTrackingCode))
			{
				return [];
			}

			// Check if user should be tracked
			if(ConfigHelper::IsTrackedUser() === false)
			{
				return [];
			}

			return [
				"https://www.googletagmanager.com/gtag/js?id=$sTrackingCode",
			];
		}

		/**
		 * @inheritDoc
		 */
		public function GetReadyScript() : string
		{
			// Check if enabled
			if(ConfigHelper::IsEnabled() === false)
			{
				return "";
			}

			// Check if tracking code defined
			$sTrackingCode = ConfigHelper::GetPortalTrackingCode("backoffice");
			if(utils::IsNullOrEmptyString($sTrackingCode))
			{
				return "";
			}

			// Check if user should be tracked
			if(ConfigHelper::IsTrackedUser() === false)
			{
				return "";
			}

			return <<<JS
	// Molkobain Google Analytics
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', '{$sTrackingCode}');
JS;
		}
	}
}
