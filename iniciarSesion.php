<?php
    if (isset($_POST["user"])){
        $usuarios = array_map('str_getcsv', file('usuarios.csv'));
        array_walk($usuarios, function(&$a) use ($usuarios) {
            $a = array_combine($usuarios[0], $a);
        });
        array_shift($usuarios);
        $error = true;
        foreach ($usuarios as $u){
            if ($u["user"]==$_POST["user"] && $u["pass"]==$_POST["pass"]){
                $error = false;
                session_start();
                $_SESSION["user"]=$u["user"];
                $_SESSION["lugar"]=$u["lugar"];
                header("Location: home.php");
            }
        }
        if ($error)
            header("Location: login.php?error=1");
    }
    else
        header("Location: login.php?error=1");
?>