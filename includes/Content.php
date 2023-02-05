<?php

namespace Feditor\Content {

    add_action('feditor_fields', __NAMESPACE__ . '\\view', 20);
    add_filter('feditor_post_save_data', __NAMESPACE__ . '\\save', 10, 2);


    function view($post_id)
    {
        $args = [
            'wpautop' => true,
            'media_buttons' => false,
            'textarea_name' => 'post_content',
            'textarea_rows' => 10,
            'tabindex' => 1,
            'teeny' => true,
            'tinymce' => false,
            'quicktags' => false,
            'drag_drop_upload' => false
        ];

        $content = '';
        if ($post_id) {
            $content = get_post($post_id)->post_content;
        }
        $content = apply_filters('feditor_content', $content, $post_id);
        $args = apply_filters('feditor_wp_editor_args', $args, $post_id);

        wp_editor($content, 'post_content', $args);

    }

    function save($save_data, $data)
    {

        $save_data['post_content'] = $data['post_content'];

        return $save_data;
    }
}