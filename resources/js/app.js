
import {Workbox,messageSW} from 'workbox-window';
import {$} from './helper.js';

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

window.addEventListener('load', () => {
    const navBurger = $('.navbar-burger')[0]
    navBurger.addEventListener('click', function() {
            navBurger.classList.toggle('is-active');
            $('#nav-menu').classList.toggle('is-active');
    })
});


