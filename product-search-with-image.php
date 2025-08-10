<?php
/*
Plugin Name: WooCommerce Product Search with Image
Description: Adds AJAX-powered WooCommerce product search that displays results with product images.
Version: 1.0
Author: Your Name
*/

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Enqueue scripts and styles
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style('pswi-style', plugin_dir_url(__FILE__) . 'assets/style.css');
    wp_enqueue_script('pswi-script', plugin_dir_url(__FILE__) . 'assets/script.js', array('jquery'), false, true);
    wp_localize_script('pswi-script', 'pswi_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
});

// Shortcode for search box
add_shortcode('product_search_with_image', function() {
    ob_start();
    ?>
    <div class="pswi-search-box">
        <input type="text" id="pswi-search" placeholder="Search products...">
        <div id="pswi-results"></div>
    </div>
    <?php
    return ob_get_clean();
});

// AJAX handler for search
add_action('wp_ajax_pswi_search', 'pswi_search_callback');
add_action('wp_ajax_nopriv_pswi_search', 'pswi_search_callback');

function pswi_search_callback() {
    $keyword = sanitize_text_field($_POST['keyword']);
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 10,
        's' => $keyword
    );
    $query = new WP_Query($args);

    $results = array();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            global $product;
            $results[] = array(
                'title' => get_the_title(),
                'url'   => get_permalink(),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'),
                'price' => $product->get_price_html()
            );
        }
    }
    wp_reset_postdata();

    wp_send_json($results);
}
