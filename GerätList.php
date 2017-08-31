<?php
	require("fpdf/fpdf.php");
	require "Database.php";
	
	$db = new Database;
	$con = $db->connect();
	
	ob_clean(); 
	$pdf = new FPDF('P','mm',array(210,297));
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',17);
	$pdf->SetLineWidth(0.1);
	$pdf->Line(20,9,200,9);	
	$pdf->SetTextColor(194,8,8);	
	$pdf->Image("bilder/Logo1.jpg",20,10,29,20);
	$pdf->Cell(0,15,"Geräteliste",0,1,'R');
	$pdf->Line(20,31,200,31);
	$pdf->Cell(0,10,"",0,1,"C");
	//$pdf->Line(10,40,200,40);
	if($_GET['level1'])
	{
		$gerat = $db->select("Gerat","Name","", "Name ASC");
		if($gerat)
			$gName = $db->getResult();
		$gList = count($gName);
		while($gList){
			$gList--;
			$pdf->Ln();
			$pdf->SetFont('Arial','',10);
			//$pdf->Cell(10,10,"",0,0,"C");
			$pdf->SetTextColor(194,8,8);
			$pdf->Cell(0,10,$gName[$gList],0,1,'C');
			$pdf->Cell(10,10,"",0,0,"C	");
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,8,"Benutzer Name",1,0,'C');
			$pdf->Cell(120,8,"Abteilung",1,1,'C');
			//$pdf->Line(90,40,90,100);
			$pdf->SetFont('Arial','',10);
			$device = $gName[$gList];
			$overview = mysql_query("SELECT concat( b.Titel,' ',b.Vorname,' ',b.Nachname) As UserName, b.Email as Email, a.Name as abt FROM Abteilung a,Benutzer b, Gerat g, Verwenden v WHERE a.Benut_Id = b.Benutzer_Id AND   b.Benutzer_Id = v.`Benutz_Id` AND v.`Gerat_nummer` = g.`Nummer` AND g.Name LIKE '$device' " );
				
			while($row = mysql_fetch_array($overview))
			{
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(10,10,"",0,0,"C");
				$pdf->SetTextColor(0);
				if (($Name != $row['UserName']) && (strlen($Name) != strlen($row['UserName'])))
				{
					if (strlen( $row['UserName'])< 30 )
						$pdf->Cell(60,5,$row['UserName'],1,0,'L');
					else {
						$str = str_split($row['UserName'],55);
						$pdf->SetFont('Arial','',6);
						$pdf->Cell(60,5,$str[0],1,0,'L');
					}	
					$Name = $row['UserName'];
				}else {
					$pdf->Cell(60,5,"",1,0,'C');
				}
				if (strlen($row['abt']) < 80)
					$pdf->Cell(120,5,$row['abt'],1,1,'L');
				else {
					$strabt = str_split($row['abt'],110);
					$pdf->SetFont('Arial','',6);
					$pdf->Cell(120,5,$strabt[0],1,0,'L');					
				}
				
			}
			$pdf->Ln();
			
		}
	}
		$pdf->Line(20,290,200,290);
	$pdf->Output();
	ob_clean(); 
?>
