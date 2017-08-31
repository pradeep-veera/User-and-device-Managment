<?php 
require("fpdf/fpdf.php");
require "Database.php";
$db = new Database;
$con = $db->connect();
	ob_clean(); 
// Überprufen die Benutzer-id
if ($_GET['level3'])
{
	$user_id = $_GET['level3'];
	$query_benutzer = mysql_query("Select * From Benutzer Where Benutzer_Id = $user_id ");
    while ($row = mysql_fetch_array($query_benutzer)){
		$title =  $row["Titel"];
		$vor =  $row["Vorname"];
		$nach =   $row["Nachname"];
		
	}
	
	$pdf = new FPDF('P','mm',array(210,297));
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',20);
	$pdf->SetLineWidth(0.2);
	$pdf->SetTextColor(194,8,8);
	$pdf->Line(10,9,200,9);
// Logo 	
	$pdf->Image("bilder/Logo1.jpg",10,10,29,20);
// Titel	
	$pdf->Cell(0,15,"Geräteverwaltung Zertifikat",0,1,'R');
	$pdf->Line(10,31,200,31);		
	//$pdf->Cell(0,10,"",0,1,'R');
	
	$pdf->Cell(0,10,"",0,1,"C");
	
// Benutzer Infomation
	$pdf->SetTextColor(0);
	$pdf->Ln();
//Print title only if it is present else skip it 
	if ($title){
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(30,10,"Titel :",0,0,"L");
		$pdf->SetFont('Arial','',10);	
// calucate cell width depending on the lenght of the string
		$str_title = $pdf->GetStringWidth($title)+2;
		$pdf->Cell($str_title,10,$title,0,1,"L");
	}	
	$pdf->SetFont('Arial','B',12);		
	$pdf->Cell(30,10,"Name :",0,0,"L");
	$pdf->SetFont('Arial','',10);	
	$str_vor = $pdf->GetStringWidth($vor)+2;
	$pdf->Cell($str_vor,10,$vor,0,0,"C");	
	$str_nach = $pdf->GetStringWidth($nach)+2;
	$pdf->Cell($str_nach,10,$nach,0,1,"R");
// Bemutzer Abteilung List
	$pdf->Cell(0,10,"",0,1,"C");	
	$pdf->SetFont('Arial','B',12);		
	$pdf->Cell(30,10,"Abteilung :",0,0,"L");
	$pdf->SetFont('Arial','',8);
	
	$query_abt = mysql_query("Select distinct Name From Abteilung where Benut_Id = $user_id");
    while ($row = mysql_fetch_array($query_abt)){
		$abt = $row["Name"];
		$str_abt = $pdf->GetStringWidth($abt)+2;
		$pdf->Cell($str_abt,10,$abt ,0,1,"L");
		$pdf->Cell(30,10,"",0,0,"L");	
			
	}		
// Benutzer Gerät List
	$pdf->Cell(0,10,"",0,1,"C");
	$pdf->SetFont('Arial','B',12);		
	$pdf->Cell(30,10,"Gerät :",0,0,"L");
	//$pdf->Cell(50,10,"",0,0,"L");	
	$pdf->SetFont('Arial','',8);		
	
	$query_gerat = mysql_query("Select Name From Gerat Where Nummer IN (Select Gerat_nummer From Verwenden Where Benutz_Id = $user_id)");
    while ($row = mysql_fetch_array($query_gerat)){
		$gerat = $row["Name"];
		$str_gerat = $pdf->GetStringWidth($gerat)+2;
		$pdf->Cell($str_gerat,10,$gerat,0,1,"L");
		$pdf->Cell(30,10,"",0,0,"L");
			
	}
//Check length of the page
	if ($pdf->GetY() < 220) {
// loop empty space till the end of the page
		while ($pdf->GetY() < 250) {
			$y = $pdf->GetY();
			$pdf->Cell(0,10,'',0,1,"L");
		}
// Print Bellow data at the end of the page
		$pdf->SetFont('Arial','B',8);		
		$pdf->Cell(30,10,"Datum Und Ort",0,0,"L");	
		$pdf->Cell(160,10,"Unterschrift",0,1,"R");
		$pdf->SetFont('Arial','',8);		
		$pdf->Cell(30,10,"________ ,________________",0,0,"L");	
		$pdf->Cell(160,10,"_____________",0,1,"R");
			
	}else {
		// print the detials if the postion of y is at end of the page.
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(30,10,"Datum Und Ort",0,0,"L");	
		$pdf->Cell(160,10,"Unterschrift",0,1,"R");
		$pdf->SetFont('Arial','',8);		
		$pdf->Cell(30,10,"________ Und ________________",0,0,"L");	
		$pdf->Cell(160,10,"_____________",0,1,"R");
	}
$pdf->Line(10,290,200,290);
$pdf->Output(); 
}

?>				

