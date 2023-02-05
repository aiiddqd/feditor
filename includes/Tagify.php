<?php

namespace Feditor\Tagify {

    add_action('feditor_fields', __NAMESPACE__ . '\\view', 11);
    add_action('feditor_post_save_data_after', __NAMESPACE__ . '\\save', 10, 2);

    function view($post_id)
    {
        if ($post_id) {
            $tags = wp_get_post_tags($post_id);
            $tags_texts = [];
            foreach ($tags as $item) {
                $tags_texts[] = $item->name;
            }
            if ($tags_texts) {
                $tags_texts = implode(', ', $tags_texts);
            } else {
                $tags_texts = '';
            }
        } else {
            $tags_texts = '';
        }

        $tags = get_terms(
            array(
                'taxonomy' => 'post_tag',
                'orderby' => 'count',
                'order' => 'DESC',
                'hide_empty' => true,
                'number' => 55,
            )
        );

        $tags_text = [];
        foreach ($tags as $tag) {
            $tags_text[] = $tag->name;
        }

        if ($tags_text) {
            $tags_json = json_encode($tags_text);
        } else {
            $tags_json = json_encode([]);
        }
        // var_dump($tags_json);
        ?>
        <div>
            <input name='feditor-tags' class='feditor-tags form-control' placeholder='write some tags'
                value='<?= $tags_texts ?>'>
        </div>

        <script>
            var input = document.querySelector('input[name="feditor-tags"]'),
                // init Tagify script on the above inputs
                tagify = new Tagify(input, {
                    whitelist: <?= $tags_json ?>,
                    maxTags: 10,
                    dropdown: {
                        maxItems: 20,           // <- mixumum allowed rendered suggestions
                        classname: "tags-look", // <- custom classname for this dropdown, so it could be targeted
                        enabled: 0,             // <- show suggestions on focus
                        closeOnSelect: false    // <- do not hide the suggestions dropdown once an item has been selected
                    }
                })

        </script>
    <?php
    }

    function save($post_id, $data)
    {
        $tags = $data['feditor-tags'] ?? null;

        if (empty($tags)) {
            return;
        }

        $tags = stripslashes($tags);
        $tags = json_decode($tags, true);

        $tags_list = [];
        foreach ($tags as $item) {
            $tags_list[] = $item['value'];
        }

        wp_set_post_tags($post_id, $tags_list);
    }


    add_action('wp_head', function () {
        if (!is_singular()) {
            return;
        }

        $post = get_post();
        if (!has_shortcode($post->post_content, 'feditor')) {
            return;
        }


        ?>
        <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
        <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    <?php
    });
}