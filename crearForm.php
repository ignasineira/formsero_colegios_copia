<?php
    session_start();
    if (!isset($_SESSION["user"])){
        header("Location: login.php");
    }
    $rows = file('formularios.csv');
    $last_row = array_pop($rows);
    $data = str_getcsv($last_row);
    $nid = $data[0]+1;
    $forms = fopen("formularios.csv", 'w');
    fwrite($forms, $nid);
    fclose($forms);
    header("Location: form.php?id=".$nid);
?>