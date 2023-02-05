<?php 

namespace Feditor\Categories {

    add_action('feditor_fields', __NAMESPACE__ . '\\view', 15);
    add_filter('feditor_post_save_data', __NAMESPACE__ . '\\save', 10, 2);

    add_action('admin_init', __NAMESPACE__ . '\\add_settings', 22);



    function view($post_id){

        if(is_disable()){
            return;
        }

        $category_selected = get_option('default_category');

        if($save_categories = get_the_category($post_id)){
            $category_selected = $save_categories[0]->term_id;
            // var_dump($save_categories);
        }

        $args = [
            'hierarchical' => true,
            'selected' => $category_selected,
            'hide_if_empty' => false,
            'class' => 'form-control',
            'name' => 'category',
        ];

        wp_dropdown_categories($args);
    }

    function save($save_data, $data){

        if(is_disable()){
            return $save_data;
        }

        if(empty($data['category'])){
            return $save_data;
        }

        $save_data['post_category'] = [intval($data['category'])];
        
        return $save_data;
    }

    function is_disable()
    {
        return \Feditor\Config\get_config()['categories_disable'] ?? false;
    }
    function add_settings(){

        add_settings_field(
            'categories_disable',
            $title = 'Categories Disable',
            $callback = function () {
                $value = \Feditor\Config\get_config()['categories_disable'] ?? null;
                $name = sprintf('%s[%s]', \Feditor\Config\OPTION_KEY, 'categories_disable');
                printf('<input type="checkbox" name="%s" value="1" %s />', $name, checked(1, $value, false));

                return 1;
            },
			\Feditor\Config\OPTION_PAGE
		);
    }

}