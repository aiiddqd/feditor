<script>
  import {
    Input,
    FormText,
    FormGroup,
  } from "sveltestrap";

import { config, editor_url_external, postFromApi } from './../stores.js';


postFromApi.subscribe(data => {
  if(undefined === data.editor_url_external){
    return;
  }

  $editor_url_external = data.editor_url_external;
});




let show = false;
config.subscribe(value => {
  if(value.enableFieldUrl){
    show = true;
  }

});

  
</script>

{#if show}
<FormGroup>
<Input 
  type="url" 
  bind:value={$editor_url_external} 
  placeholder="URL..."
/>
<FormText color="muted">Укажите url</FormText>
</FormGroup>
{/if}

