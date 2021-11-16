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
        <style>
            .graph{
                width: 100%;
                min-width: 500px;
            }
            .row{
                padding-bottom: 50px;
            }
        </style>
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
<!--            <div class="row" style="overflow: auto">-->
<!--                <div class="col-lg-12" align="center">-->
<!--                    <h6>Reportes en:</h6>-->
<!--                    <div class="form-check form-check-inline">-->
<!--                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="porcentaje" checked onchange="cambiarReporte(this)">-->
<!--                        <label class="form-check-label" for="inlineRadio1">Porcentajes</label>-->
<!--                    </div>-->
<!--                    <div class="form-check form-check-inline">-->
<!--                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="cantidad" onchange="cambiarReporte(this)">-->
<!--                        <label class="form-check-label" for="inlineRadio2">Cantidades</label>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
            <div class="row" style="overflow: auto">
                <div class="col-lg-12" align="center">
                    <h2>Población comunas de servicio de salud y tests utilizados</h2>
                    <svg class="graph" id="graph1"></svg>
                </div>
            </div>
            <div class="row" style="overflow: auto">
                <div class="col-lg-12" align="center">
                    <h2>Top 6 comunas mas testeadas</h2>
                    <svg class="graph" id="graph2"></svg>
                </div>
            </div>
    	</div>
		 <!--Optional JavaScript-->
		 <!--jQuery first, then Popper.js, then Bootstrap JS-->
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script type="application/javascript">
        const servSalud = '<?php echo $_SESSION['lugar']; ?>';
        // const servSalud = "Chiloe";
        let fileName = servSalud+'All.csv';

        const showComunas = 6;

        let processedData, dataComunasSS, dataComunasTests, comunasSS, AllComunas;

        const locale = d3.formatLocale({
            decimal: ",",
            thousands: ".",
            grouping: [3],
            currency: ["", "\u00a0€"],
            minus: "\u2212",
            percent: "\u202f%"
        });

        Promise
            .all([
                d3.csv('CSVs/'+fileName),
                d3.csv('CSVs/comunasServSalud.csv')
            ])
            .then(resolve => createGraph(resolve));


        function createGraph(rawData){
            processedData = getDataComunas(rawData,servSalud);
            dataComunasSS = processedData[0];
            dataComunasTests = processedData[1];
            comunasSS = processedData[2];
            AllComunas = processedData[3];

            console.log(dataComunasTests)
            console.log(dataComunasSS)

            doubleBarGraph('#graph1',dataComunasSS,comunasSS,'PORCENTAJE','porTest');
            barGraph('#graph2',dataComunasTests.slice(0,showComunas),AllComunas.slice(0,showComunas),'nTest');

        }

        function doubleBarGraph(idsvg,data,axisLabel,y1,y2){
            let svg = d3.select(idsvg).html('');
            const svgWidth = svg.style('width').slice(0, -2);
            const svgHeight = svgWidth/1.6;
            svg.style('height',svgHeight);

            const marginX = Math.min((svgWidth/10),70);
            const marginY = Math.min((svgHeight/10),40);

            const graphWidth = svgWidth - 2 * marginX;
            const graphHeight = svgHeight - 2 * marginY;

            let yTotal = 0
            for(i in data){
                if (typeof  data[i][y1] == "string")
                    yTotal += parseInt(data[i][y1]);
                else
                    yTotal += data[i][y1]+0;
            }

            /// PRIMER GRAFICO

            let all = svg.append('g').attr('transform','translate('+marginX+','+marginY+')');

            let xScale = d3.scaleLinear().range([0, graphWidth]).domain([0,data.length+1]);
            let yScale = d3.scaleLinear().range([graphHeight, 0]).domain([0,1]); //yTotal]);

            let labelFormat = ".0%"
            if (yTotal>1){
                labelFormat = ","
            }

            let xAxis = d3.axisBottom()
                .scale(xScale)
                .ticks(data.length+1)
                .tickFormat(function (d,i) {
                    return axisLabel[i-1];
                });

            let yAxis = d3.axisLeft()
                .scale(yScale)
                .tickFormat(d3.format(labelFormat));

            all.append("g")
                .attr("class", "axis")
                .attr("transform", "translate(0," + graphHeight + ")")
                .call(xAxis);

            all.append("g")
                .attr("class", "axis")
                .call(yAxis);

            let labelFontSize = 15;

            all.append('text')
                .attr('transform','rotate(-90)')
                .attr('y', - marginX + labelFontSize)
                .attr('x',-yScale(yTotal/2))
                .attr('font-size',labelFontSize)
                .style('text-anchor','middle')
                .text('Porcentaje del total');


            all.append('text')
                .attr('x',xScale((data.length+1)/2))
                .attr('y', graphHeight + marginY)
                .attr('font-size',labelFontSize)
                .style('text-anchor','middle')
                .text('Comuna');

            let gBars = all.selectAll('g .bars')
                .data(data)
                .enter().append('g')
                .attr('class','gBars');

            gBars.append('rect')
                .attr('class','dTest')
                .attr('height', d => graphHeight-yScale(d[y1]))
                .attr('width',graphWidth*0.05)
                .attr('x', (d,i) => xScale(i+1) - graphWidth*0.025)
                .attr('y', d => yScale(d[y1]))
                .attr('transform','translate('+(-graphWidth*0.025)+',0)')
                .style('rx',3)
                .style('fill','#007bff');

            let barFormat = ".1~%"
            if (yTotal>1){
                barFormat = ","
            }

            gBars.append('text')
                .attr('class','labelTest')
                .attr('x', (d,i) => xScale(i+1))
                .attr('y', d => yScale(d[y1]) - 5)
                .attr('transform','translate('+(-graphWidth*0.025)+',0)')
                .attr('font-size',Math.max(graphWidth*0.015,8))
                .style('font-weight','bold')
                .style('text-anchor','middle')
                .text(d => d3.format(barFormat)(d[y1]));

            gBars.append('rect')
                .attr('class','dTest')
                .attr('height', d => graphHeight-yScale(d[y2]))
                .attr('width',graphWidth*0.05)
                .attr('x', (d,i) => xScale(i+1) - graphWidth*0.025)
                .attr('y', d => yScale(d[y2]))
                .attr('transform','translate('+(graphWidth*0.025)+',0)')
                .style('rx',3)
                .style('fill','#dc3545');

            gBars.append('text')
                .attr('class','labelTest')
                .attr('x', (d,i) => xScale(i+1))
                .attr('y', d => yScale(d[y2]) - 5)
                .attr('transform','translate('+(graphWidth*0.025)+',0)')
                .attr('font-size',Math.max(graphWidth*0.015,8))
                .style('font-weight','bold')
                .style('text-anchor','middle')
                .text(d => d3.format(barFormat)(d[y2]));

            // Leyenda
            all.append('rect')
                .attr('width',10)
                .attr('height',10)
                .attr('x',graphWidth-labelFontSize*5 - 20)
                .attr('y',0 - 10)
                .style('fill','#007bff');

            all.append('rect')
                .attr('width',10)
                .attr('height',10)
                .attr('x',graphWidth-labelFontSize*5 - 20)
                .attr('y',20 - 10)
                .style('fill','#dc3545');

            all.append('text')
                .attr('width',10)
                .attr('height',10)
                .attr('x',graphWidth-labelFontSize*5)
                .attr('y',0)
                .attr('font-size',labelFontSize)
                .text('Habitantes');

            all.append('text')
                .attr('width',10)
                .attr('height',10)
                .attr('x',graphWidth-labelFontSize*5)
                .attr('y',20)
                .attr('font-size',labelFontSize)
                .text('Tests realizados');
        }

        function barGraph(idsvg,data,axisLabel,y){
            let svg = d3.select(idsvg).html('');
            const svgWidth = svg.style('width').slice(0, -2);
            const svgHeight = svgWidth/1.6;
            svg.style('height',svgHeight);

            const marginX = Math.min((svgWidth/10),70);
            const marginY = Math.min((svgHeight/10),40);

            const graphWidth = svgWidth - 2 * marginX;
            const graphHeight = svgHeight - 2 * marginY;

            let yTotal = 0
            for(i in data){
                yTotal += data[i][y];
            }

            /// PRIMER GRAFICO

            let all = svg.append('g').attr('transform','translate('+marginX+','+marginY+')');

            let xScale = d3.scaleLinear().range([0, graphWidth]).domain([0,data.length+1]);
            let yScale = d3.scaleLinear().range([graphHeight, 0]).domain([0,yTotal]);

            let xAxis = d3.axisBottom()
                .scale(xScale)
                .ticks(data.length+1)
                .tickFormat(function (d,i) {
                    return axisLabel[i-1];
                });

            let labelFormat = ".0%"
            if (yTotal>1){
                labelFormat = ",d"
            }

            let yAxis = d3.axisLeft()
                .scale(yScale)
                .tickFormat(d3.format(labelFormat));

            all.append("g")
                .attr("class", "axis")
                .attr("transform", "translate(0," + graphHeight + ")")
                .call(xAxis);

            all.append("g")
                .attr("class", "axis")
                .call(yAxis);

            let labelFontSize = 15;

            all.append('text')
                .attr('transform','rotate(-90)')
                .attr('y', - marginX + labelFontSize)
                .attr('x',-yScale(yTotal/2))
                .attr('font-size',labelFontSize)
                .style('text-anchor','middle')
                .text('Cantidad de tests');


            all.append('text')
                .attr('x',xScale((data.length+1)/2))
                .attr('y', graphHeight + marginY)
                .attr('font-size',labelFontSize)
                .style('text-anchor','middle')
                .text('Comuna');

            let gBars = all.selectAll('g .bars')
                .data(data)
                .enter().append('g')
                .attr('class','gBars');

            gBars.append('rect')
                .attr('class','dTest')
                .attr('height', d => graphHeight-yScale(d[y]))
                .attr('width',graphWidth*0.05)
                .attr('x', (d,i) => xScale(i+1) - graphWidth*0.025)
                .attr('y', d => yScale(d[y]))
                .style('rx',3)
                .style('fill','#dc3545');

            let barFormat = ".1~%"
            if (yTotal>1){
                barFormat = ",d"
            }

            gBars.append('text')
                .attr('class','labelTest')
                .attr('x', (d,i) => xScale(i+1))
                .attr('y', d => yScale(d[y]) - 5)
                .attr('font-size',Math.max(graphWidth*0.015,8))
                .style('font-weight','bold')
                .style('text-anchor','middle')
                .text(d => d3.format(barFormat)(d[y]));

        }


        function getDataComunas(data,ss){
            /// Filtrar por servicio de salud
            let comunasServSalud = data[1].filter(d => d.IDISCI == ss);

            /// Calcular total
            let total = 0;
            for (i in comunasServSalud){
                total += parseInt(comunasServSalud[i].TOTAL_PERSONAS);
            }

            let porTests = getPorTest(data[0]);
            /// Agregar propiedades
            for (i in comunasServSalud){
                comunasServSalud[i]['PORCENTAJE'] = comunasServSalud[i].TOTAL_PERSONAS/total;

                if (porTests[comunasServSalud[i]['COMUNA']]){
                    comunasServSalud[i]['nTest'] = porTests[comunasServSalud[i]['COMUNA']]['nTest'];
                    comunasServSalud[i]['porTest'] = porTests[comunasServSalud[i]['COMUNA']]['porTest'];
                }
                else {
                    comunasServSalud[i]['nTest'] = 0;
                    comunasServSalud[i]['porTest'] = 0;
                }
            }

            let arrayPorTests = [];
            for (i in porTests){
                arrayPorTests.push({
                    'COMUNA': i,
                    'nTest': porTests[i]['nTest'],
                    'porTest': porTests[i]['porTest']
                });
            }
            arrayPorTests.sort((a,b) => (a.nTest > b.nTest) ? -1 : ((b.nTest > a.nTest) ? 1 : 0));
            comunasServSalud.sort((a,b) => (parseInt(a.TOTAL_PERSONAS) > parseInt(b.TOTAL_PERSONAS)) ? -1 : ((parseInt(b.TOTAL_PERSONAS) > parseInt(a.TOTAL_PERSONAS)) ? 1 : 0));
            let listaComunas = comunasServSalud.map(a => a['COMUNA']);
            let listaAllComunas = arrayPorTests.map(a => a['COMUNA']);
            return [comunasServSalud,arrayPorTests,listaComunas,listaAllComunas];
        }

        function getPorTest(data){
            let result = {};
            for (let i=0; i < data.length; i++){
                if (result[data[i].Comuna_dom.toUpperCase()])
                    result[data[i].Comuna_dom.toUpperCase()] +=1;
                else
                    result[data[i].Comuna_dom.toUpperCase()] = 1
            }
            let finalResult = {}
            for (i in result){
                finalResult[i] = { 'nTest': result[i], 'porTest': result[i]/data.length }
            }
            return finalResult;
        }

        // function cambiarReporte(input){
        //     if(input.value=='porcentaje'){
        //         doubleBarGraph('#graph1',dataComunasSS,comunasSS,'PORCENTAJE','porTest');
        //         barGraph('#graph2',dataComunasTests.slice(0,showComunas),AllComunas.slice(0,showComunas),'porTest');
        //     }
        //     else{
        //         doubleBarGraph('#graph1',dataComunasSS,comunasSS,'TOTAL_PERSONAS','nTest');
        //         barGraph('#graph2',dataComunasTests.slice(0,showComunas),AllComunas.slice(0,showComunas),'nTest');
        //     }
        //
        // }

    </script>
    </body>
</html>