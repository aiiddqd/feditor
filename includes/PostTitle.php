<?php

namespace Feditor\PostTitle {

    add_action('feditor_fields', __NAMESPACE__ . '\\view');
    add_filter('feditor_post_save_data', __NAMESPACE__ . '\\save', 10, 2);

    function view($post_id)
    {
        $config = \Feditor\get_config();
        if (empty($config['title_enable'])) {
            return;
        }
        if (empty($post_id)) {
            $title = '';
        } else {
            $title = get_post($post_id)->post_title ?? '';
        }

        printf('<input type="text" name="post_title" placeholder="New post title here..." class="form-control" value="%s" />', $title);

    }

    function save($save_data, $data)
    {

        $save_data['post_title'] = $data['post_title'] ?? '';

        return $save_data;

    }
}