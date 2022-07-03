<?php
/*
* Plugin Name: AApps - Front Editor
* Description: Front editor for WP
* Author: uptimizt
* Version: 0.1
*/

require_once __DIR__ . '/includes/Meta.php';
require_once __DIR__ . '/includes/FieldUrl.php';

add_shortcode('fetest', function () {

    ob_start(); ?>

    <div class="feapp">loading...</div>

<?php return ob_get_clean();
});


add_action('wp_enqueue_scripts', function () {


    if (!is_singular()) {
        return;
    }
    
    $post = get_post();

    if (!has_shortcode($post->post_content, 'fetest')) {
        return;
    }

    $css_files = [
        'bundle' => '/frontend/public/build/bundle.css',
        // 'shared' => '/frontend/public/build/shared.css'
    ];
    foreach ($css_files as $key => $file_path) {
        $ver = filemtime(__DIR__ . $file_path);
        wp_enqueue_style('fedev-' . $key, $src = plugins_url($file_path, __FILE__), $deps = [], $ver);
    
    }

    $app_js_path = '/frontend/public/build/bundle.js';
    wp_enqueue_script('editorFeMd', plugins_url($app_js_path, __FILE__), [], filemtime(__DIR__ . $app_js_path), true);
    $config_app = [
        'root' => esc_url_raw( rest_url() ),
        'nonce' => wp_create_nonce( 'wp_rest' ),
        'pageUrl' => get_permalink($post),
        'toolbarEnable' => false,
        'fileCoverEnable' => false,
    ];

    $config_app = apply_filters( 'editor_fe_md_config', $config_app);

    wp_localize_script( 'editorFeMd', 'editorFeMdConfig', $config_app);
});

