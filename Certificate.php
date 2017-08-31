<?php 
require("fpdf/fpdf.php");
ob_clean(); 
if ($_POST['druck_Id'])
{
	$title = $_POST['druck_Title'];
	$vor = $_POST['druck_Vorname'];
	$nach = $_POST['druck_Nachmane'];
	$abt = $_POST['druck_abt'];
	$gerat =$_POST['druck_gerat'];
}
	
	$pdf = new FPDF('P','mm',array(210,297));
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',20);
	$pdf->SetLineWidth(0.2);
	$pdf->SetTextColor(194,8,8);
	$pdf->Line(10,10,200,10);
	$pdf->Image("bilder/Logo1.jpg",10,12,29,20);
	$pdf->Cell(0,15,"Geräteverwaltung Zertifikat",0,1,'R');
	$pdf->Line(10,34,200,34);		
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
	$pdf->SetFont('Arial','',10);		
	if (count($_POST['druck_abt'])>1)
	{
		$iabt = count($_POST['druck_abt']);		
		while($iabt)
		{
			$iabt--;		
			$str_abt = $pdf->GetStringWidth($abt[$iabt])+2;
			$pdf->Cell($str_abt,10,$abt[$iabt],0,1,"L");
			$pdf->Cell(30,10,"",0,0,"L");	

			
		}
	}else {
		$iabt = 0;
		$pdf->Cell(150,10,$abt[$iabt],0,1,"L");
	}	
	// Benutzer Gerät List
	$pdf->Cell(0,10,"",0,1,"C");
	$pdf->SetFont('Arial','B',12);		
	$pdf->Cell(30,10,"Gerät :",0,0,"L");
	//$pdf->Cell(50,10,"",0,0,"L");	
	$pdf->SetFont('Arial','',10);		
	if (count($_POST['druck_gerat'])>1)
	{
		$igerat = count($_POST['druck_gerat']);		
		while($igerat)
		{
			$igerat--;
			$str_gerat = $pdf->GetStringWidth($gerat[$igerat])+2;
			$pdf->Cell($str_gerat,10,$gerat[$igerat],0,1,"L");
			$pdf->Cell(30,10,"",0,0,"L");
			
		}
	}else {
		$igerat = 0;
		$str_gerat = $pdf->GetStringWidth($gerat[$igerat])+2;
		$pdf->Cell($str_gerat,10,$gerat[$igerat],0,1,"L");	
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
ob_clean(); 


?>				
