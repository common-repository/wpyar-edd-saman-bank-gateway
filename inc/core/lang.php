<?php
if (!defined('ABSPATH')) exit; // No direct access allowed

add_action('plugins_loaded', 'edd_saman_bank_textdomain');
function edd_saman_bank_textdomain()
{
    load_plugin_textdomain('edd-saman-bank', false, dirname(plugin_basename(edd_saman_bank_path)) . '/languages');
}