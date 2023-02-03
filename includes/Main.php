<?php 

namespace Feditor\Main;


add_action('feditor_fields', __NAMESPACE__ . '\\add_content_textarea', 20);
add_action('feditor_fields', __NAMESPACE__ . '\\add_status_options', 45);
add_action('feditor_fields', __NAMESPACE__ . '\\add_input_submit', 50);
add_filter('feditor_post_save_data', __NAMESPACE__ . '\\save_data', 10, 2);


function save_data($save_data, $data){

    $save_data['post_content'] = $data['post_content'];
    if($data['post_status'] == 'publish'){
        $save_data['post_status'] = 'publish';    
    } else {
        $save_data['post_status'] = 'draft';    
    }

    return $save_data;
}

function add_status_options($post_id){
    if(empty($post_id)){
        $status = 'draft';
    } else {
        $status = get_post($post_id)->post_status ?? 'draft';
    }
?>
    <div>
      <input type="radio" id="post-draft" name="post_status" value="draft" <?php checked( 'draft', $status ) ?>>
      <label for="post-draft">Draft</label>
    </div>
    <div>
      <input type="radio" id="post-publish" name="post_status" value="publish" <?php checked( 'publish', $status ) ?>>
      <label for="post-publish">Public</label>
    </div>

<?php
}


function add_input_submit(){
    printf('<input type="submit" id="submit" value="Save" />');
}

function add_content_textarea($post_id){

    $args = [
        'wpautop'       => true,
        'media_buttons' => false,
        'textarea_name' => 'post_content',
        'textarea_rows' => 10,
        'tabindex'      => 1,
        'teeny'         => true,
        'tinymce'         => false,
        'quicktags'     => false,
        'drag_drop_upload' => false
    ];

    $content = '';
    if($post_id){
        $content = get_post($post_id)->post_content;
    }
    $content = apply_filters('feditor_content', $content, $post_id);
    $args = apply_filters('feditor_wp_editor_args', $args, $post_id);

    wp_editor( $content, 'post_content', $args );

}

