<?php 

namespace EditorFeMe;

use WP_Post;

class Meta {

    public static function init(){

        add_action('rest_api_init', function(){

            register_rest_field( 'post', 'md_editor_enable', [
                'get_callback' => [__CLASS__, 'get_md_editor_enable'],
                'update_callback' => [__CLASS__, 'update_md_editor_enable'],
            ]);
            register_rest_field( 'post', 'md_editor_content', [
                'get_callback' => [__CLASS__, 'get_md_editor_content'],
                'update_callback' => [__CLASS__, 'update_md_editor_content'],
            ]);
        });
    }

    public static function get_md_editor_enable($payload){
        if(empty($payload['id'])){
            return false;
        }

        $enable = intval(get_post_meta($payload['id'], 'md_editor_enable', true));
        if( $enable ){
            return true;
        }         
        
        return false;
    }

    public static function update_md_editor_enable($payload, $post){
        if(empty($payload)){
            delete_post_meta($post->ID, 'md_editor_enable');
        } else {
            update_post_meta($post->ID, 'md_editor_enable', 1);
        }

        return true;
    }

    public static function get_md_editor_content($payload){

        if(empty($payload['id'])){
            return '';
        }

        if( ! $post = get_post($payload['id']) ){
            return '';
        }

        return $post->post_content_filtered;
    }

    public static function update_md_editor_content($payload, $post){

        $post_update =[
            'ID' => $post->ID,
            'post_content_filtered' => $payload,
        ];

        if(wp_update_post($post_update)){
            return true;
        } 
        
        return false;

    }

}

add_action('plugins_loaded', [__NAMESPACE__ . '\Meta', 'init']);