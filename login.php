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
            session_start();
            if (isset($_SESSION["user"])){
                header("Location: home.php");
            }
            include "navbar.php";
        ?>
		<br>
    	<div class="container">
            <form action="iniciarSesion.php" method="post">
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

                    <div class="form-group row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <div class="labelInput">Usuario</div>
                         </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <select id="user" name="user" class="form-select" required="true">
                                <option disabled="true" selected="true" value="">Seleccione un colegio </option>
                            </select>
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

        <script type="text/javascript">

            const colegios = ['COLEGIO SANTA MARIA DE SANTIAGO',
                   'COLEGIO INSTITUTO ALONSO DE ERCILLA',
                   'LICEO MUNICIPALIZADO AMANDA LABARCA',
                   'CENTRO EDUCACION MARIANO EGANA', 'COLEGIO SANTO CURA DE ARS',
                   'LICEO MALAQUIAS CONCHA', 'ESCUELA PARTICULAR TTE.DAGOBERTO GODOY',
                   'LICEO POLIV. ABDON CIFUENTES',
                   'ESCUELA SANTA VICTORIA DE HUECHURABA',
                   'LICEO NUESTRA SENORA DE LAS MERCEDES',
                   'INSTITUTO SAN PABLO MISIONERO', 'ESCUELA BARBARA KAST RIST',
                   'LICEO TALAGANTE', 'LICEO GABRIELA MISTRAL DE MELIPILLA',
                   'CENTRO EDUCACIONAL FERNANDO DE ARAGON',
                   'LICEO MONSENOR ENRIQUE ALVEAR',
                   'COLEGIO BICENTENARIO DE SANTA MARIA DE EL MONTE',
                   'COLEGIO MAYOR TOBALABA', 'COLEGIO SANTA CRUZ DE CHICUREO',
                   'LICEO BICENTENARIO DE EXCELENCIA PATRICIO MEKIS DE PADRE HURTADO',
                   'COLEGIO PARTICULAR ALICANTE', 'COLEGIO PARTICULAR NOVO MUNDO',
                   'COLEGIO JESUS SERVIDOR',
                   'ESCUELA SAN PEDRO VALLE GRANDE', 'COLEGIO SANTIAGO EMPRENDEDORES',
                   'COLEGIO ALICANTE DEL VALLE',
                   'LICEO ALTO CORDILLERA DE LA FLORIDA', 'LICEO DE ZAPALLAR',
                   'ESCUELA ESPANA', 'COLEGIO NUESTRA SENORA DEL HUERTO',
                   'LICEO BICENTENARIO COLEGIO PASIÓN DE JESÚS DE LIMACHE',
                   'ESCUELA BASICA BRASILIA', 'LICEO MATILDE BRANDAU DE ROSS',
                   'ESCUELA JOAQUIN EDWARDS BELLO', 'COLEGIO INTERNACIONAL',
                   'COLEGIO SAN IGNACIO', 'COLEGIO MARIA AUXILIADORA',
                   'ESCUELA MANTAGUA', 'COLEGIO GENERAL JOSE VELASQUEZ BORQUEZ',
                   'COLEGIO CARLOS ALESSANDRI ALTAMIRANO',
                   'COLEGIO PEOPLE HELP PEOPLE', 'COLEGIO CHAMPAGNAT',
                   'COLEGIO SAGRADA FAMILIA', 'COLEGIO VALLE DEL ACONCAGUA',
                   'LIONS SCHOOL', 'LICEO PART. MIXTO SAN FELIPE', 'COLEGIO GALILEO',
                   'COLEGIO SAN RAFAEL ARCANGEL', 'COLEGIO ALEMAN LOS ANGELES',
                   'COLEGIO MARINA DE CHILE', 'COLEGIO BICENTENARIO ESPAÑA',
                   'COLEGIO JUAN GREGORIO LAS HERAS',
                   'COLEGIO GALVARINO DE LOMAS COLORADAS',
                   'COLEGIO SANTA LUISA DE CONCEPCION',
                   'COLEGIO PARTICULAR TALCAHUANO',
                   'ESCUELA PARTICULAR QUEEN ELIZABETH SCHOOL',
                   'ESCUELA BASICA BELLAVISTA', 'ESCUELA BASICA THOMPSON MATTHEWS',
                   'COLEGIO PARTICULAR IGNACIO CARRERA PINTO', 'COLEGIO ARAUCO',
                   'LICEO CLAUDIO FLORES SOTO', 'LICEO GABRIELA MISTRAL',
                   'ESCUELA PARTICULAR TOQUI CAUPOLICAN',
                   'COLEGIO TERESIANO LOS ANGELES', 'COLEGIO CONCEPCION CHIGUAYANTE',
                   'COLEGIO CREACIÓN CONCEPCIÓN',
                   'INSTITUTO HUMANIDADES MONSEÑOR JOSE MANUEL SANTO ASCARZA',
                   'COLEGIO NUEVOS HORIZONTES', 'denis'];
            for (let i = 0; i < colegios.length; i++) {
                d3.select('#user').append('option').attr('value',colegios[i]).text(colegios[i]);
            }
        </script>


    </body>
</html>