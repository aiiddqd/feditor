import { requestInProgress, config, appPass } from './stores.js';

let headers = {};

let restBaseUrl;

config.subscribe((value) => {
  if (value.nonce) {
    headers['X-WP-Nonce'] = value.nonce;
  }

  console.log(value);

  restBaseUrl = value.root;
});

appPass.subscribe((value) => {
  if (value && headers['X-WP-Nonce'] === undefined) {
    headers['Authorization'] = value;
  }
});


export function changeUrl(key, value = '') {
  // console.log(window.location);
  // console.log(window.location);
  let url = new URL(window.location.origin + window.location.pathname);
  url.searchParams.set(key, value);

  // console.log(url, url.toString());
  
  window.history.pushState("", "", url.toString());
}

export function getRestUrl(path = '') {
  path = path.startsWith('/') ? path.slice(1) : path;
  return restBaseUrl + path;
}


export async function remoteRequest(url, args = {}) {
  requestInProgress.set(true);

  let data = [];
  
  if (undefined === url) {
    requestInProgress.set(false);
    return false;
  }

  if (args.method === undefined) {
    args.method = 'GET';
  }
  if (undefined === args.headers) {
    args.headers = headers;
  }

  if(headers['X-WP-Nonce']){
    args.headers['X-WP-Nonce'] = headers['X-WP-Nonce'];
  } else {
    args.headers['Authorization'] = headers['Authorization'];
  }

  if(args.headers["Content-Type"] === undefined) {
    args.headers["Content-Type"] = "application/json";
  }

  console.log(url, args);
  const response = await fetch(url, args);

  if (response.ok) {
    data.json = await response.json();
    data.url = url;
  }

  console.log(data);

  requestInProgress.set(false);

  return data;
}
