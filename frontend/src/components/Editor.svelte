<script>
  import { FormGroup, Input, Label } from "sveltestrap";
  import { content, md_editor_content, postFromApi } from './../stores.js';


postFromApi.subscribe(data => {
  if(undefined === data.md_editor_content){
    return;
  }

  $md_editor_content = data.md_editor_content;
});


  let inner;
  const resize = () => {
    inner.style.height = "auto";
    inner.style.height = 4 + inner.scrollHeight + "px";
  };
</script>

<FormGroup>
  <Input
    rows={7}
    type="textarea"
    bind:inner
    bind:value={$md_editor_content}
    on:input={resize}
    aria-label="Post Content"
    id="article_body_markdown"
    name="body_markdown"
    placeholder="Write your post content here..."
  />
</FormGroup>
