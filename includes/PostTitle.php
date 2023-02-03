<?php 

namespace Feditor\PostTitle;

add_action('feditor_fields', __NAMESPACE__ . '\\render_input', 5);
add_filter('feditor_post_save_data', __NAMESPACE__ . '\\save_data', 10, 2);


function save_data($save_data, $data)
{

    $save_data['post_title'] = $data['post_title'] ?? '';

    return $save_data;

}

function render_input($post_id){
    $config = \Feditor\get_config();
    if(empty($config['title_enable'])){
        return;
    }
    if(empty($post_id)){
        $title = '';
    } else {
        $title = get_post($post_id)->post_title ?? '';
    }
    
    printf('<input type="text" name="post_title" class="form-control" value="%s" />', $title);

}

