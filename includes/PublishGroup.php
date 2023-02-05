<?php

namespace Feditor\PublishGroup {

    add_action('feditor_fields', __NAMESPACE__ . '\\view', 55, 2);
    add_filter('feditor_post_save_data', __NAMESPACE__ . '\\save', 10, 2);


    function view($post_id, $args)
    {
        if (empty($post_id)) {
            $status = 'draft';
        } else {
            $status = get_post($post_id)->post_status ?? 'draft';
        }

        $only_draft = $args['only_draft'] ?? false;

        ?>
        <div class="feditor-save-group wp-block-group">
            <div class="wp-block-group is-layout-flex">
                <div class="wp-block-group">
                    <span>
                        <input type="submit" id="submit" value="Save" />
                    </span>
                </div>
                <?php if ($status == 'publish'): ?>
                    <span>
                        <a href="<?= get_permalink($post_id) ?>" target="_blank" rel="noopener noreferrer">View</a>
                    </span>
                <?php endif; ?>
                <!-- /wp:group -->

                <?php if (empty($only_draft)): ?>
                    <!-- wp:group {"layout":{"type":"constrained"}} -->
                    <div class="wp-block-group">
                        <span>
                            <input type="radio" id="post-draft" name="post_status" value="draft" <?php checked('draft', $status) ?>>
                            <label for="post-draft">Draft</label>
                        </span>
                        <span>
                            <input type="radio" id="post-publish" name="post_status" value="publish" <?php checked('publish', $status) ?>>
                            <label for="post-publish">Public</label>
                        </span>

                    </div>
                <?php endif; ?>

            </div>
        <?php
    }

    function save($save_data, $data)
    {
        if ($data['post_status'] == 'publish') {
            $save_data['post_status'] = 'publish';
        } else {
            $save_data['post_status'] = 'draft';
        }

        return $save_data;
    }

}