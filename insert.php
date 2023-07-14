<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> 
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="../css/icons/fontawesome/font-awesome.min.css" rel="stylesheet" />
        <link href="../css/font-awesome.min.css" rel="stylesheet">
        <link href="../js/jquery.bxslider/jquery.bxslider.css" rel="stylesheet" />
        <link href="../js/jquery.master/masterslider.css" rel="stylesheet" />
        <link href="../css/style.css" rel="stylesheet" />
    </head>
    <?php
    //error_reporting(E_ALL);
    //error_reporting(-1);
    //error_reporting(E_ALL);
    //ini_set('display_errors', '1');


    include_once ("clases/mysql_connection.php");
    include_once ("clases/mysqlCommand.php");
    include_once ("clases/mssqlCommand.php");
    include_once ("clases/mssql_connection.php");
    include_once ("db_params.php");
    include_once ("correo/correo.php");

    $n= $_POST['nombre'];
    $correoper= $_POST['correoper'];
    $_SESSION['correoper']=$_POST['correoper'];
    $i= $_POST['instituto'];
    $m= $_POST['matricula'];
    $no_poliza=$_POST['folio'];
    //SQLSERVER
    $msSql = new  mssqlCnx($pc_server_address,$pc_dbuser,$pc_dbpasswd,$pc_db);
    $conSQl=$msSql->Open();
    //MYSQL
    $con = new ConexionMysql($server_address,$dbuser,$dbpasswd,$db);

    //var_dump($con);

    $matric_var="";
    $precio=0;

    //validar generar gafete alumno
    if(strlen($m)==7)
    {
        $mat="TAX_ID";
    }
    if(strlen($m)==10)
    {
        $mat="PEOPLE_ID";
    }
    $sql = "SELECT DISTINCT c.CHARGECREDITNUMBER credito,
        c.RECEIPT_NUMBER,
        c.PEOPLE_ORG_ID id, TAX_ID matricula,
        c.ACADEMIC_YEAR anio,
        c.ACADEMIC_TERM periodo, 
        c.ACADEMIC_SESSION plantel,
        c.AMOUNT,
        c3.PAID_AMOUNT,
        c3.BALANCE_AMOUNT deuda,
        c2.ChargeAppliedTo,
        c2.ChargeCreditSource,
        c3.CHARGECREDITNUMBER,
        c3.CHARGE_CREDIT_CODE codigo
        FROM PEOPLE p LEFT JOIN
	CHARGECREDIT c ON p.PEOPLE_ID= c.PEOPLE_ORG_ID
        LEFT JOIN ChargeCreditApplication c2
        ON c.CHARGECREDITNUMBER = c2.ChargeCreditSource
        LEFT JOIN CHARGECREDIT c3
        ON c2.ChargeAppliedTo = c3.CHARGECREDITNUMBER
        WHERE c.RECEIPT_NUMBER = '$no_poliza'
        AND c3.VOID_FLAG = 'N'

        AND c3.ACADEMIC_YEAR=2018

        AND $mat ='$m';";
    $cmd= new mssqlCommand($sql,$conSQl);
    $res=$cmd->ExecuteReader();
    

        
    if ($res[0]["deuda"] == 0)
    {
        $sql = "select * from registro where  correo = '$correoper'";
        $cmd = new ComandosMysql($sql, $con->open());
        $datos = $cmd->ExecuteReader(true);
        //var_dump($datos);
        if (isset($datos['nombre']))
            $msg= "<div style='color: #000;'><h2>Usted ya se encuentra registrado<br><center>Bienvenido ".$datos['nombre']."</h2></center><br><br><h3>Por favor imprima su gafete para agilizar su entrada el día del evento.</h3><br><br> (En caso de no ver su gafete, active la opción de abrir ventanas emergentes en su navegador y envie su registro de nuevo, o en su defecto revise su e-mail)<br></div>";
        else{
            $query="insert into registro values('$n', '$correoper','$i', '$m', 'Jornada de Enfermeria', $no_poliza)";
            //echo($q."<hr>");
            $cmd = new ComandosMysql($query, $con->open());
            $datos = $cmd->ExecuteNonQuery(true);
            //echo $cmd->error_message;
            $msg= "<div style='color: #000;'><h2>Registro realizado con &eacute;xito<br><center>Bienvenido ".$n."</center><br></h2><br><h3>Por favor imprima su gafete para agilizar su entrada el día del evento.</h3><br><br> (En caso de no ver su gafete, active la opción de abrir ventanas emergentes en su navegador y envie su registro de nuevo, o en su defecto revise su e-mail)<br></div>";
            $correo =  new correo();
            $mensaje=$correo->Enviar($correoper,$n,$i,$m);
        }
    }

    else
    {//caso contrario si no encuentra folio
        $msg="<div style='color: #DC2822;'><h2>Usted no ha pagado el congreso o su número de recibo es incorrecto, verifique los datos nuevamente.<br><br> Por favor espere 10 segundos para volver a intentarlo</h2></div>";
    ?>
    <meta http-equiv="refresh" content="10;URL=http://congresosalud.uvp.mx/" />
    <?php
    }





    if ($res[0]["deuda"] == 0 )
    {
    ?>

    <body style="background-attachment: fixed" onLoad="window.open('gafeteqr.php?a1=<?php echo $n;?>&a2=<?php echo $i;?>&a3=<?php echo $m;?>','','width=450,height=500 0')">


        <?php 
    }
    else {
        ?>
        <body  style="background-attachment: fixed">
            <?php }
            ?>

            <div id="body-wrapper" >
                <center>
                    <table width="500" border="0" align="center" cellpadding="5" cellspacing="2">

                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="justify"><?=$msg?></td>
                        </tr>
                    </table>
                    <br><br><br><br><br><br><br><br>
                    <meta http-equiv="refresh" content="40;URL=http://congresosalud.uvp.mx/" /> 
                    <!--<meta http-equiv="refresh" content="60;URL=http://localhost/negrocios" />    -->
                </center>
            </div>
        </body>

        </html>