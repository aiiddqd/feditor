<script>
  import {
    Button,
    Modal,
    ModalBody,
    ModalFooter,
    ModalHeader
  } from 'sveltestrap';

  import { md_editor_content } from './../stores.js';
	import {marked} from 'marked';


let text = '';
  md_editor_content.subscribe(value => {
    text = value;
  });

  let open = false;
  const toggle = () => (open = !open);
</script>

  <Button color="dark" on:click={toggle} block>Preview</Button>
  <Modal isOpen={open} {toggle} size="xl">
    <ModalHeader {toggle}>Preview</ModalHeader>
    <ModalBody>
      {@html marked(text)}
    </ModalBody>
  </Modal>
