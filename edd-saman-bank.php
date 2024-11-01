<?php
/*
Plugin Name: WpYar EDD Saman Bank Gateway
Plugin URI: https://wordpress.org/plugins/wpyar-edd-saman-bank-gateway/
Description: Standard Add payment gateway Saman Bank for edd.
Version: 1.1
Author: <a href="https://wp-yar.ir" target="_blank">Iranian goods store WordPress - wp-yar.ir</a> | <a href="https://habibi-dev.com" target="_blank">Amir Hosein Habibi</a>
Tags: easy digital downloads,EDD gateways,persian banks,saman,bank saman,سامان,بانک سامان,درگاه بانک سامان, درگاه بانک سامان برای edd
Tested up to: 4.7.2
Text Domain: edd-saman-bank
Domain Path: /languages
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if (!defined('ABSPATH')) exit; // No direct access allowed
define('edd_saman_bank_path', __FILE__);
define('edd_saman_bank_ver', '1.1');

// ~~~~~~ START ADD LANG ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
include(plugin_dir_path(edd_saman_bank_path) . '/inc/core/lang.php');
// ~~~~~~ END ADD LANG ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

// ~~~~~~ START ADD GATEWAY SETTING ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
include(plugin_dir_path(edd_saman_bank_path) . '/inc/core/add-gateway-settings.php');
// ~~~~~~ END ADD GATEWAY SETTING ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++