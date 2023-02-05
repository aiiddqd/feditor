# Feditor - frontemd editor for WordPress

- flexible API
- simple for start
- extensible

![Frontend Editor WordPress](assets/thumbnail.png?raw=true "Frontend Editor WordPress")


# addons

here https://github.com/topics/feditor-addons

# roadmap
- improve API
- field Post Title (to do)
- field Category
- add AJAX option
- addon MD https://github.com/Saul-Mirone/milkdown


# config

## just add editor
- add page
- add shortcode `[feditor]`

## disable title
```
add_filter('feditor_config', function($config){
    $config['title_enable'] = false;
    return $config;
});
```


## simple add fields

example includes/PostTitle.php

# Shortcode args

## only_draft

`[feditor only_draft=1]`

## add user for no auth

`[feditor user_id=123]`

## hide select category - only default

`[feditor default_category=1]`
