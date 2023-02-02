# aapp-front-editor

Front Editor, Frontend Editor, FE Editor, feEditor, FEE

## roadmap
- improve API
- field Post Title (to do)
- field Category
- add AJAX option
- addon MD https://github.com/Saul-Mirone/milkdown


## config

```
add_filter('aa_fronteditor_config', function($config){
    $config['title_enable'] = false;
    return $config;
});
```

## add fields

example includes/PostTitle.php