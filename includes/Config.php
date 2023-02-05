<?php

namespace Feditor\Config {

    const OPTION_KEY = 'feditor_config';
    const OPTION_PAGE = 'feditor-settings';

    add_action('admin_init', function(){
        register_setting( OPTION_PAGE, OPTION_KEY );
    });

    add_action('admin_init', __NAMESPACE__ . '\\add_setting_base_css');


    function add_setting_base_css(){
        
        add_settings_field(
            'base_css',
            $title = 'Base CSS',
            $callback = function () {
                $value = get_config()['base_css'] ?? null;
                $name = sprintf('%s[%s]', OPTION_KEY, 'base_css');
                printf('<input type="checkbox" name="%s" value="1" %s />', $name, checked(1, $value, false));

                return 1;
            },
			OPTION_PAGE
		);

    }

    function get_config(){

        $config_default = [
            'base_css' => true,
            'title_enable' => true,
        ];

        $config = get_option(OPTION_KEY, $config_default);
        if(empty($config)){
            $config = $config_default;
        }
        // var_dump($config);
        // exit;
        
        return apply_filters('feditor_config', $config);
    }

    add_action('admin_menu', function () {

        add_options_page(
            'Feditor Options',
            'Feditor',
            'manage_options',
            OPTION_PAGE,
            function () {
                ?>
                <form method="POST" action="options.php">

                    <h1><?= __( 'Feditor Config', 'feditor' ) ?></h1>
                    <?php 
                    do_action('feditor_settings_after_header');
                    settings_fields(OPTION_PAGE);
                    do_settings_sections(OPTION_PAGE);
                    submit_button();
                    ?>
                </form>
                <?php 
            }
        );

        add_settings_section( 'default', '', '', OPTION_PAGE );

    });


}