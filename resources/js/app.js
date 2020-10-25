
import {Workbox,messageSW} from 'workbox-window';

window.$ = function $(el) {
    return (el.charAt(0) == "#")
        ? document.querySelector(el)
        : document.querySelectorAll(el)
}

//axios
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';



if ('serviceWorker' in navigator) {
    let registration;
    const wb = new Workbox('/service-worker.js');
    const runskipWaiting = (event) => {
        wb.addEventListener('controlling', (event) => {
            window.location.reload();
        });

        if (registration && registration.waiting) {
            // Send a message to the waiting service worker,
            // instructing it to activate.  
            // Note: for this to work, you have to add a message
            // listener in your service worker. See below.
            messageSW(registration.waiting, {type: 'SKIP_WAITING'});
        }
  
  
    }  

    wb.addEventListener('waiting', runskipWaiting);
    wb.addEventListener('externalwaiting', runskipWaiting);

    wb.register().then((r) => registration = r);
}


