<script>
  import {
    FormGroup,
    Input,
  } from "sveltestrap";
  import { status, postFromApi } from './../stores.js';


let inputValue = false;

status.subscribe(value => {
  if(value === 'draft'){
    inputValue = false;
  } else {
    inputValue = true;
  }
});

postFromApi.subscribe(value => {
  if(undefined === value.status){
    return;
  }
  if('publish' == value.status){
    status.set('publish');
  } else {
    status.set('draft');
  }
});



$: {
  if(inputValue === true){
    status.set('publish');
  } else {
    status.set('draft');
  }
  // console.log(inputValue);
  // console.log($status);

}

</script>


<Input bind:checked={inputValue} id="c1" type="switch" label="Public" />
