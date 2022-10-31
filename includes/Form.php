<?php 

namespace AApps\FrontEditor\Form;

const NONCE_FIELD = 'aapps_form_front_editor';

add_action('aapps_front_editor_fields', __NAMESPACE__ . '\\add_content_textarea');
add_action('aapps_front_editor_fields', __NAMESPACE__ . '\\add_input_submit', 50);
add_action('init', __NAMESPACE__ . '\\save_data');


function save_data(){
    if (empty( $_POST[NONCE_FIELD]) ){
        return;
    }

    if( ! wp_verify_nonce($_POST[NONCE_FIELD], 'update') ) {
        return;
    } 

    if( ! $user_id = get_current_user_id()){
        return;
    }

    $data = $_POST;

    $data['post_id'] = intval($data['post_id']);
    $save_data = [];
    if($post = get_post($data['post_id'])){
        $save_data['ID'] = $post->ID;
    }

    $save_data['post_author'] = $user_id;
    $save_data['post_content'] = $data['post_content'];
    // $save_data['post_title'] = wp_strip_all_tags($data['post_content']);
    $save_data['post_status'] = $data['publish'];

    $save_data = apply_filters( 'aapps_front_editor_post_save_data', $save_data, $data );

    $post_id = wp_insert_post( $save_data );

    do_action('aapps_front_editor_post_save_after', $post_id, $data);
    
    
    $url_redirect = site_url($data['_wp_http_referer']);
    $url_redirect = add_query_arg('id', $post_id, $url_redirect);
    wp_redirect($url_redirect);
    exit;
}

function add_input_submit(){
    printf('<input type="submit" id="submit" value="Сохранить" />');
}

function add_content_textarea(){

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
    if($post_id = get_post_id()){
        $content = get_post($post_id)->post_content;
    }
    $content = apply_filters('aapps_front_editor_content', $content, $post_id);

    wp_editor( $content, 'post_content', $args ); 

}

function render_form($args){
    ob_start();
    global $wp;

    $post_id = get_post_id();
    ?>

        <div class="aapps-front-editor">
            <form method="post" enctype="multipart/form-data">
                <?php 
                    do_action('aapps_front_editor_fields', $post_id, $args);
                    wp_nonce_field( 'update', NONCE_FIELD );
                ?>
                <input type="hidden" name="post_id" value="<?= $post_id ?>" />
            </form>
        </div>

    <?php return ob_get_clean();
}


function get_post_id(){
    $post_id = $_GET['id'] ?? null;
    $post_id = intval($post_id);
    if(empty($post_id)){
        return 0;
    }
    if( $post = get_post($post_id)){
        return $post->ID;
    }

    return 0;
}