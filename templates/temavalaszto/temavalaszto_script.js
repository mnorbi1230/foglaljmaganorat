let tartalom=JSON.parse('{$params['themes']}');
let themesbox=s('themesbox');
themesbox.innerHTML='';
let kivalasztott=999;
function kivalaszt(kiv_id) {
    if(kivalasztott!=999){
        let regi_boxid='box'+kivalasztott;
        s(regi_boxid).className='theme_box';
    }
    let akt_boxid='box'+kiv_id;
    kivalasztott=kiv_id;
    console.log(kivalasztott);
    console.log(tartalom.length);
    s(akt_boxid).className='theme_box kivalasztott';
}
function next() {
    if(kivalasztott!=999){
        window.location.href='napvalasztas?tanar={$params['username']}&theme='+kivalasztott;
    }
    else{
        alert('Jelölj ki egy témakört!');
    }
}
if(tartalom.length!=0)
{
    let cim=tartalom[0].user_name+ ' magántanárhoz';
    s('cim').innerText=cim;
    for(let i in tartalom){

        let theme_box=document.createElement('div');
        theme_box.className='theme_box';
        theme_box.id='box'+tartalom[i].id;
        theme_box.onclick = (e)=>
        {
            kivalaszt(tartalom[i].id)
        };

        theme_box.innerText=tartalom[i].name;
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
    s('cim').innerText='Ez a tanár nem tanít jelenleg.';


}

