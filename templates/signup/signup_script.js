/**
 * Created by Matus Norbert on 2021. 06. 04..
 */
let abc= '{$params ['abc']}';
let ABC= '{$params ['ABC']}';
let numbers= '{$params ['numbers']}';
let abc_HUN= '{$params ['abc_HUN']}';
let ABC_HUN= '{$params ['ABC_HUN']}';
let basic_specials= '{$params ['basic_specials']}';
let szallitas=0;
function filter(user_chars,allowed_chars,minL,maxL){

    if(user_chars.length>maxL || user_chars.length<minL) return false;

        for(let i= 0; i<user_chars.length;++i){
            let n = allowed_chars.includes(user_chars[i]);

            if (!n){
                return false;
            }
        }
        return true;



}


class Registration
{

    constructor()
    {
        //alert('Alapból');


    }
    checkAndSend(){
        //Minden mező ellenörzése
        let Ok=true;
        if (Registration.allowfilter) {
            Registration.clearerrors(s('regBox').getElementsByClassName('err'));
            if (!(Ok = Registration.check_username())) {


            }
            else Ok = Registration.check_password();
        }


        this.field_username = s('username').value;
        this.field_f_email = s('reg_email').value;
        this.field_phnumber = s('phnumber').value;
        this.field_vnev = s('vnev').value;
        this.field_knev = s('knev').value;
        this.field_irsz = s('irsz').value;
        this.field_city = s('city').value;
        this.field_street = s('street').value;
        this.field_taxnumber = s('taxnumber').value;
        this.field_password = s('password').value;
        this.field_password2 = s('password2').value;
        this.field_vnev2 = '';
        this.field_taxnumber2 = '';
        this.field_knev2 = '';
        this.field_irsz2 = '';
        this.field_city2 = '';
        this.field_street2 = '';
        if (Ok) {
           if(szallitas==1){
               this.field_vnev2 = s('vnev2').value;
               this.field_knev2 = s('knev2').value;
               this.field_irsz2 = s('irsz2').value;
               this.field_city2 = s('city2').value;
               this.field_street2 = s('street2').value;
               this.field_taxnumber2 = s('taxnumber2').value;
           }
            this.send()

        };
    }
    static clearerrors(elements){

        for (let i=0;i<elements.length;i++) elements[i].innerText='';
    }
    send(){

        XHR_request('reg.php',true,`m=2d&user=`+this.field_username+`&f_email=`+this.field_f_email+`&phnumber=`+this.field_phnumber+`&vnev=`+this.field_vnev+`&knev=`+this.field_knev+`&taxnumber=`+this.field_taxnumber+`&irsz=`+this.field_irsz+`&city=`+this.field_city+`&street=`+this.field_street+`&vnev2=`+this.field_vnev2+`&knev2=`+this.field_knev2+`&taxnumber2=`+this.field_taxnumber2+`&irsz2=`+this.field_irsz2+`&city2=`+this.field_city2+`&street2=`+this.field_street2+`&password=`+this.field_password, {
            'loadstart':(event) => {

    },
        'load': (event, response)=>{


            let obj = JSON.parse(response);

            if (obj.status == 'OK')
            {
                alert('Köszi hogy regeltél!');
            }
            else
            {
                if(obj.errCode=='1') {
                    s('err_username').innerText = 'Nem megfelelő felhasználónév.' ;
                    Registration.clearerrors([s('err_email')]);
                }
                else if (obj.errCode=='2'){
                    s('err_email').innerText = 'Nem megfelelő email-cim.';
                    Registration.clearerrors([s('err_username')]);
                }
                else{
                    alert('A regisztráció nem sikerült!');
                    Registration.clearerrors([s('err_email')]);
                    Registration.clearerrors([s('err_username')]);
                }

            }

        },
        'error':(event) => {
            alert('Nem sikerült a szerveren a mentés.');
        }
    });
    }
    static check(field, allowed_chars,minlength,maxlength){
        let data =field.value;

        return filter(data,allowed_chars, minlength, maxlength);

}
    static check_username()
    {
        if (Registration.allowfilter) {

            Registration.clearerrors([s('err_username')]);
            if (Registration.check(s('username'), abc + numbers, 3, 25)) {

                return true;
            }
            s('err_username').innerText = 'Nem megfelelő felhasználónév.';
            return false;
        }

        return true;
    }
    static check_password()
    {
        if (Registration.allowfilter) {
            Registration.clearerrors([s('err_password')]);
            if (Registration.check(s('password'), abc + numbers + abc_HUN + ABC + ABC_HUN + basic_specials, 8, 255)) {
                let data = s('password').value;
                let Ok = 0;
                let Ok2 = 0;
                let Ok3 = 0;
                for (let i = 0; i < data.length; ++i) {
                    if (abc_HUN.includes(data[i]) || abc.includes(data[i])) {
                        ++Ok;
                    }
                    if (ABC_HUN.includes(data[i]) || ABC.includes(data[i])) {
                        ++Ok2;
                    }
                    if (numbers.includes(data[i])) {
                        ++Ok3;
                    }
                }
                if (Ok > 0 && Ok2 > 0 && Ok3 > 0) return true;
            }
            s('err_password').innerText = 'Nem megfelelő jelszó.';
            return false;
        }
        return true;
    }
    static check_email()
    {
        if (Registration.allowfilter) {
            Registration.clearerrors([s('err_email')]);
            if (Registration.check(s('reg_email'), abc + numbers + basic_specials, 6, 100)) {
                let data = s('reg_email').value;
                let Ok = false;
                let Ok2 = false;
                for (let i = 0; i < data.length; ++i) {
                    if (data[i] == '.') {
                        Ok = true;
                    }
                    if (data[i] == '@') {
                        Ok2 = true;
                    }
                }
                if (Ok && Ok2) return true;
            }
            s('err_email').innerText = 'Nem megfelelő az email cim.';
            return false;
        }
        return true;
    }
    static check_password2()
    {
        if (Registration.allowfilter) {
            Registration.clearerrors([s('err_password2')]);
            if (s('password').value == s('password2').value) {

                return true;
            }
            s('err_password2').innerText = 'A jelszavak nem egyeznek';
            return false;

        }
        return true;
    }
    static check_phnumber()
    {
        if (Registration.allowfilter) {
            Registration.clearerrors([s('err_phnumber')]);
            if (Registration.check(s('phnumber'), numbers, 7, 20)) {

                return true;
            }
            s('err_phnumber').innerText = 'Nem megfelelő a telefonszám.';
            return false;
        }
        return true;
    }
    static check_vnev()
    {
        if (Registration.allowfilter) {
            Registration.clearerrors([s('err_vnev')]);
            if (Registration.check(s('vnev'), abc + abc_HUN + basic_specials + ABC + ABC_HUN, 3, 40)) {

                return true;
            }
            s('err_vnev').innerText = 'Nem megfelelő a vezetéknév!';
            return false;
        }
        return true;
    }
    static check_knev()
    {
        if (Registration.allowfilter) {
            Registration.clearerrors([s('err_knev')]);
            if (Registration.check(s('knev'), abc + abc_HUN + basic_specials + ABC + ABC_HUN, 3, 40)) {

                return true;
            }
            s('err_knev').innerText = 'Nem megfelelő a keresztnév!';
            return false;
        }
        return true;
    }
    static check_irsz()
    {
        if (Registration.allowfilter) {
            Registration.clearerrors([s('err_irsz')]);
            if (Registration.check(s('irsz'), numbers, 4, 4)) {

                return true;
            }
            s('err_irsz').innerText = 'Hibás irányitószám';
            return false;
        }
        return true;
    }
    static check_city()
    {
        if (Registration.allowfilter) {
            Registration.clearerrors([s('err_city')]);
            if (Registration.check(s('city'), abc + abc_HUN + ABC + ABC_HUN, 2, 25)) {

                return true;
            }
            s('city').innerText = 'Nem megfelelő város';
            return false;
        }
        return true;
    }
    static check_street()
    {
        if (Registration.allowfilter) {
            Registration.clearerrors([s('err_street')]);
            if (Registration.check(s('street'), abc + numbers + abc_HUN + basic_specials + ABC + ABC_HUN, 7, 80)) {
                return true;
            }
            s('err_street').innerText = 'Nem megfelelő utca.';
            return false;
        }
        return true;
    }
    //2.
    static check_phnumber2()
    {
        if (Registration.allowfilter) {
            Registration.clearerrors([s('err_phnumber2')]);
            if (Registration.check(s('phnumber2'), numbers, 7, 20)) {

                return true;
            }
            s('err_phnumber2').innerText = 'Nem megfelelő a telefonszám.';
            return false;
        }
        return true;
    }
    static check_vnev2()
    {
        if (Registration.allowfilter) {
            Registration.clearerrors([s('err_vnev2')]);
            if (Registration.check(s('vnev2'), abc + abc_HUN + basic_specials + ABC + ABC_HUN, 3, 40)) {

                return true;
            }
            s('err_vnev2').innerText = 'Nem megfelelő a vezetéknév!';
            return false;
        }
        return true;
    }
    static check_knev2()
    {
        if (Registration.allowfilter) {
            Registration.clearerrors([s('err_knev2')]);
            if (Registration.check(s('knev2'), abc + abc_HUN + basic_specials + ABC + ABC_HUN, 3, 40)) {

                return true;
            }
            s('err_knev2').innerText = 'Nem megfelelő a keresztnév!';
            return false;
        }
        return true;
    }
    static check_irsz2()
    {
        if (Registration.allowfilter) {
            Registration.clearerrors([s('err_irsz2')]);
            if (Registration.check(s('irsz2'), numbers, 4, 4)) {

                return true;
            }
            s('err_irsz2').innerText = 'Hibás irányitószám';
            return false;
        }
        return true;
    }
    static check_city2()
    {
        if (Registration.allowfilter) {
            Registration.clearerrors([s('err_city2')]);
            if (Registration.check(s('city2'), abc + abc_HUN + ABC + ABC_HUN, 2, 25)) {

                return true;
            }
            s('err_city2').innerText = 'Nem megfelelő város';
            return false;
        }
        return true;
    }
    static check_street2()
    {
        if (Registration.allowfilter) {
            Registration.clearerrors([s('err_street2')]);
            if (Registration.check(s('street2'), abc + numbers + abc_HUN + basic_specials + ABC + ABC_HUN, 7, 80)) {
                return true;
            }
            s('err_street2').innerText = 'Nem megfelelő utca.';
            return false;
        }
        return true;
    }
    static check_taxnumber(){
        if (Registration.allowfilter) {
            Registration.clearerrors([s('err_taxnumber')]);
            if(s('taxnumber').value!== ''){
                if (Registration.check(s('taxnumber'),  numbers+basic_specials, 10, 12)) {
                    return true;
                }
                s('err_taxnumber').innerText = 'Nem megfelelő adószám.';
                return false;
            }
            else{
                return true;
            }
        }
        return true;
    }
    static check_taxnumber2(){
        if (Registration.allowfilter) {
            Registration.clearerrors([s('err_taxnumber2')]);
            if(s('taxnumber2').value!==''){
                if (Registration.check(s('taxnumber2'),  numbers+basic_specials, 10, 12)) {
                    return true;
                }
                s('err_taxnumber2').innerText = 'Nem megfelelő adószám.';
                return false;
            }
            else{
                return true;
            }
        }
        return true;
    }
}
function valtas(ertek) {
    let container=s('szallitas');
    if(ertek==0){
        szallitas=0;
        container.innerHTML='';
    }
    else{
        szallitas=1;
        let adatok=[
            {nev: 'Vezetéknév:',id:'vnev2',type:'text',fuggveny:'Registration.check_vnev2()',min:3,max:40},
            {nev: 'Keresztnév:',id:'knev2',type:'text',fuggveny:'Registration.check_knev2()',min:3,max:40},
            {nev: 'Adószám:(csak cég esetében)',id:'taxnumber2',type:'text',fuggveny:'Registration.check_taxnumber2()',min:10,max:12},
            {nev: 'Irányítószám:',id:'irsz2',type:'number',fuggveny:'Registration.check_irsz2()',min:1000,max:9999},
            {nev: 'Város:',id:'city2',type:'text',fuggveny:'Registration.check_city2()',min:2,max:25},
            {nev: 'Utca és házszám:',id:'street2',type:'text',fuggveny:'Registration.check_street2()',min:7,max:80}
        ];
        let cim=document.createElement('h2');
        cim.innerText='Szállítási adatok:';
        container.appendChild(cim);
        for(let i in adatok){
            let row=document.createElement('div');
            row.className='row';
            let nev=document.createElement('div');
            nev.className='col';
            nev.innerHTML=adatok[i].nev;
            row.appendChild(nev);
            let inputcontainer=document.createElement('div');
            inputcontainer.className='col';
            let input=document.createElement('input');
            input.type=adatok[i].type;
            input.id=adatok[i].id;
            input.onkeyup=function (ev) { eval(adatok[i].fuggveny) }
            if(adatok[i].type=='number'){
                input.min=adatok[i].min;
                input.max=adatok[i].max;
            }
            else{
                input.minLength=adatok[i].min;
                input.maxLength=adatok[i].max;
            }
            input.required='required';
            inputcontainer.appendChild(input);
            let errorcontainer=document.createElement('div');
            errorcontainer.id='err_'+adatok[i].id;
            errorcontainer.class='err';
            inputcontainer.appendChild(errorcontainer);
            row.appendChild(inputcontainer);
            container.appendChild(row);
        }
    }
}
Registration.allowfilter=true;
let Reg = new Registration();