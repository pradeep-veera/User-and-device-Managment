<!-- 
	Diese datei zeigt den code für Geräteverwaltung
		-> Gerät Überblick
		-> Neue Gerät. 
		-> Bearbeiten Gerät.
		-> Gerät Loschen.
-->

<?php 
	require "Database.php";
	require "header.php";

	$db = new Database;
	$con = $db->connect();
	//$Admin = "admin";
?>
<script type='text/javascript' src="AdminGerat.js"></script>
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
if ($_SESSION['Username'] == $db->Admin)
{

	$overview = $db->select("Gerat","Nummer"); 
	if ($overview)
		$no =  $db->getResult();
?>	
		<div class = "row" id = "level3">	
			<div class = "left_div col-xs-3">
	
				<ul class = "list" style = "padding-left:30px;">
					<a href = "./Device.php?level0=neuedevice"><li class = "list-group-item " ><img class = "userImage" src = "bilder/Overview.png">Überblick<span class = "badge"><?php echo count($no)?></span></img></li></a>
					<a href = "./Device.php?level1=neuedevice"><li class = "list-group-item"><img class = "userImage" src = "bilder/gerat.png">Neue Gerät</img></li></a>
					 
					<a href = "./Device.php?level2=modifydevice"><li class = "list-group-item"><img class = "userImage" src = "bilder/gerat.png">Bearbeiten Gerät</img></li></a>
					<a href = "./Device.php?level3=deletedevice"><li class = "list-group-item"><img class = "userImage" src = "bilder/gerat.png">Löschen Gerät</img></li></a>
				</ul>	
			</div>
	
<!-- Neue benutzer HTML  -->
			<div class = "middle_div col-xs-6">	
<?php
// Gerät überblick
	if($_GET['level0'])
	{		

?>		

			<div class = "scrol_header">
				<H3 class  = "title">Überblick</H3>
	<?php 
// Alle Gerät Name aus databanken auswälhen
				if($_GET['level0']) {
				$gerat = $db->select("Gerat", "Name", "","Name ASC");
				if ($gerat)
					$geratresult = $db->getResult();
	?>	
				<select class  = "selectpicker form-control" data-live-search = "True"  onchange = "ChangeId(this)" style  = "cursor: pointer ;padding:5px">
					<option class  = "option_font_11" selected >Wählen Sie das Gerät hier</option>					
	<?php
				for($i=0;$i< count($geratresult);$i++)
				{
// Alle Gerät Name anzeigen
	?>			
					<option class  = "option_font_11" value = "<?php echo $geratresult[$i]?>"><?php echo $geratresult[$i]?></option>
	<?php
				}
	?>				
				</select>
	<?php
			}
	?>				
			</div> <!-- scrol_header -->
			<br>
		
<!-- Div tag for Device and User table || Div-Tag für Geräte- und Benutzertabelle -->	
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
   
	// INSERT-code für Neue Gerät  
	if($_POST['neue_gerat_Id'])
	{
		$gerat = $_POST['neue_Name'];
		$query = mysql_query("Select Distinct Name from Gerat where Name  Like '$gerat'");
		if (mysql_fetch_row($query)){
?>		
			<div class="alert ">
				<!-- Device is already present || Gerät name ist dort in der databanken-->
				<strong><img class = "dangerImage" src = "bilder/danger.png">Fehler: Gerät bereits vorhanden ist</img></strong> 

			</div>		
<?php			
		}else {
			// No device of the name is present in database || Kein Gerät des Namens in der Datenbank vorhanden ist
			$db->startTransaction();
			// Insert-anweisung mit Gerät Name und Gerät Id.
			$res_insert = $db->insert( "Gerat", array($_POST['neue_gerat_Id'], $_POST['neue_Name']), "Nummer, Name");
			
			if ($_POST['gerät_user']){
				$count_usr = count($_POST['gerät_user']);
				while ($count_usr > 0){
					$count_usr--;
					$verwndn =  $db->insert("Verwenden",array("", $_POST['gerät_user'][$count_usr], $_POST['neue_gerat_Id'], "","" ) ,"`Verwenden Id`, Benutz_Id, Gerat_nummer, Von,Bis");
					if (!$verwndn)
						die(mysql_errno());
				}
			}
			
			if ( ($res_insert && !$_POST['gerät_user'])||($res_insert && $verwndn))
			{
				$db->commitTransaction();
?>			
				<div class="alert ">
					<!--New Device is added || Neues Gerät hinzugefügt-->
					<strong><img class = "successImage" src = "bilder/success.png">Neues Gerät hinzugefügt</img></strong>
					<br>
					<strong>Möchten Sie<a href = "./User.php?level1=neueUser"> Neue Benutzer </a> oder <a href = "./User.php?level4=neueabt"> Neue Abteilung </a> zu hinzufügen? </strong>	

				</div>		
<?php					
			
			}else {
				//Insert query failed || INSERT-Abfrage ist fehlgeschlagen
				$db->rollbackTransaction();
?>			
				<div class="alert ">
					<!--New Device is not added || Neues Gerät nicht hinzugefügt-->			
					<strong><img class = "dangerImage" src = "bilder/danger.png"> Fehler: Neues Gerät hinzugefügt nicht </img></strong> 
				</div>		
<?php		}	
			
		}
	}
	// Neue Gerät - I
	if ($_GET['level1'])
	{
		/* Get the Device Id from table || Holen Sie sich das Gerät-ID aus der Tabelle */
		$res_sel = $db->select( "Gerat", "Nummer");
		if ($res_sel) {
			$number = $db->getResult();
			$current_Id = $number[count($number)-1];
		}
// SELECT-anweisung für Benutzer name
		$usr = $db->selectname("Benutzer","");
		if($usr)
		{
			$usr_name = $db->getBenutzername(); // Benutzer Name
			$usr_id = $db->getResult(); // Benutzer Id
		}	
?>		<!-- form für Neue Gerät -->	
		<form class = "form-group" name = "neue_gerat" onsubmit = "return Gerat_validate()" action = "./Device.php" method = "POST">
			<dl class  = "UserDetails dl-horizontal">
				<h4 class = "title">Füllen Sie die unten Details</h4>
				<br>
				<dt>Sortieren :</dt>
				<dd>
					<input class = "form-control" type="text" size="50" value =<?php echo $current_Id+1 ?> disabled></input>
					<input name = "neue_gerat_Id" type="text" size="50" value = <?php echo $current_Id+1 ?> hidden></input>
				</dd>
				<br>
				<dt>Gerätname :</dt>
				<dd>
					<input class = "form-control" name = "neue_Name" type = "text" size = "20px" placeholder = "Gerät Name" onchange = "return FormGerätnameValidate(this)"></input>
				</dd>
				<br>
				<dt>Benutzer :</dt>
				<dd>
				<select multiple  class = "selectpicker form-control"  data-actions-box="true" data-live-search = "true"  name = "gerät_user[]" id = "gerät_user[]" >
<?php
					for($i = 0;(($i <= count($usr_name)) && ($usr_name[$i]!= "")); $i++) 
					{
// Anzeigen Sie die Beutzername					
?>
						<option class  = "option_font_10"value = "<?php echo $usr_id[$i] ?>" ><?php echo $usr_name[$i]?></option>
<?php
					}
?>				
				</select>
				</dd>
				<br>
				<dd colspan = "2">
					<input class = "btn btn-default" type = "submit" value = "Speichern" >
				</dd>
			</dl>
		</form>
<?php
	}
?>	
<!-- ===============================================Ende der Neue Gerät ============================================-->	
<?php
	// Post request to Modify Device name || POST-Antrag an Gerätename ändern
	if (($_POST['modify_gerat_id']) &&($_POST['modify_gerat_name']))
	{
		$gerat = $_POST['modify_gerat_name'];
		// Check for Duplicate name in database || Prüfung auf doppelte Namen in der Datenbank
		$query = mysql_query("Select Distinct Name from Gerat where Name  Like '$gerat' ");
		if (mysql_fetch_row($query)){
?>		
			<div class="alert ">
				<!--Device is already present || Gerät bereits vorhanden ist -->
				<strong><img class = "dangerImage" src = "bilder/danger.png">Fehler: Gerät bereits vorhanden ist</img></strong> 
				<!-- <p><?php die(mysql_error());?></p> -->
			</div>		
<?php			
		}	
		$value = $_POST['modify_gerat_name'];
		$gerat_id = $_POST['modify_gerat_id'];
		$where = "Nummer =  ".$gerat_id."" ;
		$up_abt = $db->update("Gerat",array("Name"), array($value)  , $where);
		if ($up_abt)
		{
?>			
			<div class="alert ">
				<!--Gerat Name is updated || Gerat Namen wird aktualisiert-->
				<strong><img class = "successImage" src = "bilder/success.png">Gerätename wird aktualisiert</img></strong>
				<br>
				<br>	
				<strong>Möchten Sie<a href = "./User.php?level2=modifyUser"> Benutzer Name </a> oder <a href = "./User.php?level5=bearbeitenabt"> Abteilung Name</a> zu aktualisieren ? </strong>
			</div>		
<?php
		}else {
?>			
			<div class="alert ">
				<!--Gerat Name is not updated || Gerat Namen wird nicht aktualisiert-->			
				<strong><img class = "dangerImage" src = "bilder/danger.png">Fehler: Gerätename wird aktualisiert nicht</img></strong> 
				<!-- <p><?php die(mysql_error());?></p> -->
			</div>		
<?php		
		}
	}
	// Bearbeiten benutzer -II 
	if ($_POST['suche_device'])
	{

		$abt_name = array();
		// Get the Device ID || erhalten Gerät Id
		$suche_werte = ($_POST['suche_device']);
		$db->startTransaction();
		// Select the Device name from Device ID || Gerät Name aus Gerät id auswählen
		$Gerat_name = $db->select("Gerat","Name","Nummer = $suche_werte ");
		if ($Gerat_name)
		{
			$res_name = $db->getResult();
		}
		// Select the Device Id || Gerat Id auswählen 
		$Gerat_nummer = $db->select("Gerat","Nummer","Nummer = $suche_werte ");
		if ($Gerat_nummer)
		{
			$res_nummer = $db->getResult();
		}	
?>			
		<form name = "bearbeiten_gerat" onsubmit = "return bGerat_validate()"action = "./Device.php" method = "POST">
			<dl class  = "UserDetails dl-horizontal">
			<h4 class = "title">Bearbeiten</h4>
			<br>
			<dt>Sortieren :</dt>
			<dd>
			<input class = "form-control"type="text" size="50" value = "<?php echo $res_nummer[0] ?>" disabled>
			<input name = "modify_gerat_id"type="text" size="50" value = "<?php echo $res_nummer[0] ?>" hidden>
			</dd>
			<br>
			<dt>Gerät Name :</dt>
			<dd>
			<input class = "form-control" name = "modify_gerat_name" type = "text" value = "<?php echo $res_name[0] ?>" size = "20px" onchange = "return FormGerätnameValidate(this)">
			</dd>
			<br>
			<dd colspan = "2">
			<input class = "btn btn-default" type = "submit" value = "Speichern" >
			</dd>
			</dl>
		</form>
		
<?php	
	}
?>



<!-- Bearbeiten benutzer HTML  --> 

<?php

	if ($_GET['level2'])
	{
		// erhalten alle Gerät Name
		$res_user = $db->select("Gerat","Name",""," Name ASC");
		if($res_user)
			$suche_user = $db->getResult();
		// erhalten Alle Gerät Id 
		$res_Id =  $db->select("Gerat","Nummer",""," Name ASC");
		if($res_Id)		
			$suche_id = $db->getResult();	

?>	<form name  = "Geratsel" onsubmit = "return Geratsel_validate()" action = "./Device.php?" method = "POST" style = "text-align: center">

	<div class = "form-group">
		<h4 class = "title">Gerätname bearbeiten</h4>
		</br>
					<select class = "selectpicker form-control"   data-live-search = "true" name = "suche_device"  id  = "suche_device">
						<option class = "option_font_11" value = "0"selected>Gerätname</option>
<?php
					for($i = 0;(($i <= count($suche_id)) && ($suche_user[$i]!= "")); $i++)
					{
						// Alle Gerät name anzeigen
?>
						<option class  = "option_font_11" value = "<?php echo $suche_id[$i]?>" ><?php echo $suche_user[$i]?></option>
<?php
					}
?>
					</select>	
	</div>
		</br>
		<input class = "btn btn-default" type = "submit" value = "Anfrage senden"  >		
	</form>
<?php	
	}	
?>	
<!-- ===============================================Ende der Bearbeiten gerät ============================================-->
<?php
	// Delete Device - II 
	if ($_POST['del_gerat'])
	{
		// Get the Device Id Array || erhalten Gerät Id Array
		$del_gerat =  $_POST['del_gerat'];
		// Count the list of Device Id's || Zählen Sie die Liste der Geräte-IDs
		$del_gerat_count = count($_POST['del_gerat']);
		if ($del_gerat_count > 0)
		{	
			$db->startTransaction();
			do 
			{
				// 'Where' deklaration für Lösen query 
				$where = "Nummer = ".$del_gerat[--$del_gerat_count]." ";
				$del_res = $db->delete("Gerat",$where);	 	
				// Check it the result of $ del_res || Überprüfen sie das ergebnis von $del_res
				if (!$del_res)
					$del_rollback = true;
			}while($del_gerat_count != 0);
			// Commit the transaction if there are no error's || Commit-Transaktion wenn '$del_res' hat keine Fehler oder '$del_res' ist Wahr!
			if ($del_res && !$del_rollback ) {
				$db->commitTransaction();
?>			
			
			<div class  = "alert">
				<!--Device is deleted from Database And User is updated accordingly || Gerät aus der databaken gelöscht und Benutzer wird aktualisiert -->
				<strong><img class = "successImage" src = "bilder/success.png">Gerät aus der Datenbank gelöscht!<br>Und Benutzer wird entsprechend aktualisiert</img></strong>
				<strong> Möchten Sie<a href = "./User.php?level3=deleteUser"> Benutzer</a> oder <a href = "./User.php?level6=bearbeitenabt"> Abteilung</a> zu löschen ? </strong>
			
			</div>		
<?php
			}else {
				// Roll back the transction for any error and display the error message || Rollback transaktion wenn '$del_res' ist nicht wahr
				$db->rollbackTransaction();
?>			
				<div class  = "alert">
					<!--Device is not deleted from Database || Gerät aus der databanken nicht gelöscht-->			
					<strong><img class = "dangerImage" src = "bilder/danger.png">Fehler: Gerät nicht aus der Datenbank gelöscht</img></strong> 
					<br>
					<!-- <p><?php die(mysql_error());?></p> -->
				</div>		
<?php		
			}			

		}		
	}
	// Delete Device HTML - I || Gerät Löschen -I
	if ($_GET['level3'])
	{
		// Select distinct Device name || Gerät Name aus databanken auswählen
		$gerat_user = $db->select("Gerat","Name",""," Name ASC");
		if($gerat_user)
		{	
			$suche_name = $db->getResult();
		}
		// Select distinct Device Id || Gerät Id aus databanken auswählen
		$gerat_id = $db->select("Gerat","Nummer",""," Name ASC");
		if($gerat_id)
		{	
			$suche_id = $db->getResult();
		}
?>	
	<!-- Delete Device -->
	<form action = "./Device.php?" method = "POST" style = "text-align: center">
		<div class = "form-group">
			<h4 class = "title">Gerätname Löschen</h4>
			</br>
			<select class = "selectpicker form-control" multiple  data-actions-box="true" data-live-search = "true" name = "del_gerat[]" id = "del_gerat"  class = "dropdown_box">	

<?php
					for($i = 0;($i < count($suche_name)&&($suche_name[$i]!=" ")); $i++)
					{
						// Display list of Devices in select statement || liste der Gerät im databank anweisung anzeigen
?>
						<option class  = "option_font_11" value = "<?php echo $suche_id[$i]?>" ><?php echo $suche_name[$i]?></option>
<?php
					}
?>
			</select>
			</br>
			</br>	
			<input class = "btn btn-default" type = "submit" value = "Lösen"  >	
		</div>	
	
		
	</form>	
<?php	
	}	
?>	
<!-- ===============================================Ende der Loschen Gerät ============================================-->
</div>
<!-- Right side menu || Rechts menü -->
<div class  = "div_logout col-xs-3" style = "float:right">
<?php
	if($_SESSION['Username'] = $db->Admin) {
?>	 
				<div class = "well" >
			<H4 style = "text-align:center">Benutzer: <?php echo  $_SESSION['Username'];?></H4>
			<a href = "./Logout.php"><p class = "Abmelden" >Abmelden</p></a>
		</div>
<?php
	}
?>
</div> <!-- div_logout col-xs-3 -->

<!-- Help Statement's || Hilfe Aussage-->
<div class = "col-xs-3"" style = "float: right; max-width: 400px;">
<?php	
	if($_GET['level0']){
?>
		<!-- Hilfe aussage für Gerät Überblick -->
		<div class = "well"  style = " margin-top : 10px; ">
				<strong>Gerätverwaltung:</strong>

				<p style = "padding-left:15px">Bitte wählen Sie die Geräteliste von oben an die Benutzer des Geräts anzeigen</p>	
				
		</div>		
	
<?php
	}else if ($_GET['level1']){
?>	
		<!-- Hilfe aussage für Gerät Überblick -->
		<div class = "well"  style = " margin-top : 10px; ">
				<strong>Neue Gerät:</strong>

				<p style = "padding-left:15px">Benutzer können für dieses neue Gerät ausgewählt werden</p>	
				
		</div>
<?php	
	}else if($_GET['level3']){
?>
		<!-- Hilfe aussage für Gerät Löschen -->
		<div class = "well"  style = "margin-top : 10px; ">
				<strong>Lösen Gerät</strong>
				<p style = "padding-left:15px">Wählen Sie mindestens eine Gerät, um zu löschen</p>	
				
		</div>		

<?php	
	}
?>	
</div>
</div>
<!-- Hilfetext für Sitzung abgelaufen -->
<?php
}else if ($_SESSION['Error'] != "1") {
?>
		<div class="col-md-4 col-md-offset-4" style = "text-align:center">
			<div class = "">
				<strong><h3 class="text-danger">Sitzung abgelaufen</h3></strong> 
					<h4 class = "glyphicon glyphicon-hand-right"> <a href = "./"  style = "color:#808080">Ich will zurück zum Login</a></h4>	
			</div>	
		</div>		
<?php
}else if ($_SESSION['Error'] == "1"){
?>
		<!-- Hilfetext für Ungültiger Admin Login  -->
		<div class="col-md-4 col-md-offset-4" style = "text-align:center">
			<div class = "">
				<strong><h3 class="text-danger">Fehler: Ungültiger Admin Login </h3></strong> 
					<h4 class = "glyphicon glyphicon-hand-right"> <a href = "./"  style = "color:#808080">Zurück zu Login</a></h4>	
	 	    </div>	
	    </div>
<?php
}
?>

</div>
</body>
