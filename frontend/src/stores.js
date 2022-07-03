import { readable, writable, derived } from 'svelte/store';
import {marked} from 'marked';


export const title = writable('');
export const status = writable('draft'); //or publish
export const editor_url_external = writable(''); //or publish
export const md_editor_content = writable('');
export const content = derived(md_editor_content, ($md_editor_content, set) => {
	let cont = marked($md_editor_content);
	set(cont);
});


export const requestInProgress = writable(false);

export const apiBaseUrl = readable('', function start(set) {
	const url = APP_API_URL;

	set(url);
	return function stop() {
		set(undefined);
	};
});


export const id = writable(undefined, function start(set) {
	let searchParams = new URLSearchParams(window.location.search);
	if(searchParams.get('id') > 0){
		set(searchParams.get('id'));
	}
});

export const config = readable({}, function start(set) {
	if(typeof editorFeMdConfig !== 'undefined'){ 
		set(editorFeMdConfig);
	} else {
		set({
			root: APP_REST_URL,
			page: '/',
			toolbarEnable: 0,
			fileCoverEnable: 0,
			enableFieldUrl: 1,
		});
	}
});

export const nonceKey = readable(undefined, function start(set) {

	if(typeof editorFeMdApi !== 'undefined'){ 
		set(editorFeMdApi.nonce);
		console.log('editorFeMdApi', editorFeMdApi);
	} else {
		set(undefined);
	}
});


export const appPass = readable(undefined, function start(set) {
    const username = ENV_APP_USER_NAME;
    const pass = ENV_APP_PASS;
	const base64hash = btoa(username + ":" + pass);

	set("Basic " + base64hash);

	return function stop() {
		set(undefined);
	};
});


//mb to delete? 
export const configStore = writable({});


export const postFromApi = writable({});
export const fileCover = writable(undefined);



export const postUpdate = derived([id, title, status, content, md_editor_content, editor_url_external], ([$id, $title, $status, $content, $md_editor_content, $editor_url_external], set) => {
	
	let data = {
		// id: $id,
		title: $title,
		content: $content,
		editor_url_external: $editor_url_external,
		// excerpt: '',
		md_editor_content: $md_editor_content,
		status: $status,
		categories: [88],
		// tags: '',
		md_editor_enable: true,
	};
	console.log(data);
	set(data);
});
