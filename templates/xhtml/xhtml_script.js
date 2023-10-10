
let param='{$params['cookie']}';

function checkCookie() {
    var cookieBanner = document.getElementById('cookie-banner');
    if (cookieBanner) {
        cookieBanner.innerHTML = 'Cookie elfogadva.';
        XHR_request('cookie.php', true,[],{
            'load':(event, response)=>{

        }
    });
    } else {
        cookieBanner.style.display = 'block';
    }
}
if(param=='Y'){
    var cookieBanner = document.getElementById('cookie-banner');
    cookieBanner.innerHTML = 'Cookie elfogadva.';

}
else{
    var cookieBanner = document.getElementById('cookie-banner');
    cookieBanner.style.display = 'block';
}
