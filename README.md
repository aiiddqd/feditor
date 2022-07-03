# aapp-front-editor

## todo
- improve API
- add AJAX option


## config

```
add_filter('aa_fronteditor_config', function($config){
    $config['title_enable'] = false;
    return $config;
});
```

## add fields

```
namespace AApps\FrontEditor\PostTitle;

add_action('aapps_front_editor_fields', __NAMESPACE__ . '\\render_input', 5);


function render_input(){
    $config = aa_fe_get_config();
    if(empty($config['title_enable'])){
        return;
    }
    printf('<input type="text" name="post_title" class="form-control" value="" />');

}
```