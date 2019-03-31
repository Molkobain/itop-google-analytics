<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\GoogleAnalytics\Console\Extension;

use iPageUIExtension;
use iTopWebPage;
use Molkobain\iTop\Extension\GoogleAnalytics\Common\Helper\ConfigHelper;

/**
 * Class PageUIExtension
 *
 * @package Molkobain\iTop\Extension\GoogleAnalytics\Console\Extension
 */
class PageUIExtension implements iPageUIExtension
{
	/**
	 * @inheritdoc
	 * @throws \CoreException
	 */
	public function GetNorthPaneHtml(iTopWebPage $oPage)
	{
		// Check if enabled
		if(ConfigHelper::IsEnabled() === false)
		{
			return;
		}

		// Check if tracking code defined
		$sTrackingCode = ConfigHelper::GetPortalTrackingCode('backoffice');
		if(empty($sTrackingCode))
		{
			return;
		}

		// Check if user should be tracked
		if(ConfigHelper::IsTrackedUser() === false)
		{
			return;
		}

		$oPage->add_linked_script('https://www.googletagmanager.com/gtag/js?id=' . $sTrackingCode);
		$oPage->add_ready_script(<<<EOF
// Molkobain Google Analytics
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', '{$sTrackingCode}');
EOF
		);
	}

	/**
	 * @inheritdoc
	 */
	public function GetSouthPaneHtml(iTopWebPage $oPage)
	{
		// Nothing to do
	}

	/**
	 * @inheritdoc
	 */
	public function GetBannerHtml(iTopWebPage $oPage)
	{
		// Nothing to do
	}
}
