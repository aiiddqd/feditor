<?php 


namespace EditorFeMe\FieldUrl;

add_action( 'plugin_loaded', function(){

    add_filter( 'editor_fe_md_config', __NAMESPACE__ . '\filter_editor_fe_md_config' );
    add_filter( 'the_content', __NAMESPACE__ . '\add_cta_to_content' );


    add_action('rest_api_init', function(){

        register_rest_field( 'post', 'editor_url_external', [
            'get_callback' => __NAMESPACE__ . '\get_editor_url_external',
            'update_callback' => __NAMESPACE__ . '\update_editor_url_external',
        ]);
    });
});


function add_cta_to_content($content) {

    if( ! is_singular('post')){
        return $content;
    }
    
    $post = get_post();

    if(has_block('lazyblock/url-cta', $post)){
        return $content;
    }
    
    $key = apply_filters( 'editor_url_external_meta_key', 'url_cta');
    if( ! $url = get_post_meta($post->ID, $key, true) ){
        return $content;
    }
    if('#' == $url){
        return $content;
    }
    if( ! empty($post->ID)){
        $url = site_url('/gourl/' . $post->ID);
    }
    
    ob_start();
    ?>
    <p>
        <a href="<?= $url ?>" target="_blank" rel="noopener noreferrer">Подробнее…</a>
    </p>
    <?php 

    return $content . ob_get_clean();
}

function get_editor_url_external($payload){
    if(empty($payload['id'])){
        return '';
    }

    if( ! $post = get_post($payload['id']) ){
        return '';
    }

    $key = apply_filters( 'editor_url_external_meta_key', 'url_cta');
    $value = get_post_meta($payload['id'], $key, true);
    return $value;
}

function update_editor_url_external($value, $post){
    $key = apply_filters( 'editor_url_external_meta_key', 'url_cta');

    update_post_meta($post->ID, $key, $value);

    return true;

}

function filter_editor_fe_md_config($config){

    $config['enableFieldUrl'] = true;

    return $config;
}

function set_state($key = false, $value = ''){
    static $state = [];

    $state['ddd'] = 1;

    if(empty($key)){
        return $state;
    }

    $state[$key] = $value;
    return $state;
}

function get_state($key = ''){
    $state = set_state();
    if(isset($state[$key])){
        return $state[$key];
    }
    return null;
}