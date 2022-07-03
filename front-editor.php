<?php
/*
* Plugin Name: AApps - Front Editor
* Description: Front editor for WP - shortcode [aapps-front-editor]
* Author: uptimizt
* Version: 0.3
*/

require_once __DIR__ . '/includes/Form.php';
require_once __DIR__ . '/includes/PostTitle.php';


use AApps\FrontEditor\Form;

use function AApps\FrontEditor\Form\render_form;

add_shortcode('aapps-front-editor', function () {
    $args = [];
    return render_form($args);
});


function aa_fe_get_config(){
    $config = [
        'base_css' => true,
        'title_enable' => true,
    ];

    return apply_filters( 'aa_fronteditor_config', $config );
}


add_action( 'wp_enqueue_scripts', function(){
    $config = aa_fe_get_config();
    if(empty($config['base_css'])){
        return;
    }

    if( ! is_singular()){
        return;
    }
    $path = '/static/styles/base.css';
    $file_url = plugins_url($path, __FILE__);
    $file_path = __DIR__ . $path;
    $file_version = filemtime($file_path);
    wp_enqueue_style( 'aa-front-editor-style', $file_url, [], $file_version );

  } );