<?php
function file_write($file_path,$data,$append_mode = false){
    $handle = fopen($file_path,$append_mode ? 'a' : 'w');
    fwrite($handle,$data);
    fclose($handle);
}
function file_read($file_path, $bytes=0){
    $handle = fopen($file_path,'r');
    if($bytes>0)
    {
        $data=fread($handle,$bytes);
    }
    else{
        if(($size = filesize($file_path))>0){
            $data=fread($handle,$size);
        }
        else $data="";
    }

    return $data;
}

function template($name, $params=[],$allow_cssjs=true){
    $content='';

    eval('$content="'

            .($allow_cssjs ? "<style>" : "")
            .($allow_cssjs ? file_read('templates/'.$name .'/' .$name.'_style.css'):"")
            .($allow_cssjs ? "</style>" : "")
            .str_replace(['<center>', '</center>'], '', file_read('templates/'.$name .'/' .$name.'.html'))
            .($allow_cssjs ? "<script>/*<![CDATA[*/" : "")
            .($allow_cssjs ? file_read('templates/'.$name .'/' .$name.'_script.js'):"")
            .($allow_cssjs ? "/*]]>*/</script>" : "")
        .'";'
    );
    return $content;
}
function template_prod($name, $params=[],$allow_cssjs=true){
    $content='';
    $file_path = 'templates/proddesc/'.$name .'/' .$name.'.html';
    if (!file_exists($file_path)) {
        return "";
    }
    else{
        eval('$content="'

            .($allow_cssjs ? "<style>" : "")
            .($allow_cssjs ? file_read('templates/proddesc/'.$name .'/' .$name.'_style.css'):"")
            .($allow_cssjs ? "</style>" : "")
            .str_replace(['<center>', '</center>'], '', file_read('templates/proddesc/'.$name .'/' .$name.'.html'))
            .($allow_cssjs ? "<script>/*<![CDATA[*/" : "")
            .($allow_cssjs ? file_read('template/sproddesc/'.$name .'/' .$name.'_script.js'):"")
            .($allow_cssjs ? "/*]]>*/</script>" : "")
            .'";'
        );
        return $content;
    }

}

function filter($user_chars,$allowed_chars,$minL,$maxL)
{

    if (strlen($user_chars) > $maxL || strlen($user_chars) < $minL) return false;

    for ($i = 0; $i < strlen($user_chars); ++$i) {
        $n = strpos($allowed_chars,$user_chars[$i]);
        file_put_contents('valaki.txt',$i);
        if ($n==null and $user_chars[$i]!=$allowed_chars[0]) {
            return false;
        }
    }
    return true;
}