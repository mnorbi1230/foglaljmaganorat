<?php

/* Érdemes lenne json-be konvertálni, mert úgy nagyon könnyen le lehet generálni az XML-t */

/*$termek1 = '{

    "megnevezes": "útéef nyóc teszt",

    "mennyiseg": 1.0,

    "mennyisegiEgyseg" : "db",

    "nettoEgysegar": 10000,

    "afakulcs": 27,

    "nettoErtek": 10000.0,

    "afaErtek":2700.0,

    "bruttoErtek": 12700,

    "megjegyzes": "barmilyen megjegyzes"

}';



// Majd egy JSON arrayt átadni a függvénynek

$tetelek = array($termek1);*/





/*

    @parameter

    $transactionId -> az adott tranzakció azonosító (ilyen néven menti el a függvény a fájlt)

    $termekek -> JSON array a termékekről (formátum feljebb)

*/

function szamlaXML_generator($transactionId,$termekek,$fizetes,$vevoadat){

    $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><xmlszamla xmlns="http://www.szamlazz.hu/xmlszamla" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.szamlazz.hu/xmlszamla https://www.szamlazz.hu/szamla/docs/xsds/agent/xmlszamla.xsd"/>');

    $mai_datum = date("Y-m-d");

    /* Számlázz.hu belépési adatok */

    $beallitasok = $xml->addChild("beallitasok");

    $beallitasok->addChild("felhasznalo","mnorbi1230@gmail.com");

    $beallitasok->addChild("jelszo","Norbisanyipapi-254");

    $beallitasok->addChild("szamlaagentkulcs","jymih9cg42r27amd6gyrcxyruesjbejs6p42qtfkn9");

    $beallitasok->addChild("eszamla","true");

    

    $beallitasok->addChild("szamlaLetoltes","true");

    $beallitasok->addChild("valaszVerzio",1); // 1 - PDF, 2 - XML

    $beallitasok->addChild("aggregator","");

    $beallitasok->addChild("szamlaKulsoAzon","");





    /* Fejléc */

    $fejlec = $xml->addChild("fejlec");

    $fejlec->addChild("keltDatum","$mai_datum");

    $fejlec->addChild("teljesitesDatum","$mai_datum");

    $fejlec->addChild("fizetesiHataridoDatum","$mai_datum");

    $fejlec->addChild("fizmod",$fizetes);



    $fejlec->addChild("penznem","HUF");

    $fejlec->addChild("szamlaNyelve","hu");

    $fejlec->addChild("megjegyzes","");

    $fejlec->addChild("arfolyamBank","MNB");



    $fejlec->addChild("arfolyam","0.0");

    $fejlec->addChild("rendelesSzam","");

    $fejlec->addChild("dijbekeroSzamlaszam","");

    $fejlec->addChild("elolegszamla","false");



    $fejlec->addChild("vegszamla","false");

    $fejlec->addChild("helyesbitoszamla","false");

    $fejlec->addChild("helyesbitettSzamlaszam","");

    $fejlec->addChild("dijbekero","false");

    $fejlec->addChild("szamlaszamElotag","DVNCD");



    /* Eladó adatai */

    $elado = $xml->addChild("elado");

    $elado->addChild("bank","Erste Bank Zrt.");

    $elado->addChild("bankszamlaszam","11600006-00000001-96684602");

    $elado->addChild("emailReplyto","");

    $elado->addChild("emailTargy","Számlája érkezett");

    $elado->addChild("emailSzoveg","Mellékelve küldjük számláját.");



    /* Vevő adatai */

    $vevo = $xml->addChild("vevo");

    $vevo->addChild("nev",$vevoadat['surname']." ".$vevoadat['firstname']);

    $vevo->addChild("irsz",$vevoadat['postcode']);

    $vevo->addChild("telepules",$vevoadat['city']);

    $vevo->addChild("cim",$vevoadat['street']);

    $vevo->addChild("email",$vevoadat['email']);



    $vevo->addChild("sendEmail","false");

    $vevo->addChild("adoszam",$vevoadat['tax_number']);

    $vevo->addChild("postazasiNev",$vevoadat['surname2']." ".$vevoadat['firstname2']);

    $vevo->addChild("postazasiIrsz",$vevoadat['postcode2']);

    $vevo->addChild("postazasiTelepules",$vevoadat['city2']);



    $vevo->addChild("postazasiCim",$vevoadat['street2']);

    $vevo->addChild("azonosito",$vevoadat['id']);

    $vevo->addChild("telefonszam",$vevoadat['phonenumber']);

    $vevo->addChild("megjegyzes","");  // Valamiért csak ékezetmentes cuccokkal működik



    /* Termékek felsorolása */

    $tetelek = $xml->addChild("tetelek");
$szoveg='';
    for($i = 0; $i < count($termekek); $i++){

        $obj = json_decode($termekek[$i]);


        $szoveg.=$termekek[$i];
        $tetel = $tetelek->addChild("tetel");

        


    $e=0;
        foreach ($obj as $key => $value) {
            file_put_contents('obj.txt',$key.$e.$i.$value);
            $e++;
            $tetel->addChild($key,$value);

        }

    }
    file_put_contents('xml.txt',$szoveg);

   

    Header('Content-type: text/xml');

    

    $dom = dom_import_simplexml($xml)->ownerDocument;

    $dom->formatOutput = true;



    $dom->save("./generalt_xml/$transactionId.xml");

    

}



function szamlaGeneralas($transactionId){

    /* Kell a szerverre a CURL ! */

    exec("curl -v -F action-xmlagentxmlfile=@./generalt_xml/$transactionId.xml -c ./cookies.txt -o ./szamlak_pdf/$transactionId.pdf https://www.szamlazz.hu/szamla/");

}



//szamlaXML_generator("teszt_utf",$tetelek,$fizetes,$vevoadat);

//szamlaGeneralas("teszt_utf");

?>

