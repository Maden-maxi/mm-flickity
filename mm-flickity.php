<?php
/**
* @since 0.0.0
* @package MM_Flickity
*
* Plugin Name: Maden-maxi Flickity carousel
* Plugin URI:  https://developer.wordpress.org/plugins/the-basics/
* Description: Flickity slider thanks for metafizzy
* Version:     0.0.0
* Author:      Denys Dnishchneko
* Author URI:  https://developer.wordpress.org/
* License:     GPL2
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: mm-flickity
* Domain Path: /languages
*
* Maden-maxi Flickity carousel is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 2 of the License, or
* any later version.
*
* Maden-maxi Flickity carousel is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Maden-maxi Flickity carousel. If not, see  https://www.gnu.org/licenses/gpl-2.0.html.
*/

if( ! defined('WPINC') ) {
    die('Forbidden');
}

/**
 * Class MM_Flickity
 */
class MM_Flickity {

    /**
     * Instance of class
     *
     * @var null
     */
    public static $instance = null;

    /**
     * Get instance only once. Singleton Pattern
     *
     * @return null
     */
    public static function getInstance() {
        if( null === self::$instance ){
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * MM_Flickity constructor.
     */
    function __construct() {
        require_once('includes/mm-slider-options.php');
        require_once('admin/class-mm-flickity-metabox.php');
        require_once('public/class-mm-flickity-shortcode.php');
        require_once('public/widgets/class-mm-flickity-widget.php');
    }
}

MM_Flickity::getInstance();