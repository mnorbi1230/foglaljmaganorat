<?php 
    function lekeresXML_generatorPDF($filename,$invoice_id){
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><xmlszamlapdf xmlns="http://www.szamlazz.hu/xmlszamlapdf" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.szamlazz.hu/xmlszamlapdf https://www.szamlazz.hu/szamla/docs/xsds/agentpdf/xmlszamlapdf.xsd" />');
        
        $xml->addChild("felhasznalo","");
        $xml->addChild("jelszo","");
        $xml->addChild("szamlaagentkulcs","ket6mqcybr43kifn2ubxzcwdyf7scsxn5kwr3nzh3f");
        $xml->addChild("szamlaszam",$invoice_id);
        
        $xml->addChild("valaszVerzio","1");
        $xml->addChild("szamlaKulsoAzon","");

        Header('Content-type: text/xml');
    
        $dom = dom_import_simplexml($xml)->ownerDocument;
        $dom->formatOutput = true;

        $dom->save("./generalt_xml/$filename.xml");
    }

    function lekeresXML_generatorXML($filename,$invoice_id){
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><xmlszamlaxml xmlns="http://www.szamlazz.hu/xmlszamlaxml" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.szamlazz.hu/xmlszamlaxml https://www.szamlazz.hu/szamla/docs/xsds/agentxml/xmlszamlaxml.xsd" />');
        
        $xml->addChild("felhasznalo","");
        $xml->addChild("jelszo","");
        $xml->addChild("szamlaagentkulcs","ket6mqcybr43kifn2ubxzcwdyf7scsxn5kwr3nzh3f");
        $xml->addChild("szamlaszam",$invoice_id);
        
        Header('Content-type: text/xml');
    
        $dom = dom_import_simplexml($xml)->ownerDocument;
        $dom->formatOutput = true;

        $dom->save("./generalt_xml/$filename.xml");
    }
    function szamlaLekeresPDF($filename,$invoice_id){
        exec("curl -v -F action-szamla_agent_pdf=@./generalt_xml/$filename.xml -c ./cookies.txt -o ./szamlak_pdf/lekert_$invoice_id.pdf https://www.szamlazz.hu/szamla/");
    }

    function szamlaLekeresXML($filename,$invoice_id){
        exec("curl -v -F action-szamla_agent_xml=@./generalt_xml/$filename.xml -c ./cookies.txt -o ./szamlak_xml/lekert_$invoice_id.xml https://www.szamlazz.hu/szamla/");
    }

    function szamlaToArray($filename){
        $xml = simplexml_load_file("./szamlak_xml/".$filename);
        $json_object = json_decode(json_encode($xml));

        return $json_object;
    }

    //lekeresXML_generatorXML("lekeres_teszt_xml", "E-DVN-2023-7");
    //szamlaLekeresXML("lekeres_teszt_xml","E-DVN-2023-7");
    szamlaToArray("lekert_E-DVN-2023-7.xml");
?>