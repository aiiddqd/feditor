<?php
/*
 * Plugin Name: @ Feditor
 * Description: Front editor for WP - shortcode [feditor]
 * Author: uptimizt
 * Version: 0.5
 */

namespace Feditor;

const NONCE_FIELD = 'feditor_nonce';

$files = glob(__DIR__ . '/includes/*.php');
foreach ($files as $file) {
    require_once $file;
}


add_action('init', __NAMESPACE__ . '\\save_data');


add_shortcode('feditor', function ($args = []) {
    $post_id = get_post_id();
    ob_start();
    ?>
    <div class="feditor">
        <form method="post" enctype="multipart/form-data">
            <?php
            do_action('feditor_fields', $post_id, $args);
            wp_nonce_field('update', NONCE_FIELD);
            ?>
            <input type="hidden" name="post_id" value="<?= $post_id ?>" />
        </form>
    </div>
    <?php return ob_get_clean();
});

function get_post_id()
{
    $post_id = $_GET['id'] ?? null;
    $post_id = intval($post_id);
    if (empty($post_id)) {
        return 0;
    }
    if ($post = get_post($post_id)) {
        return $post->ID;
    }

    return 0;
}


function save_data()
{
    if (empty($_POST[NONCE_FIELD])) {
        return;
    }

    if (!wp_verify_nonce($_POST[NONCE_FIELD], 'update')) {
        return;
    }

    if (!$user_id = get_current_user_id()) {
        return;
    }

    $data = $_POST;

    $data['post_id'] = intval($data['post_id']);
    $save_data = [];
    if ($post = get_post($data['post_id'])) {
        $save_data['ID'] = $post->ID;
    }

    $save_data['post_author'] = $user_id;
    $save_data = apply_filters('feditor_post_save_data', $save_data, $data);

    // var_dump($save_data);
    // exit;
    $post_id = wp_insert_post($save_data);

    do_action('feditor_post_save_data_after', $post_id, $data);

    $url_redirect = site_url($data['_wp_http_referer']);
    $url_redirect = add_query_arg('id', $post_id, $url_redirect);
    wp_redirect($url_redirect);
    exit;
}


add_action('wp_enqueue_scripts', function () {
    $config = \Feditor\Config\get_config();
    if (empty($config['base_css'])) {
        return;
    }

    if (!is_singular()) {
        return;
    }

    global $post;
    if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'feditor')) {
        $path = '/frontend/style.css';
        $file_url = plugins_url($path, __FILE__);
        $file_path = __DIR__ . $path;
        $file_version = filemtime($file_path);
        wp_enqueue_style('feditor-style', $file_url, [], $file_version);
    }
});