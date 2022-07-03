<?php
/*
* Plugin Name: AApps - Front Editor
* Description: Front editor for WP - shortcode [aapps-front-editor]
* Author: uptimizt
* Version: 0.2
*/

require_once __DIR__ . '/includes/Form.php';


use AApps\FrontEditor\Form;

use function AApps\FrontEditor\Form\render_form;

add_shortcode('aapps-front-editor', function () {
    $args = [];
    return render_form($args);
});


function aa_fe_get_config(){
    $config = [];

    return apply_filters( 'aa_fronteditor_config', $config );
}