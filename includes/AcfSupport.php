<?php

namespace Feditor\AcfSupport;

add_action('feditor_fields', function ($post_id, $args_shortcode) {

    if(empty($args_shortcode['acf'])){
        return;
    }

    $field_groups = explode(',', $args_shortcode['acf']);
    $settings = [
        'field_groups' => $field_groups,
        'post_title' => false,
        'post_content' => false,
        'form' => false,
    ];

    if($post_id){
        $settings['post_id'] = $post_id;
    } else {
        $settings['new_post'] = true;
    }

    acf_form_head();
    acf_form( $settings );
}, 22, 2);