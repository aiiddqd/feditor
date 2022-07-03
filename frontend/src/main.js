import App from './App.svelte';

let editorElement = document.querySelector('.feapp');
editorElement.innerHTML = '';

const app = new App({
	target: editorElement
});


export default app;