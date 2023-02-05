# Feditor - fronted editor for WordPress

- flexible API
- simple for start
- extensible

# roadmap
- improve API
- field Post Title (to do)
- field Category
- add AJAX option
- addon MD https://github.com/Saul-Mirone/milkdown


# config

## disable title
```
add_filter('feditor_config', function($config){
    $config['title_enable'] = false;
    return $config;
});
```

## add user for no auth

`[feditor user_id=123]`

## simple add fields

example includes/PostTitle.php