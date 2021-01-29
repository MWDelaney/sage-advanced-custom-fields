<?php
/**
 * Advanced Custom Fields drop-in functionality for Sage 9
 * Version: 1.0
 * Author: Michael W. Delaney
 */

// Hide ACF menu item in Production
if (defined('WP_ENV') && WP_ENV == 'production') {
    add_filter('acf/settings/show_admin', '__return_false');
}

if (function_exists('add_filter')) {

  /**
   * Set local json save path
   * @param  string $path unmodified local path for acf-json
   * @return string       our modified local path for acf-json
   */
    add_filter('acf/settings/save_json', function ($path) {

    // Set Sage9 friendly path at /theme-directory/resources/assets/acf-json

        if (is_dir(get_stylesheet_directory() . '/assets')) {
            // This is Sage 9
            $path = get_stylesheet_directory() . '/assets/acf-json';
        } elseif (is_dir(get_stylesheet_directory() . '/resources/assets')) {
            // This is old Sage 10
            $path = get_stylesheet_directory() . '/resources/assets/acf-json';
        } elseif (is_dir(get_stylesheet_directory() . '/resources')) {
            // This is Sage 10
            $path = get_stylesheet_directory() . '/resources/acf-json';
        } else {
            // This probably isn't Sage
            $path = get_stylesheet_directory() . '/acf-json';
        }

        // If the directory doesn't exist, create it.
        if (!is_dir($path)) {
            mkdir($path);
        }

        // Always return
        return $path;
    });


    /**
     * Set local json load path
     * @param  string $path unmodified local path for acf-json
     * @return string       our modified local path for acf-json
     */
    add_filter('acf/settings/load_json', function ($paths) {
        // Sage 9 path
        $paths[] = get_stylesheet_directory() . '/assets/acf-json';

        // old Sage 10 path
        $paths[] = get_stylesheet_directory() . '/resources/assets/acf-json';

        // Sage 10 path
        $paths[] = get_stylesheet_directory() . '/resources/acf-json';

        // Failsafe path
        $paths[] = get_stylesheet_directory() . '/acf-json';

        // return
        return $paths;
    });
}
