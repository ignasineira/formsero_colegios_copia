<?php
    session_start();

    date_default_timezone_set('America/Santiago');

    if (!isset($_SESSION["lugar"])){
        $_SESSION['formData'] = $_POST;
        header("Location: relogin.php");
    }

    else{
        $receivedData = $_POST;

        if (!isset($_POST["VC19"])){
            if (isset($_SESSION['formData']))
                $receivedData = $_SESSION['formData'];
            else
                header("Location: home.php");
        }

        $filename = "CSVs/".$_SESSION["lugar"].date("d-m-Y").".csv";

        $header = ["IdForm", "Edad","Sexo",
                    "Curso","Comuna_recidencia",
                    "Ninguna","Obesidad","Hipertension","Diabetes","Cancer","Enf_res","Enf_cv",
                    "PCR_prev","PCR_prev_fecha",
                    "VacunaC19","MarcaVC19","FechaVC19","Dosis","Resultado",
                    "M_trans_1","Lugar","Dir_carro","Coor_carro","Colegio","T_transcurrido"];

        $ningu = isset($receivedData["comn"])+0;
        $obesi = isset($receivedData["como"])+0;
        $hiper = isset($receivedData["comh"])+0;
        $diabe = isset($receivedData["comd"])+0;
        $cance = isset($receivedData["comk"])+0;
        $enfre = isset($receivedData["comr"])+0;
        $enfcv = isset($receivedData["comc"])+0;

        $dosis = "";
        if ($receivedData["VC19"]==1)
            $dosis = $receivedData["dosis"];

        $fyh = date('d/m/Y H:i');
        $data = [$receivedData["id"],$receivedData["edad"],$receivedData["sexo"],
                $receivedData["curso"],$receivedData["comuna"],
                $ningu,$obesi,$hiper,$diabe,$cance,$enfre,$enfcv, 
                $receivedData["pcrant"],$receivedData["datePCR"],
                $receivedData["VC19"],$receivedData["marcaVacuna"],$receivedData["dateVac"],$dosis,$receivedData["rdt"],
                $receivedData["mdt1"],$fyh,$_SESSION["lugar"],$receivedData["DirCarro"],$receivedData["CoorCarro"],$_SESSION["user"],$receivedData["tiempo"]];

        if(!is_file($filename)){
            $fp = fopen($filename, 'w');
            fputcsv($fp, $header);
        }
        else{
            $fp = fopen($filename, "a");
        }

        fputcsv($fp, $data);

        fclose($fp);

        if(!is_file("CSVs/".$_SESSION["lugar"]."All.csv")){
            $fp2 = fopen("CSVs/".$_SESSION["lugar"]."All.csv", "a");
            fputcsv($fp2, $header);
        }
        else{
            $fp2 = fopen("CSVs/".$_SESSION["lugar"]."All.csv", "a");
        }
        fputcsv($fp2, $data);
        fclose($fp2);

        header("Location: exito.php");
    }

?>
