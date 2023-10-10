<?php
require_once 'system/common.php';
if(isset($_POST['szo'])) {
    function kereses($arr, $element)
    {
        for ($i = 0; $i < count($arr); ++$i) {
            if ($arr[$i] == $element) {
                return true;
            }
        }
        return false;
    }

    $bemenet = $_POST['szo'];
    $szavak = explode(" ", $bemenet);

    $eredmeny = [];
    $eredmeny['tanar'] = [];
    for ($i = 0; $i < count($szavak); ++$i) {
        $szo = $szavak[$i];
        $sql = "SELECT id, name, username, image, description FROM users WHERE name LIKE '%{$szo}%' AND licensed=1 LIMIT 1;";

        $result = $conn->query($sql);


        while ($row = mysqli_fetch_assoc($result)) {

            $valami = [
                'id' => $row['id'],
                'name' => $row['name'],
                'username' => $row['username'],
                'image' => $row['image'],
                'description' => $row['description']
            ];
            if (kereses($eredmeny['tanar'], $valami) == false) {
                array_push($eredmeny['tanar'], $valami);
            }

        }

        //die($sql);
        die(json_encode($eredmeny, JSON_UNESCAPED_UNICODE));

    }
}
die('N');

