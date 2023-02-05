<?php

namespace Feditor\PostTitle {

    add_action('feditor_fields', __NAMESPACE__ . '\\view');
    add_filter('feditor_post_save_data', __NAMESPACE__ . '\\save', 10, 2);
    add_action('admin_init', __NAMESPACE__ . '\\add_settings');

    function view($post_id)
    {
        $config = \Feditor\Config\get_config();
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

    function add_settings(){

        add_settings_field(
            'title_enable',
            $title = 'Title Enable',
            $callback = function () {
                $value = \Feditor\Config\get_config()['title_enable'] ?? null;
                $name = sprintf('%s[%s]', \Feditor\Config\OPTION_KEY, 'title_enable');
                printf('<input type="checkbox" name="%s" value="1" %s />', $name, checked(1, $value, false));

                return 1;
            },
			\Feditor\Config\OPTION_PAGE
		);
    }
}