<?php
//include_once ("conecta_capt.php");
$nombre=$_GET['a1'];
$instituto=$_GET['a2'];
$matricula= $_GET['a3'];

require('fpdf/fpdf.php');


//var_dump($link);

$pdf = new FPDF();

$pdf->AliasNbPages();
$pdf->AddPage();

$y=$pdf->GetY();
$x=$pdf->GetX();
			//Ln(algo);


//$pdf->Image('imagenes/fondoPatrocinio.jpg',10,70,90,60,jpg);
$pdf->Image('images/gafete1.jpg',10,10,90,jpg);
$pdf->Image('http://chart.googleapis.com/chart?chs=100x100&cht=qr&chl='.$matricula.'&.png',70,107,15,15);
		//$pdf->Image('images/cabeza.jpg',30,10,30,15,jpg);


		//$pdf->Image('http://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=Externo&.png',40,50,32,32);
		//$pdf->Image('images/logo.jpg',51,40,10,10,jpg);
		//$pdf->Image('132.jpg',10,10,90,22,jpg);
		//$pdf->Image('logo.jpg',50,27,10,10,jpg);	
		/*$pdf->Image('corte.jpg',189,126,10,10,jpg);
		$pdf->Image('132.jpg',10,10,90,22,jpg);
		
		$pdf->Image('comunikt.jpg',20,37,70,20,jpg);
		$pdf->Image('133.jpg',10,108,90,22,jpg);
		$pdf->Image('programa.jpg',101,10,89,120,jpg);*/
		
		$pdf->Cell(90,'',1,1,'C');//PRINCIPAL
		$pdf->SetXY($x+90,$y);
		//$pdf->Cell(90,120,'',1,1,'C');
		$pdf->Ln();
		$pdf->SetXY($x,$y+53);
		$pdf->Ln(63);
		if (strlen ($instituto) > 53){
			$tama = 10;}
			else{
				$tama=12;}
				$pdf->SetTextColor(149,27,129);
				$pdf->SetFont('ARIAL','B',$tama); 
				$pdf->Cell(90,6,utf8_decode($nombre),0,0,'C');
			$pdf->Ln(7);//si lo pones vacio, jala el ancho de l�a ultima elda impresa
			$pdf->SetFont('Arial','','8');
			//$pdf->Cell(90,5,'NOMBRE',T,0,'C');
			$pdf->SetXY($x,$y+75);
			$pdf->Ln(45);
			$pdf->SetFont('ARIAL','B',$tama); 
			$pdf->Cell(90,6,utf8_decode($instituto),0,0,'C');
			  $pdf->Ln(6);//si lo pones vacio, jala el ancho de la ultima celda impresa
			  $pdf->SetFont('Arial','','8');
			  //$pdf->Cell(90,5,'INSTITUTO',T,0,'C');

			  $pdf->Ln(40);
			  $pdf->Ln(1);
			  $pdf->Output();
			  ?>