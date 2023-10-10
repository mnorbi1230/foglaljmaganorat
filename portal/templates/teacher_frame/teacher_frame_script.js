const menuIcon = document.querySelector('.icon');
const navMenu = document.querySelector('.nav');

menuIcon.addEventListener('click', () => {
    menuIcon.classList.toggle('active');
navMenu.classList.toggle('active');
});

document.querySelectorAll('.nav-link').forEach(element => {
    element.addEventListener('click', () => {
    menuIcon.classList.remove('active');
navMenu.classList.remove('active');
})
});

function openmenu(menuid){
    XHR_request('menuload.php',true, `m=`+menuid,
        {
            'load':(evt, response) =>
        {
            //console.log(response);
    s('content').innerHTML = response;
}
});
}
openmenu(1);
function send(menuid)
{
    XHR_request('teacher_settings.php',true, `ps_nev=`+s('ps_nev').value+`&taxnumber=`+s('taxnumber').value+`&phnumber=`+s('ps_phnumber').value+`&irsz=`+s('ps_irsz').value+`&city=`+s('ps_city').value+`&street=`+s('ps_street').value+`&barion_email=`+s('barion_email').value+`&barion_myposkey=`+s('barion_myposkey').value+`&szamlazz_email=`+s('szamlazz_email').value+`&szamlazz_password=`+s('szamlazz_password').value,
        {
            'load':(evt, response) =>
        {
            //console.log(response);
    s('content').innerHTML = response;
}
});
}