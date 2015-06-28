<?php
/**
 * Plugin Name: 51Blocks JSON Schema Generator
 * Plugin URI: https://www.51blocks.com/
 * Description: 51Blocks JSON Schema Generator
 * Version: 1.0
 * Author: 51blocks.com
 * Author URI: https://www.51blocks.com/
 * Text Domain: jsgen
 */

if (!defined('WPINC')){
    die();
}

require_once 'includes/custom-post-type.php';


function jsgen_enqueue_styles_js(){
    wp_enqueue_style('jsgen-styles', plugin_dir_url(__FILE__).'assets/css/styles.css');
    
    wp_enqueue_script('jsgen-main', plugin_dir_url(__FILE__).'assets/js/main.js', array(), '1.0', true);
}

add_action('admin_head', 'jsgen_enqueue_styles_js');


function jsgen_add_snippet() {
    
    global $post;


    $schemas = get_posts(array(
        'post_type' => 'json_schema', 
        'posts_per_page' => -1,
    ));
    
    if (!empty($schemas)) {
        foreach ($schemas as $schema) {
            $added_to = get_post_meta($schema->ID, 'genAddTo', true);
            $code = '<!-- JSON Schema Generator created by www.51blocks.com.--><script type="application/ld+json">'.get_post_meta($schema->ID, 'jsgen_code', true).'</script>';
            
            if ($added_to == 'all') {
                echo $code;
            } else {
                $gen_page_ids     = maybe_unserialize(get_post_meta( $schema->ID, 'gen_page_ids', true));
                echo (!empty($gen_page_ids) && in_array($post->ID, $gen_page_ids)) ? $code : '';
            }
        }
    }
    
    
}

add_action('wp_head', 'jsgen_add_snippet');


