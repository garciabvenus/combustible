<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no">

    <link rel="stylesheet" href="css/Estilorutas.css">
    <title>Agua Gugar</title>

    <?php require "conexion.php"?>
    <script src="js/DevRutas.js" type="text/javascript" ></script>
    <?php
    date_default_timezone_set('America/Mexico_City');
    $fechaActual = date("d/m/Y");
    ?>

    <script>
        window.onload = function(){
            var fecha = new Date(); //Fecha actual
            var mes = fecha.getMonth()+1; //obteniendo mes
            var dia = fecha.getDate(); //obteniendo dia
            var ano = fecha.getFullYear(); //obteniendo aÃ±o
            if(dia<10)
                dia='0'+dia; //agrega cero si el menor de 10
            if(mes<10)
                mes='0'+mes //agrega cero si el menor de 10
            document.getElementById('fechaActual').value=ano+"-"+mes+"-"+dia;
        }
    </script>
</head>

<body>
    <h1>Compañia Industrial de Oaxaca S.A. de C.V. </h1>
    <table width="1000">
        <tr>
            <th align="Left">
                <form method="post" accept-charset="utf-8" enctype="multipart/form-data">
                    <a>Fecha de carga....</a>
                    <input type="date" name="fechacga" id="fechacga"  step="1" min="2013-01-01" max="2025-12-31" value="<?php echo date("Y-m-d");?>">

                    <input type="submit" name="Viscargas" id="IdViscargas" value="Mostrar" class="boton" /> </h1>
                </form>
            </th>
        </tr>
        <tr>
            <td>
                <form id="frmgridcgas" name="frmgridcgas" method="post" action="">
                    <?php

                    if(isset($_POST['Viscargas'])) {
                        $Fec_Cga=date("d/m/Y", strtotime($_POST["fechacga"]));
                        if ($Fec_Cga >= $fechaActual) {
                            //Validamos si hay cargas de el dia seleccionado
                            $sql="Select * From Cab_combustible where fecha= '$Fec_Cga'";
                            $res = odbc_exec($conn, $sql);
                            if (odbc_num_rows($res) <= 0) {
                                //Actualiza el detalle de liquidacion
                                $resultado=odbc_exec($conn,"{CALL dbo.CioSPPhp(".'Insertadiadecarga'.",".'0'.",".'0'.",".'0'.",".'0'.",".'0'.",".'0'.",'$Fec_Cga',".'0'.",".'0'.",".'0'.")}");
                                echo '<script language="javascript">alert("Datos actualizados para su captura");</script>';
                                }
                        }
                        else {
                            echo "No puede modificar fechas atrasadas";
                        }
                    }

                    ?>
                    <br>
                    <form id="frmcapcgas" name="frmcapcgas" method="post" action="">
                        <div class="datagrid">
                            <table id="TblDetgas">
                                <thead>
                                <tr>
                                    <th scope="col"><p>RUTA</p> </th>
                                    <th scope="col"><p>PLACAS</p> </th>
                                    <th scope="col"><p>#CHOFER</p></th>
                                    <th scope="col"><p>CHOFER</p></th>
                                    <th scope="col"><p>COMBUSTIBLE</p></th>
                                    <th scope="col"><p>KILOM</p></th>
                                    <th scope="col"><p>LITROS</p></th>
                                    <th scope="col"><p>IMPORTE</p></th>
                                    <th scope="col"><p>PCIO</p></th>
                                </tr>
                                </thead>
                                <?php
                                    $sql1= odbc_exec($conn,"Select Str(idpersonal)+' '+Nombre+' '+apell_paterno+' '+apell_materno As chofer From Cat_Personal where Activo='S' Order By Nombre  ");

                                    $sql= odbc_exec($conn,"Select Idsector,placas, idchofer,nombre+' '+apell_paterno+' '+apell_materno as chofer, des_combustible,kilometraje,litros,importe,precioxlitro from cab_combustible a
                                                                    inner join cat_personal b on b.idpersonal=a.idchofer
                                                                    inner join cat_combustibles c on c.idcombustible=a.idcombustible
                                                                    where fecha= '$Fec_Cga' order by idsector,placas ");

                                    while ($row = odbc_fetch_array($sql)) {
                                        echo " 
                                            <tbody>   
                                                <tr onclick=myFunction(this)>
                                                     <td>$row[Idsector]</td>
                                                     <td>$row[placas]</td>
                                                     <td>$row[idchofer]</td>
                                                     <td>$row[chofer]</td>
                                                     <td>$row[des_combustible]</td>
                                                     <td align=right><input type='text' id='Kilom' size='4' maxlength='8' value=$row[kilometraje] ></td>
                                                     <td align=right><input type='text' id='litros' size='4' maxlength='8' value=$row[litros] ></td>
                                                     <td align=right><input type='text' id='impte' size='4' maxlength='8' value=$row[importe] ></td>
                                                     <td><input type='text' id='precio' size='4' maxlength='8' value=$row[precioxlitro] ></td>
                                                     <td><button type='button' name='Guardar' id='Guardar' onClick='btnguardar();' ><img src='imagenes/Guardar.ico' alt='x' /> </button></td>
                                                </tr>
                                            </tbody>
                                            ";
                                    }
                                ?>
                            </table>
                        </div>
                    </form>
                </form>
            </td>
        </tr>
    </table>
</body>
</html>


