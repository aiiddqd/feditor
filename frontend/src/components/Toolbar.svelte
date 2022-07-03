<script>
  import {
    Input,
    Button,
    ButtonGroup,
    Styles,
    Icon,
    FormGroup,
  } from "sveltestrap";

  import { requestInProgress, config, appPass } from './../stores.js';

  let show = false;

  config.subscribe(value => {

    console.log(value);

		if(value.toolbarEnable){
      show = true;
    }

  });

</script>

{#if show }
<FormGroup>
  <ButtonGroup>
    <Button color="link">
      <Icon name="type-bold" />
    </Button>
    <Button color="link">
      <Icon name="type-italic" />
    </Button>
    <Button color="link">
      <Icon name="link" />
    </Button>
    <Button color="link">
      <Icon name="list-ul" />
    </Button>
    <Button color="link">
      #
    </Button>
    <Button color="link">
      <Icon name="image" />
    </Button>
  </ButtonGroup>
</FormGroup>
{/if}
