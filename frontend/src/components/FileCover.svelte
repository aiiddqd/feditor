<script>
  import {
    Input,
    FormText,
    Label,
  } from "sveltestrap";

import { fileCover } from './../stores.js';
import { getRestUrl, remoteRequest } from './../helpers.js';


let files;
let restUrl = getRestUrl('/wp/v2/media/');
let args = {
    method: "POST",
    headers: {
      "Content-Type": "multipart/form-data; boundary=---011000010111000001101001"
    },
};
  
$: {

    if(files !== undefined){
        // fileCover.set(files);
        
        console.log(files[0]);
        const formData = new FormData();
        formData.append("file", files);
        formData.append("title", "Hello World!");
        formData.append("caption", "Have a wonderful day!");

        // formData.append("title", files[0].name);
        // args.headers['Content-Disposition'] = 'form-data; filename=' + files[0].name;
        // formData.append("caption", files[0].name);
        // console.log(formData.);
        args.body = formData;
        // console.log(args);

        // console.log(restUrl);
        remoteRequest(restUrl, args).then(d => {
            console.log(d);
        });

    }

    
}

</script>


<Label for="coverImage">Cover Image</Label>
<Input type="file" bind:files={files} name="fileCover" id="coverImage" />
<FormText color="muted">Выберите картинку как обложку для контента</FormText>

