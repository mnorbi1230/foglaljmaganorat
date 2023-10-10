let typingTimer;
let doneTypingInterval = 700;
function kereses() {
    clearTimeout(typingTimer);
    if (s('tanarnev').value) {
        typingTimer = setTimeout(keres, doneTypingInterval);
    }
}
let typingTimer2;
function eltuntet() {
    clearTimeout(typingTimer2);
    typingTimer2 = setTimeout(tuntet, doneTypingInterval);

}
function tuntet() {
    let searchproduct=s('talalat-box');
    searchproduct.innerHTML='';
}
function keres() {
    let text=s('tanarnev').value.trim();
    console.log(text);
    if(text!=''){
        //s('homaly').style.backdrop-filter='blur(5px)';
        let params='szo='+text;
        XHR_request('search.php',true,params,{
                'load': (evt,response)=>
            {
                let tartalom=JSON.parse(response);
        let searchproduct=s('talalat-box');
        searchproduct.innerHTML='';
        if(tartalom.tanar.length!=0)
        {

            for(let i in tartalom.tanar){
                let searchprodcontainer=document.createElement('div');

                searchprodcontainer.className='searchprodcontainer';
                let searchimg=document.createElement('img');
                searchimg.className='searchimg';
                searchimg.src='public/img/user-image/'+tartalom.tanar[i].image;
                searchimg.onclick = (e)=>
                {
                    window.location.href='temavalasztas?tanar='+tartalom.tanar[i].username;
                };
                let searchright=document.createElement('div');
                searchright.className='searchright';
                let label=document.createElement('a');
                label.innerText=tartalom.tanar[i].name;
                label.href='temavalasztas?tanar='+tartalom.tanar[i].username;
                searchright.appendChild(label);
                searchprodcontainer.appendChild(searchimg);
                searchprodcontainer.appendChild(searchright);
                let kivalasztgomb=document.createElement('div');
                kivalasztgomb.onclick = (e)=>
                {
                    window.location.href='temavalasztas?tanar='+tartalom.tanar[i].username;
                };
                kivalasztgomb.className='select-button';
                kivalasztgomb.innerText='Kiválasztás';

                searchproduct.appendChild(searchprodcontainer);
                searchproduct.appendChild(kivalasztgomb);
            }
        }
        else{
            searchproduct.innerText+='Nincs ilyen tanár';
        }

    }


    });
    }
    else {
        eltuntet();
    }
}