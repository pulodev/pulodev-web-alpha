import {$} from './helper.js';

window.onload = () => {
    $('#search-filter-media').addEventListener('click',(e)=>{
        const media = e.target.getAttribute('media');
        
        onClickFilterBy(media);
    });
}

function onClickFilterBy(media) {
    const url = window.location.href.split('?')[0];
    let currentFilterVal = getUrlParamValue('filter');
    let query = getUrlParamValue('query');
    let urlParams = `query=${query}`;

    if(currentFilterVal !== media) {
        urlParams += `&filter=${media}`;
    }
    
    window.location = `${url}?${urlParams}`;
}

function getUrlParamValue(param) {
    let urlParams = window.location.href.split('?')[1];

    if(urlParams) {
        let keyValue = urlParams.split('&').filter(key => key.includes(param));
        
        if (keyValue.length > 0) {
            return keyValue[0].split('=')[1];
        }
    }

    return null;
}