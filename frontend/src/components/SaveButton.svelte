<script>
  import { Button } from "sveltestrap";
  import { apiBaseUrl, postUpdate, id } from "./../stores.js";
  import { remoteRequest, changeUrl } from "./../helpers.js";

  function handleClick() {
    if (undefined === $id) {
      const url = $apiBaseUrl + "posts/";

      const args = {
        method: "POST",
        body: JSON.stringify($postUpdate),
      };

      console.log(url, args);
      remoteRequest(url, args).then(data => {
          // console.log(data);
          if(data.json){
            id.set(data.json.id);
            changeUrl("id", $id);
          }
      });


    } else {
      const url = $apiBaseUrl + "posts/" + $id;

      const args = {
        method: "POST",
        body: JSON.stringify($postUpdate),
      };

      remoteRequest(url, args);
    }
  }
</script>

<Button color="primary" on:click={handleClick} block>Save</Button>
