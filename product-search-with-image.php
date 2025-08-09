<?php 
/**
 * WooCommerce Product Search with Image
 * Description: Adds AJAX-powered WooCommerce product search that displays results with product images.
 * Version: 1.0
 * Author: MD Jahidul Islam
 * Author URI: https://mdjahidulislam.com
 */

 // Exit if accessed directly.
 if ( !defined( 'ABSPATH' ) ) {
 	exit;
 }

 // Enqueue scripts and styles
 add_action('wp_enqueue_scripts', function(){
    wp_enqueue_style( 'pswi-style', plugin_dir_url(__FILE__) . 'assets/style.css');
    wp_localize_script('pswi-script', plugin_dir_url(__FILE__) . 'assets/script.js');
    wp_localize_script('pswi-script', 'pswi_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
 });

 // Shortcode for search form
 add_shortcode('product_search_with_image', function(){
    ob_start();
    ?>
    <div class="pswi-search-box">
        <input type="text" id="pswi-search" placeholder="Search Products...">
        <div id="pswi-results"></div>
    </div>
    <?php
    return ob_get_clean();
 });