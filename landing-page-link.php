<?php

/**
 * Plugin Name:       Landing Page Tracking Link
 * Description:       Meta input for landing pages to provide custom tracking link and update page URL accordingly
 * Version:           1.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            WC Bessinger
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       lp-tracking
 */

defined('ABSPATH') || exit();

add_action('plugins_loaded', function () {

    // constants
    define('LP_TRACKING_PATH', plugin_dir_path(__FILE__));
    define('LP_TRACKING_URL', plugin_dir_url(__FILE__));

    // page backend metabox
    include_once LP_TRACKING_PATH . 'functions/metabox.php';

    // save page tracking data
    include_once LP_TRACKING_PATH . 'functions/save-post.php';

    // runs to update old tracking data (as originally implemented using ACF)
    if (class_exists('ACF')) :
        include_once LP_TRACKING_PATH . 'functions/old-data-update.php';
    endif;

    // function to replace front-end links
    include_once LP_TRACKING_PATH . 'functions/frontend-link-replace.php';
});
