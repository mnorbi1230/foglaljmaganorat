let tartalom=JSON.parse('{$params['free_times']}');
let themesbox=s('themesbox');
themesbox.innerHTML='';
let kivalasztottak=[];
function kivalaszt(kiv_id) {
    if(kivalasztottak.includes(kiv_id)){
        let index = kivalasztottak.indexOf(kiv_id);
        if (index !== -1) {
            kivalasztottak.splice(index, 1);
        }
        let regi_boxid='box'+kiv_id;
        s(regi_boxid).className='theme_box';
    }
    else{
        kivalasztottak.push(kiv_id);
        let akt_boxid='box'+kiv_id;
        s(akt_boxid).className='theme_box kivalasztott';
    }
    console.log(kivalasztottak);
}
function next() {
    if(kivalasztottak.length>0){
        window.location.href='adatmegadas?tanar={$params['username']}&theme={$params['theme']}&date={$params['date']}&times='+kivalasztottak;
    }
    else{
        alert('Jelölj ki egy időpontot!');
    }
}
if(tartalom.length!=0)
{

    for(let i in tartalom){

        let theme_box=document.createElement('div');
        theme_box.className='theme_box';
        theme_box.id='box'+tartalom[i];
        theme_box.onclick = (e)=>
        {
            kivalaszt(tartalom[i])
        };

        theme_box.innerText=tartalom[i];
        themesbox.appendChild(theme_box);
    }
    let kivalasztgomb=document.createElement('div');
    kivalasztgomb.className='select-button';
    kivalasztgomb.innerText='Tovább';
    kivalasztgomb.onclick = (e)=>
    {
        next();
    };
    s('next-button').appendChild(kivalasztgomb);
}
else{
    searchproduct.innerText+='Nincs időpont erre a napra.';
}

