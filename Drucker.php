<?php 
	require "Database.php";
	require "header.php";

	$db = new Database;
	$con = $db->connect();
	//$Admin = "admin";
?>

<script type='text/javascript' src="Benutzer.js"></script>
<body>
    <div id="header" style="float:left; width:100%; clear:both; height:160px; position:static; background:url(bilder/BG-Header.png) repeat-x center top #b50f1b; margin-bottom: 3px;">
		<div class = "logo">
			<a href="/">
				<img src = "bilder/logo.png"></img>	
			</a>
		</div>
		<div class = "container">
			<div class ="mainlist" style = "text-align:center; padding-top:18px;">
				<div class = "col-sm-4 ">			
						<a href = "./User.php?level0=alleUser">BENUTZERVERWALTUNG</a>					
				</div>
				<div class = "col-sm-4 ">			
						<a href = "./Device.php?level0=alleUser">GERÄTEVERWALTUNG</a>				
				</div>				
				<div class = "col-sm-4 ">			
						<a href = "./Drucker.php?level0=alleUser">DRUCKEN</a>				
				</div>			
			</div>
		</div>
	</div>

	<div class = "container-fluid">
<?php
// Nur für Administrator Login
if ($_SESSION['Username'] == $db->Admin)
{
// Holen sie die Benutzer-Liste.
// Für Benutzer Überblick
	$overview = $db->select("Gerat","Nummer"); 
	if ($overview)
		$no =  $db->getResult();
?>	
<!-- Links Menü -->	
		<div class = "row" id = "level3">	
			<div class = " left_div  col-xs-3">
	
				<ul class = "list" style = "padding-left:30px;">		
					<a href = "./Drucker.php?level0=Overview"><li class = "list-group-item " ><img class = "userImage" src = "bilder/Overview.png">Überblick<span class = "badge"><?php echo count($no)?></span></img></li></a>
<!-- GerätList.php - ausdrucken die Gerät-information -->
					
					<a href = "./GerätList.php?level1=Gerat"><li class = "list-group-item"><img class = "userImage" src = "bilder/pdf1.png">Geräteliste</img></li></a>
					<a href = "./Drucker.php?level3=Certificate"><li class = "list-group-item"><img class = "userImage" src = "bilder/pdf1.png">Zertifikat</img></li></a>
				</ul>	
			</div>

<!-- Neue benutzer HTML  -->
			<div class = " middle_div col-xs-6" style = "margin-top: 2%">
<?php
	if($_GET['level0'])
	{		

?>				
<!-- Div for Text and select tag -->
				<div class = "scrol_header">
					<H3 class  = "title">Überblick</H3>
	<?php 
if($_GET['level0']) {
// Holen Sie die Gerät Name aus Gerät Tabelle
	$gerat = $db->select("Gerat", "Name",""," Name ASC");
	if ($gerat)
		$geratresult = $db->getResult();
	?>	
					<select class  = "selectpicker form-control" data-live-search = "True"   onchange = "ChangeId(this)" style  = "cursor: pointer;padding:5px">
					<option class  = "option_font_11" selected >Wählen Sie das Gerät hier</option>	
	<?php
for($i=0;$i< count($geratresult);$i++) {
// zeigen Sie die Gerät-Liste Lassen sie sich die Liste der Gerät
	?>			
						<option class  = "option_font_11" value = "<?php echo $geratresult[$i]?>"><?php echo $geratresult[$i]?></option>
	<?php
				}
	?>				
					</select>
	<?php
			}
	?>				
				</div> 
				<br>
		
<!-- Div-Tag für Geräte und Benutzer tabelle -->	
		<div class = "scrol_overview" >
		<table class = "table table-hover table-bordered table-condensed">

<?php
// Holen die Alle Gerät Name aus Gerat Tabelle 
			$gerat = $db->select("Gerat","Name","", "Name ASC");
			if($gerat){
				$gName = $db->getResult();
			}
			for($i = 0;$i<count($gName);$i++)
			{
				$device = $gName[$i];
?>
<!--Alle Gerät Name anzeigen -->
					<tr id  = "<?php echo $device?>">
						<th  class  = "Overview_table_device" colspan = "2" name = "<?php echo $device?>"; id  = "<?php echo $device?>"><?php echo $device?></th>
					</tr>



<?php
// Holen der Benutzer von alle die Gerät aus datenbanken
				$overview = mysql_query("SELECT concat( b.Titel,' ',b.Vorname,' ',b.Nachname) As UserName, b.Email as Email, a.Name as abt FROM Abteilung a,Benutzer b, Gerat g, Verwenden v WHERE a.Benut_Id = b.Benutzer_Id AND   b.Benutzer_Id = v.`Benutz_Id` AND v.`Gerat_nummer` = g.`Nummer` AND g.Name LIKE '$device' " );

				while($row = mysql_fetch_array($overview))
					{	
// Überprüfen die Benutzer Email.
						$email = $row["Email"];
						if ($email) {
	?>
					<tr>
						<th>
<?php
// Anzeige Benutzername nur einmal wenn Benutzer hat mehr ale einmal Abteilung Name
							if ($name != $row["UserName"])
							{
?>
								<ul>
									<li style = "font-size:11px; padding-left:20px">
										<a href = <?php echo "mailto:$email"?> >
											<img class = "emailImage" src = "bilder/email.gif"></img>
											</a>
											<?php echo $row["UserName"] ?>
									</li>
								</ul>
<?php
// Kopieren Benutzername
								$name = $row["UserName"];
							}
?>

						</th>
						<td>
							<ul>
								<li class  = "option_font_11">
<!-- Abteilung Name -->								
										<?php echo $row["abt"] ?>

								</li>
							</ul>
						</td>
					<tr>
	<?php
						}else {
// Benutzer mit keine Email						
	?>
					<tr>
						<th>
<?php
							if ($name != $row["UserName"])
							{
?>
								<ul>
									<li class  = "option_font_11" style = "padding-left:20px">
<!-- Benutzer Name -->										
											<?php echo $row["UserName"] ?>
									</li>
								</ul>
<?php
								$name = $row["UserName"];
							}
?>

						</th>
						<td>
							<ul>
								<li class  = "option_font_11">
<!-- Abteilung Name -->									
										<?php echo $row["abt"] ?>

								</li>
							</ul>
						</td>
	<?php				}
					}
					$name = "";
?>


					</tr>
<?php
			}
?>
		</table>
		</div>	
<?php				
	}
?>
<!-- ===============================================Ende der Gerät-Überblick ============================================-->			
<?php 
// Gerät-Zertifikat
if($_GET['level3']) {	
// Holen sie die alle Benutzername
		$res_user = $db->selectname("Benutzer","");
		if($res_user)
		{
			$suche_user = $db->getBenutzername();		
			$suche_id = $db->getResult();
		}
	
?>
<!-- Drucker.php ist Datie zu Benutzer Information ausdrucken -->
				<form action = "Drucker.php?" method =  "POST">
					<div class  = "form-group" style = "text-align:center">
						<H4 class  = "title">Benutzername</H4>
						<br>
						<select class=" selectpicker form-control"     data-live-search = "true"  name = "suche_benut"  id  = "suche_benut">
						<option class  = "option_font_11">Benutzername</option>
<?php
				for($i = 0;(($i <= count($suche_user)) && ($suche_user[$i]!= "")); $i++)
				{
// Alle Benutzer-name Liste anzeigen				
				
?>
							<option class  = "option_font_11" value = "<?php echo $suche_id[$i]?>" ><?php echo $suche_user[$i]?></option>
<?php			}
?>						</select>
						<br>
						<br>
						<input class = "btn btn-default" type = "submit" value = "Anfrage senden"  >
					</div>
				</form>
<?php 
}
// POST varible von Gerät-Zertifikat Drucken
if ($_POST['suche_benut'])
{

		$res_not_abt = array();
		$device_name = array();
		$device = array();
		$Geratall = array();
		$num = array();
		$suche_werte = ($_POST['suche_benut']);

		$db->startTransaction();
		
//holen Sie die alle andere abteilung name
		$query = mysql_query("Select distinct Name From Abteilung Where Name NOT IN (Select Name From Abteilung where Benut_Id = $suche_werte)");
		if ($query) {
			while($row = mysql_fetch_array($query))
			{
				array_push($res_not_abt, $row['Name']);
			}
		}
		
//Holen Sie die Abteilung-Name Liste nur für diesen Benutzer	
		$value_abt_name = $db->select("Abteilung","Name","Benut_Id = $suche_werte "," Name ASC" );
		if ($value_abt_name){
			$res_abt_name = $db->getResult();
		 }
//Holen Sie die alle GerätName Liste 		
		$value_device_not_num = mysql_query("Select Name, Nummer  From Gerat Where Nummer NOT IN (Select Gerat_nummer From Verwenden Where Benutz_Id = $suche_werte)");
		if ($value_device_not_num)
		{
			while($row = mysql_fetch_array($value_device_not_num))
			{
				array_push($device_name, $row['Name']);
				array_push($device, $row['Nummer']);
			}
		}
//Holen Sie die GerätName Liste nur für diesen Benutzer			
		$value_device_num = mysql_query("Select Name, Nummer  From Gerat Where Nummer IN (Select Gerat_nummer From Verwenden Where Benutz_Id = $suche_werte)");
		if ($value_device_num)
		{
			while($row = mysql_fetch_array($value_device_num))
			{
				array_push($Geratall, $row['Name']);
				array_push($num, $row['Nummer']);
			}
		}
//Holen Sie die benutzer information 
// Anziege 		
		$value = $db->select("Benutzer","*"," Benutzer_Id = $suche_werte" );
		if($value) {
			$res = $db->getResult();		
?>			
				<form action = "./Certificate.php" method = "POST">				
					<dl class  = "UserDetails dl-horizontal">
					<H4 class = "title">Druck Zertifikat</H4>
					<br>
					<dt >Titel</dt>
					<dd><? echo $res[1]?>
						<input type = "text" size = "20px" name = "druck_Title" id = "druck_Title" value = "<? echo $res[1]?>" hidden>
						<input type = "text" size = "20px" name = "druck_Id" id = "druck_Id" value = "<? echo $suche_werte ?>" hidden>
					</dd>
					<br>
					<dt>Vorname</dt>
					<dd><? echo $res[2]?>
						<input type = "text" size = "20px" name = "druck_Vorname" id = "druck_Vorname" value = "<? echo $res[2]?>" hidden></dd>
					<br>
					<dt>Nachname</dt>
					<dd><? echo $res[3]?>
						<input type = "text" size = "20px" name = "druck_Nachmane" id = "druck_Nachmane" value = "<? echo $res[3]?>" hidden></dd>
					<br>
					<br>
					<dt>Abteilung</dt>
					<dd>
						<select multiple  class = "selectpicker form-control"  data-actions-box="true" data-live-search = "true"  name = "druck_abt[]" id = "druck_abt">
<?php
						for($i = 0;($i < count($res_abt_name)); $i++) {
							if (strlen($res_abt_name[$i])> 0) {
// Abteilung Liste nur für diesen Benutzer
?>							
							<option class  = "option_font_9" value = "<?php echo  $res_abt_name[$i] ?>" > <?php echo $res_abt_name[$i] ?></option>	
<?php					}}
?>
						</select>
					</dd>	
					<br>
					<dt>Gerät</dt>
					<dd>
						<select multiple  class = "selectpicker form-control"  data-actions-box="true" data-live-search = "true"  name = "druck_gerat[]" id = "druck_gerat">
<?php
// Gerät Liste Nur für diesen Benutzer
						for($i = 0;$i < count($Geratall); $i++){
?>								
							<option class  = "option_font_11" value = "<?php echo  $Geratall[$i] ?>"> <?php echo  $Geratall[$i] ?></option>	
<?php	
						}
?>
						</select>
					</dd>	
					<br>
<!-- HTML link zu bearbeiten Benutzer -->					
							<dd><strong><a href = "./User.php?level2=modifyUser">Bearbeiten Benutzer</a></strong></dd>	
							<br>
							<dd><input class = "btn btn-default" type = "submit" value = "Drucken" ></dd>
							
											
				</dl>					
				</form>
		
<?php	
		}
	}
?>	
			</div> 	<!-- col-xs-6 -->		
			<div class = "div_logout col-xs-3" style = "float: right; max-width: 400px;">
<!-- ===============================================Ende der gerät-Zertifikat Drucken ============================================-->

			
<?php
// Rechts Menü
	if($_SESSION['Username'] = $db->Admin) {
?>	 
				<div class = "well" >
					<H4 style = "text-align:center">Benutzer: <?php echo  $_SESSION['Username'];?></H3>
					<a href = "./Logout.php"><p class = "Abmelden" >Abmelden</p></a>			
				</div>
<?php
	}
?>	
			</div>
<!--Hilfe Text -->			
			<div class = "col-xs-3" style = "float: right; max-width: 400px;">
<?php
// Hilfe Text für Gerätverwaltung Überblick	
	if($_GET['level0']){
?>
		<div class = "well"  style = "margin-top : 10px; ">
				<strong>Gerätverwaltung:</strong>

				<p style = "padding-left:15px">Bitte wählen Sie die Geräteliste von oben an die Benutzer des Geräts anzeigen</p>	
				
		</div>		
	
<?php
	}else if($_GET['level3']){
// Hilfe Text zu Gerät-Zertifikat (Wählen Sie Benutzer )
?>
		<div class = "well"  style = "margin-top : 10px; ">
				<strong>Zertifikat</strong>
				<p style = "padding-left:15px">Bitte wählen Sie den Benutzer aus der Liste</p>
		</div>		
	
<?php
	}else if($_POST['suche_benut']){
// Hilfe Text für Gerät-Zertifikat (Drucken Benutzer information)
?>
		<div class = "well"  style = "margin-top : 10px; ">
				<strong>Zertifikat</strong>				
				<p style = "padding-left:15px">Wählen Sie die Abteilung und Gerät aus der Liste, um das Zertifikat zu generieren.</p>	
				
		</div>		
	
<?php
	}
?>

		</div>
			</div> <!-- col-xs-3 -->
			
		</div>	<!-- row -->
<?php
// Hilfe Text für Sitzung abgelaufen
	}else if ($_SESSION['Error'] != "1") {
?>
		<div class="col-md-4 col-md-offset-4" style = "text-align:center">
			<div class = "">
				<strong><h3 class="text-danger">Sitzung abgelaufen</h3></strong> 
					<h4 class = "glyphicon glyphicon-hand-right"> <a href = "./"  style = "color:#808080">Ich will zurück zum Login</a></h4>	
			</div>	
		</div>  <!-- col-md-4 col-md-offset-4 -->
<?php
}else if ($_SESSION['Error'] == "1"){
		$_SESSION['Error'] = "";
// Hilfe Text für Fehler: Ungültiger Admin Login
?>
		<div class="col-md-4 col-md-offset-4" style = "text-align:center">
			<div class = "">
				<strong><h3 class="text-danger">Fehler: Ungültiger Admin Login</h3></strong> 
					<h4 class = "glyphicon glyphicon-hand-right"><a href = "./"  style = "color:#808080">Zurück zu Login</a></h4>	
	 	    </div>	
	    </div> <!-- col-md-4 col-md-offset-4 -->
<?php
}
?>
	</div>	<!-- container-fluid -->
</body>	