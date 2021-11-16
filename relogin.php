<!doctype html>
<html lang="en">
    <head>
         <!--Required meta tags-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

         <!--Bootstrap CSS-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

        <title>Formulario Seroprevalencia COVID-19 ISCI</title>
        <script src="https://d3js.org/d3.v6.min.js"></script>
        <link rel="stylesheet" href="mystyle.css">
    </head>
    <body>
        <?php
            include "navbar.php";
        ?>
		<br>
    	<div class="container">
            <form action="iniciarSesion2.php" method="post">
                <h2>Login</h2>
                <div class="border rounded border-primary" style="padding: 20px">
                    <?php
                        if (isset($_GET["error"])){
                            if ($_GET["error"]==1){
                                echo
                                '<div class="row" id="error">
                                    <div class="col-lg-4"></div>
                                    <div class="col-lg-4 alert alert-danger" role="alert">Nombre de usuario o contraseña incorrecto</div>
                                </div>';
                            }
                        }
                    ?>
                    <div class="row" id="error">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4 alert alert-danger" role="alert">La sesión ha expirado, la informacion ha sido guardada pero debe iniciar sesión nuevamente para que sea registrada.</div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <div class="labelInput">Usuario</div>
                            <input class="form-control" type="text" id="user" name="user" placeholder="Usuario" required="true" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <div class="labelInput">Contraseña</div>
                            <input class="form-control" type="password" id="pass" name="pass" placeholder="Contraseña" required="true" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row d-flex justify-content-center">
                        <input class="btn btn-danger" type="submit" value="Ingresar">
                    </div>
                </div>

            </form>
    	</div>
		 <!--Optional JavaScript-->
		 <!--jQuery first, then Popper.js, then Bootstrap JS-->
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    </body>
</html>