//custom selector
window.$ = function $(el) {
    return (el.charAt[0] == "#")
        ? document.querySelector(el)
        : document.querySelectorAll(el)
}

//axios
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';