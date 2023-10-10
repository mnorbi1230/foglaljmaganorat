<?php 

function sztornoXML_generator($transactionId, $invoice_id){
    $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><xmlszamlast xmlns="http://www.szamlazz.hu/xmlszamlast" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.szamlazz.hu/xmlszamlast https://www.szamlazz.hu/szamla/docs/xsds/agentst/xmlszamlast.xsd"/>');
    $mai_datum = date("Y-m-d");
    $beallitasok = $xml->addChild("beallitasok");
    $beallitasok->addChild("felhasznalo","");
    $beallitasok->addChild("jelszo","");
    $beallitasok->addChild("szamlaagentkulcs","ket6mqcybr43kifn2ubxzcwdyf7scsxn5kwr3nzh3f");
    $beallitasok->addChild("eszamla","true");
    
    $beallitasok->addChild("szamlaLetoltes","true");
    $beallitasok->addChild("szamlaLetoltesPld",1);
    $beallitasok->addChild("szamlaKulsoAzon","");

    $fejlec = $xml->addChild("fejlec");
    $fejlec->addChild("szamlaszam","$invoice_id");
    $fejlec->addChild("keltDatum","$mai_datum");
    $fejlec->addChild("tipus","SS");

    $elado = $xml->addChild("elado");
    $elado->addChild("emailReplyto","seller@example.com");
    $elado->addChild("emailTargy","seller@example.com");
    $elado->addChild("emailSzoveg","Lorem ipsum");

    $vevo = $xml->addChild("vevo");
    $vevo->addChild("email","asd@asd.com");

    Header('Content-type: text/xml');
    
    $dom = dom_import_simplexml($xml)->ownerDocument;
    $dom->formatOutput = true;

    $dom->save("./generalt_xml/$transactionId.xml");
}   
function szamlaSztorno($transactionId){
    exec("curl -v -F action-szamla_agent_st=@./generalt_xml/$transactionId.xml -c ./cookies.txt -o ./szamlak_pdf/sztorno_$transactionId.pdf https://www.szamlazz.hu/szamla/");
}
sztornoXML_generator("teszt_sztorno","E-DVN-2023-8");
szamlaSztorno("teszt_sztorno");
?>