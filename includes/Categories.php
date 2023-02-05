<?php 

namespace Feditor\Categories {

    add_action('feditor_fields', __NAMESPACE__ . '\\view', 15);
    add_filter('feditor_post_save_data', __NAMESPACE__ . '\\save', 10, 2);


    function view($post_id){

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

        if(empty($data['category'])){
            return $save_data;
        }

        $save_data['post_category'] = [intval($data['category'])];
        
        return $save_data;
    }

}