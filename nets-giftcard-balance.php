<?php
/**
* Plugin Name: Nets giftcard saldo
* Plugin URI: http://benjamincreative.dk/
* Description: Insert, via shortcode, a balance form so customers can see the balance on their gift certificates.
* Version: 1.0
* Author: Martin Lyder
* Author URI: http://benjamincreative.dk
**/

wp_enqueue_script('jquery');

function form_creation(){
    global $content;
    ob_start();
    include ( plugin_dir_path( __FILE__ ) . 'content.php' );
    $output = ob_get_clean();
    return $output;


}
add_shortcode('giftcardbalance', 'form_creation');
?>