<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	mod_toolbar
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

if (!empty($title)) {
	echo $title;
}
// Echo the toolbar.
echo $toolbar;
