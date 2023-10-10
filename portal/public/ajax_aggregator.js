window.s = (id) =>document.getElementById(id);
function XHR_request(URL,async,params,functions) {
    let XHR = new XMLHttpRequest();
    //Függvények
    function loadstart(event)//Kommunikáció kezdetén
    {
        if(typeof functions['loadstart'] !='undefined') functions['loadstart'](event);
    }
    function progress(event)//Menet közben
    {
        let cl = XHR.getResponseHeader('Content-Lenght');
        let uncompressed_size = XHR.getResponseHeader('X-Content-Length');
        if (typeof functions['progress'] != 'undefined') functions['progress'](event,cl,uncompressed_size);
    }
    function load(event)//amikor elkészült
    {
        let response = XHR.responseText;
        if (typeof functions['load'] != 'undefined') functions['load'](event,response);
    }
    function abort(event)//Megszakitás valaki által
    {
        if(typeof functions['abort'] !='undefined') functions['abort'](event);
    }
    function error(event)//error
    {
        if(typeof functions['error'] !='undefined') functions['error'](event);
    }
    //Eseménykezelők


    XHR.addEventListener('loadstart', loadstart, false);
    XHR.addEventListener('progress', progress, false);
    XHR.addEventListener('load', load, false);
    XHR.addEventListener('abort', abort, false);
    XHR.addEventListener('error', error, false);

    XHR.open('POST', URL, async);
    XHR.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    XHR.send(params);
}