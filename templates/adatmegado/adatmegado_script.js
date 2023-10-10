let tartalom=JSON.parse('{$params['ok_times']}');
s('osszeg').innerText='Összeg: '+tartalom.length*{$params['price']}+'Ft';
let idok='';
for(let i in tartalom){
    idok+=tartalom[i];
    if(i!=tartalom.length-1){
        idok+=', ';
    }
}
s('ok_times').innerText='Időpontok: '+idok;


