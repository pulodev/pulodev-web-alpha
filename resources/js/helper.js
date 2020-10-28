const headers ={
    'Content-Type': 'application/json',
    'X-XSRF-TOKEN': getCookie('XSRF-TOKEN'),
    'X-Requested-With' : 'XMLHttpRequest'
    };
    
export function $(el) {
    return (el.charAt(0) == "#")
        ? document.querySelector(el)
        : document.querySelectorAll(el)
}

export async function postJSON(url,params){
    
    const token = document.querySelector('meta[name="csrf-token"]');
   
    if(token!==null)
        headers['X-CSRF-TOKEN'] = token.getAttribute('content');

    const resp = await fetch(url,{
        method:'post',
        body: JSON.stringify(params),
        credentials: 'same-origin',
        headers:headers
    });
    return await resp.json();
}

export async function getJSON(url,params){
    let linkURL = url;
    if(typeof linkURL ==='string')
        linkURL = new URL(window.location.href);

    const token = document.querySelector('meta[name="csrf-token"]');
    if(token!==null)
        headers['X-CSRF-TOKEN'] = token.getAttribute('content');

    url.search = new URLSearchParams(params).toString();
    const resp = await fetch(url,{
        credentials: 'same-origin',
        headers: headers
    });
    return await resp.json();
}

function getCookie(name) {
    var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    if (match) return match[2];
}