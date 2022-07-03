
<script>

import { Button, FormGroup } from "sveltestrap";
import { title,status, id, md_editor_content } from './../stores.js';
	
function handleClick() {

    title.set('');
    md_editor_content.set('');
    status.set('draft');
    id.set(undefined);

    const parsedUrl = new URL(window.location.href);
    parsedUrl.searchParams.delete('id');
    window.history.pushState("", "", parsedUrl.toString());
}

</script>


<FormGroup>
    <Button on:click={handleClick}>New</Button>
</FormGroup>
