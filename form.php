<!doctype html>
<html lang="en">
    <head>
         <!--Required meta tags-->
        <meta charset="utf-8" name="theme-color" content="#999999" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

         <!--Bootstrap CSS-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

        <title>Formulario Seroprevalencia COVID-19 ISCI</title>
        <script src="https://d3js.org/d3.v6.min.js"></script>
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <link rel="stylesheet" href="mystyle.css">
        <!--Codigo que hace que los mapas funcionen-->
    </head>
    <body>
        <?php
            session_start();
            if (!isset($_SESSION["user"])){
                header("Location: login.php");
            }
            include "navbar.php";
        ?>
		<br>
    	<div class="container">
            <form action="cargarDatos.php" method="post" is="formSero">
            <div class="form-group row" style="margin-bottom: 10px">
                <div class="col-lg-12">
                    <h1>Código test:
                        <?php
                        if (isset($_GET["id"])){
                            $cod = "";
                            for ($i=strlen($_GET["id"]) ; $i<5; $i++){
                                $cod = $cod."0";
                            }
                            $cod = $cod. $_GET["id"];
                            echo $cod;
                        }
                        else
                            header("Location: index.php");
                        ?>
                    </h1>
                </div>
            </div>
            <div class="form-group row" style="margin-bottom: 10px">
                <div class="col-lg-6" style="display: flex; flex-flow: column;">
                    <h2>Tiempo transcurrido</h2>
                    <div class="border rounded border-primary" style="padding: 20px; flex: 1 1 auto;">
                        <div class="d-flex justify-content-center">
                            <h1 id="timer">00:00</h1>
                            <input id="tiempo" name="tiempo" type="hidden" value="0">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h2>Información del test</h2>
                    <div class="border rounded border-primary" style="padding: 20px">
                        <div class="form-group row" style="margin-bottom: 10px">
                            <label for="rdt" class="col-md-4 col-form-label">
                                <div class="labelInput d-inline-block">Resultado del test</div>
                            </label>
                            <div class="col-md-8">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="rdt" id="rdtn" value="negativo"> Negativo
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="rdt" id="rdtp" value="positivo" required="true"> Positivo
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="rdt" id="rdti" value="invalido"> Inválido
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <?php echo '<input type="hidden" name="id" value="'.$_GET["id"].'">'?>
                <input type="hidden" name="DirCarro" id="DirCarro" value="">
                <input type="hidden" name="CoorCarro" id="CoorCarro" value="">
				<h2>Información del alumno</h2>
                <div class="border rounded border-primary" style="padding: 20px">
					<div class="form-group row" style="margin-bottom: 10px">
						<label for="edad" class="col-md-2 col-form-label ">
							<div class="labelInput">Edad</div>
						</label>
						<div class="col-md-4">
							<input class="form-control" type="number" id="edad" name="edad" placeholder="Edad" min="0" max="100" required="true" autocomplete="off" onblur="revisarEdad(this)">
						</div>
						<label for="sexo" class="col-md-2 col-form-label ">
							<div class="labelInput d-inline-block">Sexo Biológico</div>
						</label>
						<div class="col-md-4">
							<div class="form-check form-check-inline">
								<label class="form-check-label">
									<input class="form-check-input" type="radio" name="sexo" id="sexom" value="M" required="true"> Mujer
								</label>
							</div>
							<div class="form-check form-check-inline">
								<label class="form-check-label">
									<input class="form-check-input" type="radio" name="sexo" id="sexoh" value="H"> Hombre
								</label>
							</div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="sexo" id="sexon" value="-"> No declarado
                                </label>
                            </div>
						</div>
					</div>

                    <div class="form-group row" style="margin-bottom: 10px">
                        <label for="Curso" class="col-md-2 col-form-label ">
                            <div class="labelInput">Curso</div>
                        </label>
                        <div class="col-md-4">
                            <select id="curso" name="curso" class="form-select" required="true">
                                <option disabled="true" selected="true" value="">Seleccione un curso</option>
                            </select>
                        </div>
                        <label for="comuna" class="col-md-2 col-form-label ">
                            <div class="labelInput d-inline-block">Comuna de Residencia</div>
                        </label>
            
                        <div class="col-md-4">
                            <select id="comuna" name="comuna" class="form-select" required="true">
                                <option disabled="true" selected="true" value="">Seleccione una comuna </option>
                            </select>
                            
                        </div>
                    </div>
                   
                    <div class="form-group row" style="margin-bottom: 10px">
                        <label for="com" class="col-md-2 col-form-label ">
                            <div class="labelInput d-inline-block">Historial Médico</div>
                        </label>
                        <div class="col-md-10">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="comn" id="comn" onchange="checkHM('si')" checked> Ninguna
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="como" id="como" onchange="checkHM('no')"> Obesidad
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="comh" id="comh" onchange="checkHM('no')"> Hipertensión
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="comd" id="comd" onchange="checkHM('no')"> Diabetes
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="comk" id="comk" onchange="checkHM('no')"> Cáncer
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="comr" id="comr" onchange="checkHM('no')"> Enfermedad respiratoria
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="comc" id="comc" onchange="checkHM('no')"> Enfermedad cardiovascular
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row" style="margin-bottom: 10px">

                        <label for="pcrant" class="col-md-2 col-form-label ">
                            <div class="labelInput d-inline-block">PCR Previo</div>
                        </label>
                        <div class="col-md-4">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="pcrant" id="pcrantpos" value="Pos" required="true"> Positivo
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="pcrant" id="pcrantneg" value="Neg"> Negativo
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="pcrant" id="pcrantno" value="No"> No realizado
                                </label>
                            </div>
                            <div>
                                <input class="form-control" type="date" name="datePCR" id="datePCR" max="today">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row" style="margin-bottom: 10px">
                        <div class="form-group row" style="margin-bottom: 10px">
                            <label for="VC19" class="col-md-2 col-form-label ">
                                <div class="labelInput d-inline-block">Vacunado contra COVID-19</div>
                            </label>
                            <div class="col-md-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="VC19" value="1" required="true" onchange="vacuna(true)"> Sí
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="VC19" value="0" onchange="vacuna(false)"> No
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div id="ddosis" style="display: none">
                                    <div style="width: 30%">
                                        <select class="form-select" id="marcaVacuna" onchange="dosis(this)" name="marcaVacuna">
                                            <option disabled selected value="">Seleccione una marca</option>
                                            <option value="Sinovac"  >Sinovac</option>
                                            <option value="Pfizer">Pfizer</option>
                                            <option value="Astra-Zeneca">Astra-Zeneca</option>
                                            <option value="CanSino">CanSino</option>
                                            <option value="Otra">Otra</option>
                                        </select>
                                    </div>
                                   <div style="width: 30%; padding-left: 10px">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" id="dosis_unica" type="radio" name="dosis" value="unica" > Dosis única
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input"    type="radio" name="dosis" value="primera"> Primera dosis
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="dosis" value="segunda"> Segunda dosis
                                            </label>
                                        </div>
                                    </div>
                                    <div style="width: 30%">
                                        <input class="form-control" type="date" name="dateVac" id="dateVac" max="today">
                                    </div>
                                </div>
                            </div>
                
                    <div class="form-group row" style="margin-bottom: 10px">
                        <label for="mdt1" class="col-md-2 col-form-label ">
                            <div class="labelInput d-inline-block">Medio de transporte al colegio</div>
                        </label>
                        <div class="col-md-10 table-responsive">
                            <div style="display: flex">
                                <select id="mdt1" name="mdt1" class="form-select" required="true" style="width: 50%;">
                                    <option disabled="true" selected="true" value="">Seleccione una opción</option>
                                    <option value="Bicicleta">Bicicleta</option>
                                    <option value="Caminata">Caminata</option>
                                    <option value="Metro">Público</option>
                                    <option value="Scooter">Scooter</option>
                                    <option value="Taxi/Colectivo">Taxi/Colectivo</option>
                                    <option value="Vehículo">Vehículo</option>
                                    <option value="Caballo/tracción animal">Caballo/tracción animal</option>
                                </select>
                    </div>

                    
				</div>


    	</div>

        <br>

        <div class="form-group row d-flex justify-content-center">
            <input class="btn btn-danger" type="submit" value="Enviar" style="width: 80px">
        </div>

        <br>

        </form>


    	<script type="text/javascript">
            let baseSenama;
            d3.csv('CSVs/baseSenama.csv').then(d => baseSenama = proccessData(d));


            function proccessData(data){
                console.log(data);
                let nd = {};
                for (let i=0; i<data.length; i++){
                    nd[data[i]['rut']] = data[i];
                }
                return nd
            }


            let mt = 1;

            window.onload = startTimer();

            window.addEventListener('keydown',function(e){
                if(e.keyIdentifier=='U+000A'||e.keyIdentifier=='Enter'||e.keyCode==13){
                    if(e.target.nodeName=='INPUT'&&e.target.type=='text'){
                        if (e.target.name == "dirr"){
                            document.getElementById("submit").click();
                        }
                        else if (e.target.name == "dirt"){
                            document.getElementById("submit2").click();
                        }
                        e.preventDefault();
                        return false;
                    }
                }
            },true);

            function play() {
                var audio = new Audio(
                    'data:audio/wav;base64,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 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////VEFHAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAU291bmRib3kuZGUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMjAwNGh0dHA6Ly93d3cuc291bmRib3kuZGUAAAAAAAAAACU=');
                let p = 0;
                audio.play();
                let int = setInterval(function(){
                    p++;
                    audio.play();
                    if (p == 2){
                        clearInterval(int);
                    }
                },500);
            }

            function startTimer(){
                let time = 0;
                let s = 0;
                let m = 0;
                let interval = setInterval(function(){
                    time++;
                    s = time%60;
                    m = parseInt(time/60);
                    sep = ":";
                    if (s<10)
                        sep = ":0";
                    d3.select("#timer").text(m+sep+s);
                    d3.select("#tiempo").attr("value",time);
                    if (time == 900){
                        d3.select("#timer").style("color","red");
                        play();
                        navigator.vibrate([300, 300, 300]);
                        document.title = "¡Muestra lista!";
                    }
                },1000);
            }
			const paises = ["CHILE","AFGANISTAN","ALBANIA","ALEMANIA","ANDORRA","ANGOLA","ANGUILLA","ANTIGUA Y BARBUDA","ANTILLAS HOLANDESAS","ARABIA SAUDI","ARGELIA","ARGENTINA","ARMENIA","ARUBA","AUSTRALIA","AUSTRIA","AZERBAIYAN","BAHAMAS","BAHREIN","BANGLADESH","BARBADOS","BELARUS","BELGICA","BELICE","BENIN","BERMUDAS","BHUTÁN","BOLIVIA","BOSNIA Y HERZEGOVINA","BOTSWANA","BRASIL","BRUNEI","BULGARIA","BURKINA FASO","BURUNDI","CABO VERDE","CAMBOYA","CAMERUN","CANADA","CHAD","CHINA","CHIPRE","COLOMBIA","COMORES","CONGO","COREA","COREA DEL NORTE ","COSTA DE MARFIL","COSTA RICA","CROACIA","CUBA","DINAMARCA","DJIBOUTI","DOMINICA","ECUADOR","EGIPTO","EL SALVADOR","EMIRATOS ARABES UNIDOS","ERITREA","ESLOVENIA","ESPAÑA","ESTADOS UNIDOS DE AMERICA","ESTONIA","ETIOPIA","FIJI","FILIPINAS","FINLANDIA","FRANCIA","GABON","GAMBIA","GEORGIA","GHANA","GIBRALTAR","GRANADA","GRECIA","GROENLANDIA","GUADALUPE","GUAM","GUATEMALA","GUAYANA FRANCESA","GUERNESEY","GUINEA","GUINEA ECUATORIAL","GUINEA-BISSAU","GUYANA","HAITI","HONDURAS","HONG KONG","HUNGRIA","INDIA","INDONESIA","IRAN","IRAQ","IRLANDA","ISLA DE MAN","ISLA NORFOLK","ISLANDIA","ISLAS ALAND","ISLAS CAIMÁN","ISLAS COOK","ISLAS DEL CANAL","ISLAS FEROE","ISLAS MALVINAS","ISLAS MARIANAS DEL NORTE","ISLAS MARSHALL","ISLAS PITCAIRN","ISLAS SALOMON","ISLAS TURCAS Y CAICOS","ISLAS VIRGENES BRITANICAS","ISLAS VÍRGENES DE LOS ESTADOS UNIDOS","ISRAEL","ITALIA","JAMAICA","JAPON","JERSEY","JORDANIA","KAZAJSTAN","KENIA","KIRGUISTAN","KIRIBATI","KUWAIT","LAOS","LESOTHO","LETONIA","LIBANO","LIBERIA","LIBIA","LIECHTENSTEIN","LITUANIA","LUXEMBURGO","MACAO","MACEDONIA ","MADAGASCAR","MALASIA","MALAWI","MALDIVAS","MALI","MALTA","MARRUECOS","MARTINICA","MAURICIO","MAURITANIA","MAYOTTE","MEXICO","MICRONESIA","MOLDAVIA","MONACO","MONGOLIA","MONTENEGRO","MONTSERRAT","MOZAMBIQUE","MYANMAR","NAMIBIA","NAURU","NEPAL","NICARAGUA","NIGER","NIGERIA","NIUE","NORUEGA","NUEVA CALEDONIA","NUEVA ZELANDA","OMAN","OTROS PAISES","PAISES BAJOS","PAKISTAN","PALAOS","PALESTINA","PANAMA","PAPUA NUEVA GUINEA","PARAGUAY","PERU","POLINESIA FRANCESA","POLONIA","PORTUGAL","PUERTO RICO","QATAR","REINO UNIDO","REP.DEMOCRATICA DEL CONGO","REPUBLICA CENTROAFRICANA","REPUBLICA CHECA","REPUBLICA DOMINICANA","REPUBLICA ESLOVACA","REUNION","RUANDA","RUMANIA","RUSIA","SAHARA OCCIDENTAL","SAMOA","SAMOA AMERICANA","SAN BARTOLOME","SAN CRISTOBAL Y NIEVES","SAN MARINO","SAN MARTIN (PARTE FRANCESA)","SAN PEDRO Y MIQUELON ","SAN VICENTE Y LAS GRANADINAS","SANTA HELENA","SANTA LUCIA","SANTA SEDE","SANTO TOME Y PRINCIPE","SENEGAL","SERBIA","SEYCHELLES","SIERRA LEONA","SINGAPUR","SIRIA","SOMALIA","SRI LANKA","SUDAFRICA","SUDAN","SUECIA","SUIZA","SURINAM","SVALBARD Y JAN MAYEN","SWAZILANDIA","TADYIKISTAN","TAILANDIA","TANZANIA","TIMOR ORIENTAL","TOGO","TOKELAU","TONGA","TRINIDAD Y TOBAGO","TUNEZ","TURKMENISTAN","TURQUIA","TUVALU","UCRANIA","UGANDA","URUGUAY","UZBEKISTAN","VANUATU","VENEZUELA","VIETNAM","WALLIS Y FORTUNA","YEMEN","ZAMBIA","ZIMBABWE"];
			for (let i = 0; i < paises.length; i++) {
				d3.select('#nac').append('option').attr('value',paises[i]).text(paises[i]);
			}

            const comunas = ['ALGARROBO', 'ALHUÉ', 'ANTUCO', 'ARAUCO', 'BUIN', 'CABILDO',
                               'CABRERO', 'CALERA', 'CALERA DE TANGO', 'CALLE LARGA', 'CARTAGENA',
                               'CASABLANCA', 'CATEMU', 'CAÑETE', 'CERRILLOS', 'CERRO NAVIA',
                               'CHIGUAYANTE', 'COLINA', 'CONCEPCIÓN', 'CONCHALÍ', 'CONCÓN',
                               'CONTULMO', 'CORONEL', 'CURACAVÍ', 'CURANILAHUE', 'EL BOSQUE',
                               'EL MONTE', 'EL QUISCO', 'EL TABO', 'ESTACIÓN CENTRAL', 'FLORIDA',
                               'HIJUELAS', 'HUALPÉN', 'HUALQUI', 'HUECHURABA', 'INDEPENDENCIA',
                               'ISLA DE MAIPO', 'ISLA DE PASCUA', 'LA CISTERNA', 'LA CRUZ',
                               'LA FLORIDA', 'LA GRANJA', 'LA LIGUA', 'LA PINTANA', 'LA REINA',
                               'LAJA', 'LAMPA', 'LAS CONDES', 'LEBU', 'LIMACHE', 'LLAILLAY',
                               'LO BARNECHEA', 'LO ESPEJO', 'LO PRADO', 'LOS ANDES', 'LOS ÁLAMOS',
                               'LOS ÁNGELES', 'LOTA', 'MACUL', 'MAIPÚ', 'MARÍA PINTO',
                               'MELIPILLA', 'MULCHÉN', 'NACIMIENTO', 'NEGRETE', 'NOGALES',
                               'OLMUÉ', 'PADRE HURTADO', 'PAINE', 'PANQUEHUE', 'PAPUDO',
                               'PEDRO AGUIRRE CERDA', 'PENCO', 'PETORCA', 'PEÑAFLOR', 'PEÑALOLÉN',
                               'PIRQUE', 'PROVIDENCIA', 'PUCHUNCAVÍ', 'PUDAHUEL', 'PUENTE ALTO',
                               'PUTAENDO', 'QUILACO', 'QUILICURA', 'QUILLECO', 'QUILLOTA',
                               'QUILPUÉ', 'QUINTA NORMAL', 'QUINTERO', 'RECOLETA', 'RENCA',
                               'RINCONADA', 'SAN ANTONIO', 'SAN BERNARDO', 'SAN ESTEBAN',
                               'SAN FELIPE', 'SAN JOAQUÍN', 'SAN JOSÉ DE MAIPO', 'SAN MIGUEL',
                               'SAN PEDRO DE LA PAZ', 'SAN RAMÓN', 'SAN ROSENDO', 'SANTA BÁRBARA',
                               'SANTA JUANA', 'SANTA MARÍA', 'SANTIAGO', 'SANTO DOMINGO',
                               'TALAGANTE', 'TALCAHUANO', 'TILTIL', 'TIRÚA', 'TOMÉ', 'TUCAPEL',
                               'VALPARAÍSO', 'VILLA ALEMANA', 'VITACURA', 'VIÑA DEL MAR',
                               'YUMBEL', 'ZAPALLAR', 'ÑUÑOA',"Otra"];
			const comunas2 = ["Cerrillos","Cerro Navia","Conchalí","El Bosque","Estación Central","Huechuraba","Independencia",
				"La Cisterna","La Florida","La Granja","La Pintana","La Reina","Las Condes","Lo Barnechea","Lo Espejo","Lo Prado","Macul","Maipú",
				"Ñuñoa","Padre Hurtado","Pedro Aguirre Cerda","Peñalolén","Pirque","Providencia","Pudahuel","Puente Alto","Quilicura","Quinta Normal",
				"Recoleta","Renca","San Bernardo","San Joaquín","San José de Maipo","San Miguel","San Ramón","Santiago","Otra"];
			for (let i = 0; i < comunas.length; i++) {
				d3.select('#comuna').append('option').attr('value',comunas[i]).text(comunas[i]);
			}

			const colegios =['COLEGIO SANTA MARIA DE SANTIAGO',
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
                   'ESCUELA ESPANA', 'COL.NTRA.SEÑORA DEL HUERTO',
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
                   'COLEGIO NUEVOS HORIZONTES'];
			for (let i = 0; i < colegios.length; i++) {
				d3.select('#colegio').append('option').attr('value',colegios[i]).text(colegios[i]);
			}

			const cursos = ["Pre-Kinder","Kinder","1° Básico","2° Básico","3° Básico","4° Básico","5° Básico","6° Básico","7° Básico","8° Básico",
					"1° Medio","2° Medio", "3° Medio", "4° Medio"];
			for (let i = 0; i < cursos.length; i++) {
				d3.select('#curso').append('option').attr('value',cursos[i]).text(cursos[i]);
			}

			function revisarEdad(sender){
    			if (sender.value<0){
    				sender.value=0;
				}
				else if (sender.value>100){
					sender.value=100;
				}
			}
			function mostrarmapa(sender) {
                if (sender.value=="si"){
                    d3.select("#maptra").style("display","block");
                    d3.select("#address2").attr("required",true);
                }
                else {
                    d3.select("#maptra").style("display","none");
                    d3.select("#address2").attr("required",null).property("value","");
                    d3.select("#coot").attr("value","");
                }
            }
			function agregar() {
                mt++;
                d3.select("#dmdt"+mt).style("display","flex");
                d3.select("#mdt"+mt).attr("required",true);
                d3.select("#frec"+mt).attr("required",true);
                d3.select("#bqu").style("display","inline-block");
                if (mt>=3){
                    d3.select("#bag").style("display","none");
                }
            }
			function quitar() {
                d3.select("#dmdt"+mt).style("display","none");
                d3.select("#mdt"+mt).attr("required",null);
                d3.select("#frec"+mt).attr("required",null);
                d3.select("#bag").style("display","inline-block");
                mt--;
                if (mt<=1){
                    d3.select("#bqu").style("display","none");
                }
            }
			function checkHM(sacar) {
                if (sacar=="si"){
                    d3.select("#como").property("checked",false);
                    d3.select("#comh").property("checked",false);
                    d3.select("#comd").property("checked",false);
                    d3.select("#comk").property("checked",false);
                    d3.select("#comr").property("checked",false);
                    d3.select("#comc").property("checked",false);
                }
                else{
                    d3.select("#comn").property("checked",false);
                }
            }
            function vacuna(vacuna){
                if (vacuna){
                    d3.select("#ddosis").style("display","flex");
                    d3.select("#dosis").attr("required", true);
                    d3.select("#marcaVacuna").attr("required", true);
                    d3.select("#dateVac").attr("required", true);
                }
                else {
                    d3.select("#ddosis").style("display", "none");
                    d3.select("#dosis").attr("required", null).property('checked',true);
                    d3.select("#dosis").property('checked',false);
                    d3.select("#marcaVacuna").attr("required", null);
                    d3.select("#dateVac").attr("required", null);
                }
            }

            function dosis(sender){
                
                if(sender=='Sinovac'){
                    
                    d3.select("#dosis_unica").property("disabled",false);
                }
                else{
                     d3.select("#dosis_unica").property("disabled",true);
                }

            }

            

			function buscarRut(){
			    let rutin = d3.select('#rut');
                let value = rutin.property('value');
                if (baseSenama[value]){
                    rutin.attr('class','form-control is-valid');
                    d3.select('#nombre').attr('value',baseSenama[value]['nombre']);
                    d3.select('#edad').attr('value',baseSenama[value]['edad']);
                    if (baseSenama[value]['sexo']=='H'){
                        d3.select('#sexoh').attr('checked',true);
                    }
                    else {
                        d3.select('#sexom').attr('checked',true);
                    }
                }
                else{
                    rutin.attr('class','form-control is-invalid');
                    d3.select('#nombre').attr('value','');
                    d3.select('#edad').attr('value','');
                    d3.select('#sexoh').attr('checked',null);
                    d3.select('#sexom').attr('checked',null);
                }
            }
    	</script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    </body>
</html>
