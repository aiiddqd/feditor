<?php 

namespace Feditor\Categories {

    add_action('feditor_fields', __NAMESPACE__ . '\\view', 11);
    add_action('feditor_post_save_data_after', __NAMESPACE__ . '\\save', 10, 2);


    function view($post_id){
        echo 1;
    }

    function save($save_data, $data){
        
        
        return $save_data;
    }

}