<!-- 
	Diese datei zeigt den code für Benutzerverwaltung
		-> Gerät Überblick.
		-> Neue Benutzer. 
		-> Bearbeiten.
		-> Löschen Benutzer.
		-> Neue Abteilung.
		-> Bearbeiten Abteilung Name.
		-> Löschen Abteilung.
-->

<script type='text/javascript' src="AdminBenutzer.js"></script>
<?php
	require "Database.php";
	require "header.php";
	$db = new Database;
	$con = $db->connect();
	//$Admin = "admin";


// POST variablen aus AdminLogin.php 
if (($_POST['Fname'] && $_POST['Fkenwort']))
{
	$fname = $_POST['Fname'];
	$ken = ($_POST['Fkenwort']);
// Überprüfen sie '$fname' (Admin name) 
    if (($fname  == $db->Admin)||($_SESSION['Username'] == $db->Admin))
	{
		$where = "kenwort LIKE '$ken' AND login LIKE '$db->Admin'";
// Holen sie kennwort von Benutzer aus BemutzerLogin tabelle
		$loginquery = $db->select("BemutzerLogin", "kenwort", $where);
		if ($loginquery)
		{
			$dbkenwrt = $db->getResult();
			if ($dbkenwrt[0])
			{
				session_start();
// Session variablen
				$_SESSION['Username'] = $db->Admin;
			}else
				$_SESSION['Error'] = "1";
		}else
// Login ist nicht richtig 		
			$_SESSION['Error'] = "1";
	}else
		$_SESSION['Error'] = "1";
}
?>
<body style="background:#fff;margin:0;padding:0;font-family:arial, helvetica, sans-serif;fontsize:11px;" >
<a name="top"></a>
    <div id="header" style="float:left; width:100%; clear:both; height:160px; position:static; background:url(bilder/BG-Header.png) repeat-x center top #b50f1b; margin-bottom: 3px;">
		<div class = "logo">
			<a href="/">
				<img src = "bilder/logo.png"></img>
			</a>
		</div>
		
			

		<div class = "container">
			<div class ="mainlist" style = "text-align:center; padding-top:18px;">
				<div class = "col-sm-4" style = "float:left">
					<a href = "./User.php?level0=alleUser">BENUTZERVERWALTUNG</a>
				</div>
				<div class = "col-sm-4 ">
					<a href = "./Device.php?level0=alleUser">GERÄTEVERWALTUNG</a>
				</div>
				<div class = "col-sm-4 " style = "float:right">
					<a href = "./Drucker.php?level0=alleUser">DRUCKEN</a>
				</div>
			</div>
		</div>
	</div>


<?php
if ($_SESSION['Username'] == $db->Admin )  
{
// Alle Benutzer Name auswählen	
	$overview = $db->select("Gerat","Nummer"); 
	if ($overview)
		$no =  $db->getResult();

?>
<div class = "container-fluid" >
<div class = "row " id = "level3" >
<div class = "left_div col-xs-3" >
	<ul class = "list" style = "padding-left:30px;">
<!--Links Menü -->	
		<a href = "./User.php?level0=alleUser"><li class = "list-group-item"><img class = "userImage" src = "bilder/Overview.png">Überblick<span class = "badge"><?php echo count($no)?></span></img></li></a>
		<a href = "./User.php?level1=neueUser"><li class = "list-group-item"><img class = "userImage" src = "bilder/user.png">Neue benutzer</img></li></a>
		<a href = "./User.php?level2=modifyUser"><li class = "list-group-item"><img class = "userImage" src = "bilder/user.png">Bearbeiten</img></li></a>
		<a href = "./User.php?level3=deleteUser"><li class = "list-group-item"><img class = "userImage" src = "bilder/user.png">Löschen benutzer</img></li></a>
		<a href = "./User.php?level4=neueabt"><li class = "list-group-item"><img class = "userImage" src = "bilder/abteilung.png">Neue abteilung </img></li></a>
		<a href = "./User.php?level5=bearbeitenabt"><li class = "list-group-item"><img class = "userImage" src = "bilder/abteilung.png">Bearbeiten abteilung</img></li></a>
		<a href = "./User.php?level6=bearbeitenabt"><li class = "list-group-item"><img class = "userImage" src = "bilder/abteilung.png"></img>Löschen abteilung</li></a>
	</ul>
</div>

<!-- Neue benutzer HTML  -->
<div class = "middle_div col-xs-6">
<?php
// Gerät Überblick
	if($_GET['level0'])
	{

?>
		<!-- Div für Text and select tag -->
		<div class = "scrol_header ">
			<H3 class  = "title">Überblick</H3>
	<?php
			if($_GET['level0']) {
// Holen die alle Gerät Name 				
				$gerat = $db->select("Gerat", "Name","","Name Asc");
				if ($gerat)
					$geratresult = $db->getResult();
	?>
						<select class  = "selectpicker form-control" data-live-search = "True" onchange = "ChangeId(this)" style  = "cursor: pointer ;padding:5px">
						<option class  = "option_font_11" selected >Wählen Sie das Gerät hier</option>

	<?php
				for($i=0;$i< count($geratresult);$i++)
				{
// Alle Gerät Name anzeigen im select anweisung					
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

<!-- Div tag for Device and User table -->
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
// Neue Benutzer
	if ($_GET['level1'])
	{
// Holen alle Abteilung Name aus Abteilung Tabelle	
		$abt = $db->select("Abteilung" , "Name","","Name ASC");
		if($abt)
		{
			$abtresult = $db->getResult();
		}
// Holen alle Gerät Name aus Gerat Tabelle		
		$gerat = $db->select("Gerat","Name", "","Name ASC");
		if($gerat)
		{
			$geratres = $db->getResult();
		}
// Holen alle Abteilung Id aus Abteilung Tabelle			
		$abt = $db->select("Abteilung" , "Abteilung_Id","","Name ASC");
		if($abt)
		{
			$abtid = $db->getResult();
		}
// Holen alle Gerät Id aus Gerat Tabelle				
		$gerat = $db->select("Gerat","Nummer","","Name ASC");
		if($gerat)
		{
			$geratid = $db->getResult();
		}
//Holen der Benutzer Id aus Benutzer Tabelle	
		$res_sel = $db->select( "Benutzer", "Benutzer_Id", "");
		if ($res_sel) {
			$number = $db->getResult();
// Zählt der Benutzer vom '$number'	für Benutzer Sortieren
			$current_Id = $number[count($number)-1];

		}
?>
		<form class = "form-group" name = "neue_benutzer"action = "./User.php" method = "POST" onsubmit= "return benutzer_validate()">
			<dl class  = "UserDetails dl-horizontal">
				<h4 class  = "title">Füllen Sie die unten Details</h4>
				<br>

				<dt>Sortieren</dt>			
				<dd><input class="form-control input-sm"  type="text" size="20" value = <?php echo $current_Id+1 ?> disabled>
<!-- Sortieren hat nicht aktualisiert -->					
				<input   name = "neue_Benutzer_Id" type="text" size="50" value = <?php echo $current_Id+1 ?> hidden></dd>
				<br>
				<dt >Titel</dt>
				<dd><input  class="form-control input-sm" id = "neue_Titel"  name = "neue_Titel" type = "text" size = "20" placeholder="Titel" OnChange = "return FormTitelValidate(this)"></dd>
				<br>
				<dt>Vorname</dt>
				<dd><input  class="form-control input-sm" id = "neue_Vorname"  name = "neue_Vorname" type = "text" size = "80" placeholder="Vorname" OnChange = "return FormNameValidate(this)" ></dd>
				<br>
				<dt>Nachname</dt>
				<dd><input   class="form-control input-sm" id = "neue_Nachname"  name = "neue_Nachname" type = "text" size = "80" placeholder="Nachname"  OnChange = "return FormNameValidate(this)"></dd>
				<br>
<!-- Login Name für Benutzerkonto und sparen im benutzerLogin Tabelle-->				
				<dt>Loginame</dt>
				<dd><input class="form-control input-sm" id= "login_name" name = "login_name" type = "text" size = "80" placeholder="Login Name für Benutzerkonto " OnChange = "return FormLoginnameValidate(this)"></dd>
				<br>
				<dt>EMail</dt>
				<dd><input  class="form-control input-sm" id = "neue_EMail" name = "neue_EMail" type = "text" size = "80" placeholder="Email" ></dd>
				<br>
				<dt>Abteilung</dt>
				<dd>
					<select multiple  class = "selectpicker form-control"  data-actions-box="true" data-live-search = "true"  name = "neue_abt_user[]" id = "neue_abt_user" >
<?php
						for($i = 0; $i< count($abtresult);$i++)
						{
// Anzeige alle abteilung name 						
?>							<option class  = "option_font_9" value = "<?php echo $abtresult[$i] ?>"><?php echo $abtresult[$i] ?></option>
<?php
						}
?>					</select>
				</dd>
				<br>
				<dt>Gerät</dt>
				<dd>
					<select multiple  class = "selectpicker form-control"  data-actions-box="true" data-live-search = "true" name = "neue_gerat_user[]" id = "neue_gerat_user" >
<?php
						for($i = 0; $i< count($geratres);$i++)
						{
// Anzeige alle gerät name						
?>							<option class  = "option_font_9" value = "<?php echo $geratid[$i] ?>"><?php echo $geratres[$i] ?></option>
<?php
						}
?>					</select>
				</dd>
				<br>
				<dd colspan = "2"><input class = "btn btn-default" type = "submit" value = "Speichern"  >	</dd>
			</dl>
		</form>
<?php
	}
?>


<!-- INSERT-code für Neue Benutzer -->
<?php

	if($_POST['neue_Benutzer_Id'])
	{
		$db->startTransaction();
// INSERT anweisungen in die Benutzer tabelle
		$res_insert = $db->insert( "Benutzer", array($_POST['neue_Benutzer_Id'], $_POST['neue_Titel'], $_POST['neue_Vorname'], $_POST['neue_Nachname'], $_POST['neue_EMail']), "Benutzer_Id, Titel, Vorname, Nachname, Email");
// INSERT anweisungen in die BenutzerLogin tabelle		
		$login_insert = $db->insert("BemutzerLogin", array($_POST['login_name'], md5("kenwort"), $_POST['neue_Benutzer_Id']," "),"login, kenwort, Id, Login_Id");
		if (!$login_insert || !$res_insert)
		{
// wenn INSERT anweisung hat problem, bitte rollback die transaktion
			$db->rollbackTransaction();
?>			<div class="alert">
				<strong><img class = "dangerImage" src = "bilder/danger.png">Fehler: Benutzer Wert nicht eingefügt</img></strong>
				<br>
				<strong><a href = "./User.php?level1=neueUser">Zurück</a></strong>
			</div>
<?php
		}else {
// Wenn Abteilung werte für diese benutzer ausgewählt		
		if ( $res_insert && ($_POST['neue_abt_user']!= ""))
		{
// Zählen die werte der Abteilung
			$abt = count($_POST['neue_abt_user']);
// Holen die letzte Abteilung id wert aus Abteilung tabelle			
			$abt_sel = $db->select( "Abteilung", "Abteilung_Id", "", "");
			if ($abt_sel) {
				$number = $db->getResult();
				$abt_current_Id = $number[count($number)-1];
			}

			while($abt > 0){
				$abt--;
				$abt_current_Id++;
// INSERT anweisung mit alle Abteilung-Id wert ausgewählt 				
				$abt_insrt = $db->insert("Abteilung", array( $abt_current_Id, $_POST['neue_Benutzer_Id'], $_POST['neue_abt_user'][$abt] ) ,"Abteilung_Id, Benut_Id, Name");
				if ($abt_insrt!= True)
				{
// wenn INSERT anweisung probleme mit werten hat, bitte rollback die transaktion				
					$db->rollbackTransaction();
?>
					<div class="alert">
						<strong><img class = "dangerImage" src = "bilder/danger.png">Fehler: Benutzer Wert nicht eingefügt</img></strong>
						<br>
						<strong><a href = "./User.php?level1=neueUser">Zurück</a></strong>
					</div>
<?php

					//echo "Error at editing abteilung";
				}
			}

		}
// Wenn Gerät werte für diese benutzer ausgewählt
		if ($res_insert && ($_POST['neue_gerat_user']!= ""))
		{
// Zählen die werte der gerät
			$gerat = count($_POST['neue_gerat_user']);
			while($gerat > 0 ){
				$gerat--;
// INSERT anweisungen in die Verwender tabelle				
				$gerat_insrt = $db->insert("Verwenden", array("",$_POST['neue_Benutzer_Id'],$_POST['neue_gerat_user'][$gerat],"",""),"`Verwenden Id`, Benutz_Id, Gerat_nummer ,Von, Bis");
				if ($gerat_insrt!= True)
				{
// wenn INSERT anweisung probleme mit werten hat, Bitte rollback die Transaktion				
					$db->rollbackTransaction();
?>
					<div class="alert">
						<strong><img class = "dangerImage" src = "bilder/danger.png">Fehler: Benutzer Wert nicht eingefügt </img></strong>
						<br>
						<strong><a href = "./User.php?level1=neueUser">Zurück</a></strong>
					</div>
<?php
					//echo "Error at editing abteilung";
				}
			}

		}
// Commit-Transaktion wenn alle werte ist wahr		
		if(($res_insert && $res_abt && $res_ger) || ($res_insert && $res_abt && ($_POST['neue_Gerät'] == "")) ||($res_insert && ($_POST['neue_Gerät'] == "") && ($_POST['neue_Gerät']== "") ))
		{

			$db->commitTransaction();
?>
			<div class="alert">
				<strong><img class = "successImage" src = "bilder/success.png">Benutzer Wert eingefügt</img></strong>
				<br>
				<strong>Möchten Sie<a href = "./User.php?level4=neueabt"> neue Abteilung </a>  für diesen Benutzer zuordnen</strong>
			</div>
<?php
		}else {
// sonst Rollback-Transaktion		
?>
			<div class="alert">
				<strong><img class = "dangerImage" src = "bilder/danger.png">Fehler: Benutzer Wert nicht eingefügt</img></strong>
				<br>
				<strong><a href = "./User.php?level1=neueUser">Zurück</a></strong>
			</div>
<?php
			$db->rollbackTransaction();
		}
		}
	}
?>
<!-- ============================================== Ende der Neue benutzer ============================================-->

<?php	
// Bearbeiten Benutzer -III (UPDATE-anweisung)
	if($_POST['edit_nummer'])
	{
		$db->startTransaction();
// Benutzer Id		
		$id =  $_POST['edit_nummer'];
// Zurücksetzen kennwort für Benutzerkonto ist ausgewählt		
		$reset = $_POST['resetkenwort'];
		$login_where = " Id = ".$id." ";
// UPDATE-anweisung für Benutzer Tabelle.		
		if ($reset){
			$login_reset = $db->update("BemutzerLogin", array(kenwort), array(md5("kennwort")), $login_where );
		} 

// UPDATE-anweisung für Benutzer Tabelle.
		$where = " Benutzer_Id = ".$id." ";
		$benutz_update = $db->update("Benutzer",array(Titel,Vorname,Nachname,Email),array($_POST['edit_title'],$_POST['edit_vorname'],$_POST['edit_nachname'],$_POST['edit_email']), $where);

// Wenn Abteilung werte ist aktualisierten
		if ($benutz_update && $_POST['bearibeten_abt']){
			$where = "Benut_Id  = ".$id." ";
			$abt = count($_POST['bearibeten_abt']); 		
// Löschen sie alle actual abteilung-werte und neue werte aktualisieren			
			if ($abt>=1) 
			{
				$del = $db->delete("Abteilung",$where);
			}
			$abt_sel = $db->select( "Abteilung", "Abteilung_Id", "", "");
			if ($abt_sel) {
				$number = $db->getResult();
				$abt_current_Id = $number[count($number)-1];
			}
			while($abt > 0){
// Liste der abteilung			
				$abt--;            
// Für  Abteilung_Id in Abteilung Table
				$abt_current_Id++; 
// überspringen den Nullwert (Separator), wenn die ganze Abteilung ausgewählt werden
				if(strlen($_POST['bearibeten_abt'][$abt]) > 0) {
// INSERT-anweisung für Abteilung Tabelle mit neue werte				
					$abt_insrt = $db->insert("Abteilung", array( $abt_current_Id, $id , $_POST['bearibeten_abt'][$abt] ) ,	"Abteilung_Id, Benut_Id, Name");
					if ($abt_insrt!= True)
					{
// Probleme mit INSERT 			
						$db->rollbackTransaction();
?>
						<div class="alert">
							<strong><img class = "dangerImage" src = "bilder/danger.png">Fehler: Benutzername wird nicht aktualisiert	</img></strong>
							<br>
								<strong><a href = "./User.php?level2=modifyUser">Zurück</a></strong>
						</div>
<?php
					} 
				}
			} 
		} else { 
// Wenn Alle abteilung-werte werden gelöscht 	
			$where = "Benut_Id  = ".$id." ";
			$del = $db->delete("Abteilung",$where);
		}
// Wenn Gerät werte ist aktualisierten
		if ($benutz_update && $_POST['bearibeten_gerat']){
			$where  = "Benutz_Id = ".$id." ";
// Liste der Gerät			
			$great = count($_POST['bearibeten_gerat']); 
			if ($great >= 1)
			{
// Löschen sie alle actual gerät-werte und neue werte aktualisieren.				
				$del = $db->delete("Verwenden", $where);  
				if (!$del)
				{
// Probleme mit DELETE-anweisung				
					$db->rollbackTransaction();
?>
					<div class="alert">
						<strong><img class = "dangerImage" src = "bilder/danger.png">Fehler: Benutzername wird nicht aktualisiert</img></strong>
						<br>
						<strong><a href = "./User.php?level2=modifyUser">Zurück</a></strong>
					</div>
<?php
				}
			}  
			while($great > 0) {
				$great--;
// überspringen den Nullwert (Separator), wenn die ganze Abteilung ausgewählt werden
				if(strlen($_POST['bearibeten_gerat'][$great]) > 0) {
//INSERT-anweisung für Verwenden tabelle				
					$ver = $db->insert("Verwenden",array("", $id, $_POST['bearibeten_gerat'][$great], "","" ) ,"`Verwenden Id`, Benutz_Id, Gerat_nummer, Von,Bis");
					if ($ver!= True)
					{
// Probleme mit INSERT					
						$db->rollbackTransaction();
?>
						<div class="alert">
							<strong><img class = "dangerImage" src = "bilder/danger.png">Fehler: Benutzername wird nicht aktualisiert</img></strong>
							<br>
							<strong><a href = "./User.php?level2=modifyUser">Zurück</a></strong>
						</div>
<?php				}
				}
			} 

		}else { 
// Wenn alle werte werden gelöscht (Gerät werte)
			$where  = "Benutz_Id = ".$id." ";
			$del = $db->delete("Verwenden", $where);
		}
// nach Nachprüfen der informationen, Commit-Transaktion
		if ($benutz_update){
			$db->commitTransaction();
?>
			<div class="alert">
				<strong><img class = "successImage" src = "bilder/success.png">Benutzername wird aktualisiert</img></strong>
				<br>
				<br>
				<strong>Möchten Sie<a href = "./User.php?level5=bearbeitenabt"> Abteilungname </a> oder <a href = "./Device.php?level2=modifydevice"> Gerät Name </a> zu aktualisieren ?</strong>
			</div>
<?php
		}else{
//sonst Rollback-Transaktion
			$db->rollbackTransaction();
?>
			<div class="alert">
				<strong><img class = "dangerImage" src = "bilder/danger.png">Fehler: Benutzername wird nicht aktualisiert</strong>
				<br>
				<strong><a href = "./User.php?level2=modifyUser">Zurück</a></strong>
			</div>
<?php

		} 
	}

//  Bearbeiten benutzer - II (Benutzer werte)
	if ($_POST['suche_benut'])
	{
		$res_not_abt = array();
		$device_name = array();
		$device = array();
		$Geratall = array();
		$num = array();
// Benutzer Id		
		$suche_werte = ($_POST['suche_benut']); 

		$db->startTransaction();
//Abteilung-name nicht für diese Benutzer auswählen
		$query = mysql_query("Select distinct Name From Abteilung Where Name NOT IN (Select Name From Abteilung where Benut_Id = $suche_werte)");
		if ($query) {
			while($row = mysql_fetch_array($query))
			{
				array_push($res_not_abt, $row['Name']);
			}
		}

// Abteilung-name für diese benutzer auswählen
		$value_abt_name = $db->select("Abteilung","Name","Benut_Id = $suche_werte " );
		if ($value_abt_name){
			$res_abt_name = $db->getResult();
		 }

//Login-name für diese benutzer auswählen
		$login = $db->select("BemutzerLogin","login","Id = $suche_werte ");
		if ($login){
			$res_login = $db->getResult();
		}

// Gerät-Name und Gerät-Id nicht für diese Benutzer auswählen
		$value_device_not_num = mysql_query("Select Name, Nummer  From Gerat Where Nummer NOT IN (Select Gerat_nummer From Verwenden Where Benutz_Id = $suche_werte)");
		if ($value_device_not_num)
		{
			while($row = mysql_fetch_array($value_device_not_num))
			{
				array_push($device_name, $row['Name']);
				array_push($device, $row['Nummer']);
			}
		} 
// Gerät-Name und Gerät-Id für diese Benutzer auswählen
		$value_device_num = mysql_query("Select Name, Nummer  From Gerat Where Nummer IN (Select Gerat_nummer From Verwenden Where Benutz_Id = $suche_werte)");
		if ($value_device_num)
		{
			while($row = mysql_fetch_array($value_device_num))
			{
				array_push($Geratall, $row['Name']);
				array_push($num, $row['Nummer']);
			}
		} 

// Benutzer-Information auswählen
		$value = $db->select("Benutzer","*"," Benutzer_Id = $suche_werte" );
		if($value) {
			$res = $db->getResult();
?>
		<form action = "./User.php" name = "bbenutzer"method = "POST" onsubmit = "return bbenutzer_validate()">
			<dl class  = "UserDetails dl-horizontal">
				<H4 class = "title">Bearbeiten</H4>
				<br>
				<dt >Titel</dt>
				<dd><input class="form-control input-sm" type = "text" size = "20px" name = "edit_title" id = "edit_title" value = "<? echo $res[1]?>" OnChange = "return FormTitelValidate(this)">
				<input type = "text" size = "20px" name = "edit_nummer" id = "edit_nummer" value = "<? echo $res[0]?>" hidden></dd>
				<br> <!-- $res[0] ist benutzer Id für POST variable -->
				<dt>Vorname</dt>
				<dd><input class="form-control input-sm" type = "text" size = "70px" name = "edit_vorname" id = "edit_vorname" value = "<? echo $res[2]?>" OnChange = "return FormNameValidate(this)"></dd>
				<br>
				<dt>Nachname</dt>
				<dd><input class="form-control input-sm" type = "text" size = "70px" name = "edit_nachname" id = "edit_nachname" value ="<? echo $res[3]?>" OnChange = "return FormNameValidate(this)"></dd>
				<br>
<!-- Login Name - Disabled -->				
				<dt>Loginname</dt>
				<dd><input   class="form-control input-sm"  name = "edit_loginname" id = "edit_loginname" type = "text" size = "80" value = "<?php echo $res_login[0] ?>"  disabled></dd>
				<br>
				<dt>EMail</dt>
				<dd><input class="form-control input-sm" type = "text" size = "70px" name = "edit_email" id = "edit_email" value = "<? echo $res[4]?>" OnChange = "return bb_Form_validte(this)"></dd>
				<br>
				<dt>Abteilung</dt>
				<dd>
					<select multiple  class = "selectpicker form-control"  data-actions-box="true" data-live-search = "true"  name = "bearibeten_abt[]" id = "bearibeten_abt">
<?php
						for($i = 0;($i < count($res_abt_name) &&($res_abt_name[$i] != "")); $i++) {
// Anzeigen Abteilungname nur für diesen Benutzer
?>
							<option  class  = "option_font_9" value = "<?php echo  $res_abt_name[$i] ?>" selected> <?php echo $res_abt_name[$i] ?></option>
<?php					}
?>
							<option role="separator" class="divider"></option>

<?php						for($i = 0;($i < count($res_not_abt) && ($res_not_abt[$i] != "")); $i++){
// Anzeige alle andere Abteilungname
?>
							<option class  = "option_font_9" value = "<?php echo  $res_not_abt[$i] ?>"><?php echo  $res_not_abt[$i]?></option>
<?php
						}
?>
					</select>
				</dd>
				<br>
				<dt>Gerät</dt>
				<dd>
					<select multiple  class = "selectpicker form-control"  data-actions-box="true" data-live-search = "true"  name = "bearibeten_gerat[]" id = "bearibeten_gerat">
<?php
						for($i = 0;$i < count($Geratall); $i++){
// Anzeigen Gerätname nur für diesen Benutzer
?>
							<option class  = "option_font_9" value = "<?php echo  $num[$i] ?>" selected> <?php echo  $Geratall[$i] ?></option>
<?php
						}
?>
							<option role="separator" class="divider"></option>
<?php
						for($i = 0;$i < count($device_name); $i++) {
// Anzeige alle andere Gerätname 
?>
							<option  class  = "option_font_9" value = "<?php echo  $device[$i] ?>" > <?php echo  $device_name[$i] ?></option>
<?php					}
?>
					</select>
				</dd>
				<br>
				<dd>
					<input type = "Checkbox" name = "resetkenwort" id = "resetkenwort" title = "kenwort is set to default kenwort">&nbsp <strong>Zurückstellen kennwort für Benutzerkonto</strong>
				</dd>
				<br>
				<dd colspan = "2">
					<input class = "btn btn-default btn-sm dropdown-toggle" type = "submit" value = "Speichern"  >
				</dd>
			</dl>
		</form> <!-- Bearbeiten benutzer -->

<?php
		} // $value
	} // $_POST['suche_benut']
?>


<!-- Bearbeiten benutzer HTML -I (Benutzer auswählen) -->
<?php
	if ($_GET['level2'])
	{
// Holen Sie den benutzer name aus Benutzer Tabelle
		$res_user = $db->selectname("Benutzer","");
		if($res_user)
		{
			$suche_user = $db->getBenutzername(); // Benutzer Name
			$suche_id = $db->getResult();		// Benutzer Id
		}
?>
		<form name = "busr" onsubmit = "return bbnu_validate()" action = "./User.php?" method = "POST"  style = "text-align:center">
			<div class = "form-group"  >
				<h4 class = "title">Benutzername Bearbeiten</h4>
				</br>
				<select class=" selectpicker form-control"     data-live-search = "true"  name = "suche_benut"  id  = "suche_benut">
					<option class  = "option_font_10" value  = "">Benutzername</option>
<?php
					for($i = 0;(($i <= count($suche_user)) && ($suche_user[$i]!= "")); $i++)
					{  
// Alle Benutzername anzeigen 
?>
						<option class  = "option_font_10" value = "<?php echo $suche_id[$i]?>" ><?php echo $suche_user[$i]?></option>
<?php				}
?>				</select>
			</div>	<!-- form-group -->
			</br>
			<input class = "btn btn-default" type = "submit" value = "Anfrage senden"  >
		</form>
<?php
	} //$_GET['level2']
?>
<!-- ===============================================Ende der Benutzer-Bearbeiten ============================================-->

<?php
// POST variablen für Löschen Sie die Benutzer
	if ($_POST['suche_benutzer2'])
	{
		$del_rollback  = false;
// Array - Bernutzer Id's		
		$del_user =  $_POST['suche_benutzer2'];   
// Count of Bernutzer Id's		
		$del_user_count = count($_POST['suche_benutzer2']);  
		if ($del_user_count > 0)
		{
			$db->startTransaction();
			do
			{
// DELETE-anweisung für Benutzer
				$where = "Benutzer_Id = ".$del_user[--$del_user_count]." ";
				$del_res = $db->delete("Benutzer",$where);
				if (!$del_res) {
// für Rollback-Transaktion
					$del_rollback = true;
				}
			}while($del_user_count != 0);
// Überprüfung die Wert "$del_rollback" && $del_res und Commit
			if ($del_res && !$del_rollback ) {
				$db->commitTransaction();
?>
				<div class="alert">
					<strong><img class = "successImage" src = "bilder/success.png">Benutzername aus der Datenbank gelöscht</img></strong>
					</br>
					<strong> Möchten Sie<a href = "./Device.php?level3=deletedevice"> Gerät  </a>oder <a href = "./User.php?level6=bearbeitenabt"> Abteilung </a> zu löschen ? </strong>
				</div>
<?php
			}
			else {
//sonst rollback-Trasaktion			
				$db->rollbackTransaction();
?>
				<div class="alert">
					<strong><img class = "dangerImage" src = "bilder/danger.png">Fehler: Benutzername nicht aus der Datenbank gelöscht</img></strong>
					<br>
					<strong><a href = "./User.php?level3=deleteUser">Zurück</a></strong>
				</div>
<?php

			}
		}

	}

// Löschen Sie die Benutzer
	if ($_GET['level3'])
	{
// Holen Sie der Benutzer Name aus Benutzer Tabelle
		$res_user = $db->selectname("Benutzer","");
		if($res_user)
		{
			$suche_user = $db->getBenutzername();	// Benutzer Name
			$suche_id = $db->getResult();   // Benutzer Id
		}
?>
	<form action = "./User.php?" method = "POST"  style = "text-align:center">
		<div class = "form-group" >
			<h4 class = "title">Benutzername Löschen</h4>
			</br>
			<select multiple  class = "selectpicker form-control"  data-actions-box="true" data-live-search = "true" name = "suche_benutzer2[]" id = "suche_benutzer2" >
<?php
		for($i = 0;(($i < count($suche_user) && ($suche_user[$i]!= " "))); $i++)
		{ 
//alle Benutzer Name anzeigen

?>
				<option class  = "option_font_10" data-tokens= "<?php echo $suche_user[$i]?>" value = "<?php echo $suche_id[$i]?>" ><?php echo $suche_user[$i]?></option>
<?php
		}
?>
			</select>
			</br>
			</br>
			<input class = "btn btn-default" type = "submit" value = "Lösen"  >
		</div> <!-- form-group -->
	</form> <!-- Löschen Sie die Benutzer  -->
<?php
	} // $_GET['level3']
?>


<!-- ===============================================Ende der Benutzer-Bearbeiten ============================================-->


<?php
/* POST variblen für Neue Abteilung und Benutzer */
	if($_POST['neue_abteilung'] || $_POST['vorname_abt'])
	{
		$abt = $_POST['neue_abteilung'];
// Liste der Benutzer Name.
		$no_vorname = count($_POST['vorname_abt']);
		if (!$abt)
		{ 
// AbteilungName nicht angegeben
?>
			<div class="alert">
				<strong><img class = "dangerImage" src = "bilder/danger1.png">Fehler: Abteilungname nicht angegeben</img></strong>
				<br>
				<strong><a href = "./User.php?level4=neueabt">Zurück</a></strong>
			</div>	<!-- alert: Abteilung Name nicht angegeben -->
<?php
		}else if ($no_vorname == 0) { 
//Benutzername ist nicht in der Liste ausgewählt*/
?>
			<div class="alert">
				<strong><img class = "dangerImage" src = "bilder/danger.png">Fehler: Mindestens ein Benutzer muss unter abteilung wählen</img></strong>
				<br>
				<strong><a href = "./User.php?level4=neueabt">Zurück</a></strong>
			</div>	<!-- alert: Mindestens ein Benutzer muss unter abteilung wählen -->

<?php	}else if ($abt && $no_vorname) {
// Abteilung und Benutzer name ist angegeben
			if ($abt) {
				$query = mysql_query( "Select Distinct Name from Abteilung where Name  Like '$abt' ") ;
				if (mysql_fetch_row($query))
				{ 
/* selected Abteilung name is found in database  || ausgewählten Abteilung Name in der Datenbank gefunden*/
?>
					<div class="alert" style = "background-color:red">
						<strong><img class = "dangerImage" src = "bilder/danger.png">Fehler: Abteilung bereits vorhanden ist</img></strong>
						<br>
						<strong><a href = "./User.php?level4=neueabt">Zurück</a></strong>
					</div>	<!-- alert: Abteilung bereits vorhanden ist -->

<?php
				}else {	
/* selected Abteilung name is not found in database  || ausgewählten Abteilung Name nicht in der Datenbank gefunden*/
					$abt_id  = $_POST['neue_abteilung_id'];
// Legen Sie neue Abteilung mit Benutzer-ID als neuer Wert in Abteilung Table
					while ($no_vorname > 0)
					{
						$no_vorname--; 
//INSERT-anweisung für Abteilung						
						$neu_abt = $db->insert("Abteilung", array($abt_id,$_POST['vorname_abt'][$no_vorname],$_POST['neue_abteilung']),"Abteilung_Id, Benut_Id, Name");
						$abt_id++;
					}
					if ($neu_abt) 
/* New Abteilung is inserted in database || Neue Abteilung in Datenbank eingefügt */
					{
?>
						<div class="alert">
							<strong><img class = "successImage" src = "bilder/success.png">Neues Abteilung hinzugefügt</img></strong>
							<br>
							<br>
							<strong>Möchten Sie<a href = "./Device.php?level1=neuedevice" > Neue Gerät </a> oder <a href = "./User.php?level1=neueUser" > Neue Benutzer </a> zu hinzufügen? </strong>
						</div>	 <!-- alert: Neues Abteilung hinzugefügt -->
<?php
					}else { 
/* New Abteilung is not inserted in database || Neue Abteilung in Datenbank nicht eingefügt */
?>
						<div class="alert">
							<strong><img class = "dangerImage" src = "bilder/danger.png">Fehler: Neues Abteilung nicht hinzugefügt	</img></strong>
							<br>
							<strong><a href = "./User.php?level4=neueabt">Zurück</a></strong>
						</div> <!-- alert: Neues Abteilung nicht hinzugefügt -->
<?php
					} // neu_abt
				}// check für mysql_fetch_row($query)
			}// check für $_POST['neue_abteilung']
		} // $abt && $no_vorname
	} // POST variblen für Neue Abteilung und Benutzer

	
	// Neue Abteilung
	if ($_GET['level4'])
	{
// SELECT-anweisung für Benutzer name
		$res_user = $db->selectname("Benutzer","");
		if($res_user)
		{
			$suche_user = $db->getBenutzername(); // Benutzer Name
			$suche_id = $db->getResult(); // Benutzer Id
		}

?>
	<form action = "./User.php?" name ="neue_abt" onsubmit = "return abt_validate()" method = "POST" style = "text-align:center">
		<div class ="form-group">
				<h4 class = "title">Neue Abteilung</h4>
				</br>
				<div class = "form-group">
				<label style = "float: left" >Benutzer:</label> </br>
					<select class=" selectpicker form-control"  multiple data-actions-box="true"    data-live-search = "true"  name = "vorname_abt[]"  id  = "vorname_abt">
<?php
					for($i = 0;(($i <= count($suche_user)) && ($suche_user[$i]!= "")); $i++) 
					{
// anzeigen Benutzer Name
?>
						<option class  = "option_font_11" value = "<?php echo $suche_id[$i]?>" ><?php echo $suche_user[$i]?></option>
<?php
					}
?>
					</select>

				</div> <!-- form-group -->
				<label style = "float: left" >Abteilung:</label> </br>
				<input type="text" class="form-control" name = "neue_abteilung" id="neue_abteilung" placeholder="Abteilung Name" onchange = "return FormAbtNameValidate(this)">
<?php
//holen sie die Abteilung-Id für neue Abteilung
		$res_sel = $db->select("Abteilung", "Abteilung_Id");
		if ($res_sel) {
			$number = $db->getResult();
			$current_Id = $number[count($number)-1];
?>
				<input type="text"  name = "neue_abteilung_id" id="neue_abteilung_id" value = "<?php echo $current_Id+1?>" hidden>
<?php
		} // $res_sel
?>
				</br>
				<input class = "btn btn-default" type = "submit" value = "Speichern"  >
				</br>
		</div>	<!--  form-group -->
	</form> <!--  Neue Abteilung -->
<?php
	} // $_GET['level4']
?>


<!-- ===============================================Ende der Neue Abteilung ============================================ -->


<?php
    // POST Variablen für Bearbeiten Abteilung (UPDATE-anweisung)
	if($_POST['modified_abt'] && $_POST['modified_abt_id'])
	{
		$neue_value = $_POST['modified_abt'];
		$old_value = $_POST['modified_abt_id'];
		$where = "Name =  "."'$old_value'" ;
//UPDATE-anweisung
		$up_abt = $db->update("Abteilung",array("Name"), array($neue_value)  , $where);
		if ($up_abt)
		{
// Abteilungname wurde aktuvalisiert		
?>
			<div class="alert">
				<strong><img class = "successImage" src = "bilder/success.png">Abteilung Bezeichnung wird aktualisiert</img></strong>
				<br>
				<br>
				<strong>Möchten Sie der<a href = "./User.php?level2=modifyUser"> Benutzername </a> oder <a href = "./Device.php?level2=modifydevice">die Geräte Name </a> zu Update ?</strong>
			</div>	<!--alert:Abteilung Bezeichnung wird aktualisiert -->
<?php
		}else {
// Abteilungname wurde nicht aktuvalisiert		
?>
			<div class="alert">
				<strong><img class = "dangerImage" src = "bilder/danger.png">Fehler: Abteilung Bezeichnung nicht wird aktualisiert</img></strong>
				<br>
				<p><a href = "./User.php?level5=bearbeitenabt">zurück</a></p>
			</div>	<!--alert:Abteilung Bezeichnung nicht wird aktualisiert  -->
<?php
		} 
	} 

// POST Variablen für Bearbeiten Abteilung
	if($_POST['modify_abt']!= "Abteilung Name")
	{
//Holen Sie die wert(Abteilungname)	
		$value = $_POST['modify_abt'];
		if($value!= "")
		{
?>
		<form  action = "./User.php?" name = "bb_abt" method = "POST" style = "text-align: center" onsubmit = "return babtname_validate()">
			<h4 class = "title">Bearbeiten</h4>
			</br>
			<dl>
<!--Anzeig die wert zu bearbeiten AbteilungName-->			
				<dt><p class = "medium"><?php echo $value ?></p></dt>
				<dd><input  class="form-control"  name ="modified_abt" id = "modified_abt"  placeholder="Bearbeiten  <?php echo $value ?>" onchange = " return FormAbtNameValidate(this)">
				<input value ="<?php echo $value ?>" class="form-control sr-only" name ="modified_abt_id" id = "modified_abt_id" type = "text" ><dd>
				<br>
				<dd><input class = "btn btn-default" type = "submit" value = "Speichern"></dd>
			</dl>
		</form> <!--Bearbeiten Abteilung-->

<?php
		} // $value!= ""
	} //$_POST['modify_abt']!= "Abteilung Name"
?>


<?php
// Bearbeiten Abteilung - I
	if ($_GET['level5'])
	{
// Alle Abteilung Name auswählen
		$abt_name = $db->select("Abteilung" , "Name", ""," Name ASC");
		if($abt_name)
		{
			$abtresult = $db->getResult();
		}// $abt_name

// Alle Abteilung Id auswählen
		$abt_id = $db->select("Abteilung" , "Abteilung_Id", ""," Name ASC");
		if($abt_id)
		{
			$abtid = $db->getResult();
		} // $abt_id
?>
		<form action = "./User.php?" name = "b_abt"  method = "POST"  style = "text-align:center" onsubmit = "return babt_validate()" >
			<div class = "form-group" >
				<h4 class = "title">Abteilungname Bearbeiten</h4>
				</br>
				<select class  = " selectpicker form-control"  data-live-search = "true"  name = "modify_abt" id = "modify_abt" >
						<option class  = "option_font_10" >Abteilungname</option>
<?php
					for($i = 0;(($i < count($abtid)) && ($abtresult[$i] != "")); $i++)
					{
// Anzeigen Sie die Abteilung Name					
?>
						<option class  = "option_font_10" value = "<?php echo $abtresult[$i]?>" ><?php echo $abtresult[$i]?></option>
<?php
					}
?>
				</select>
			</div> 	 <!-- form-group-->
			</br>
			<input class = "btn btn-default" type = "submit" value = "Anfrage senden"  >
		</form>	 <!-- Bearbeiten Abteilung -->

<?php
	}
?>
<!-- =============================================== Ende der Bearbeiten Abteilung ============================================ -->	
<?php
	// Post variablen für Lösen Abteilung
	if ($_POST['del_abt'])
	{
		$del_rollback  = false;
		$del_abt =  $_POST['del_abt'];
		$del_abt_count = count($_POST['del_abt']);
		if ($del_abt_count > 0)
		{
			$db->startTransaction();
			do
			{
				$temp = $del_abt[--$del_abt_count];
				$where = "Name = "."'$temp'";
				$del_res = $db->delete("Abteilung",$where);
				if (!$del_res) {
// für Rollback-Transaktion
					$del_rollback = true;
				}
			}while($del_abt_count != 0);
			if ($del_res && !$del_rollback ) {
//Alle werte wurde gelöscht			
				$db->commitTransaction();
?>
				<div class="alert">
					<strong><img class = "successImage" src = "bilder/success.png">Abteilung gelöscht</img></strong>
					<br>
					<br>
					<strong>Möchten Sie bestehende <a href = "./User.php?level2=modifyUser"> Benutzer </a> oder <a href = "./Device.php?level3=deletedevice">Geräte </a> zu löschen?</strong>
				</div>	<!-- alert: Abteilung gelöscht  -->
<?php
			}else {
//Alle werte wurde nicht gelöscht 				
				$db->rollbackTransaction();
?>
				<div class="alert">
					<strong><img class = "dangerImage" src = "bilder/danger.png">Fehler: Abteilung nicht gelöscht</img></strong>
					<br>
					<strong><a href = "./User.php?level6=bearbeitenabt">Zurück</a></strong>
				</div>	 <!-- alert: Abteilung nicht gelöscht  -->
<?php
			} 
		} 
	} 
// Löschen die Abteilung
	if ($_GET['level6'])
	{
// Abteilung Name auswählen	
		$res_del = mysql_query("select Distinct(Name) From Abteilung ORDER BY Name ASC");
?>
		<form action = "./User.php?" method = "POST"  style = "text-align:center">
			<div class = "form-group">
				<h4 class = "title">Abteilungname Löschen</h4>
				</br>
				<select multiple  class = "selectpicker form-control"  data-actions-box="true" data-live-search = "true"  name = "del_abt[]" id = "del_abt" >
<?php
					while($abt = mysql_fetch_array($res_del))
					{
// Anzeigen Sie die Abteilung Name 					
?>
						<option class  = "option_font_10"value = "<?php echo $abt['Name']?>" ><?php echo $abt['Name']?></option>
<?php
					}
?>
				</select>
				</br>
			</div> <!-- form-group  -->
			<input class = "btn btn-default" type = "submit" value = "Lösen"  >
		</form> 
<?php
	} // Lösen Abteilung
?>
</div>


<!-- =============================================== Ende der Löschen Abteilung ============================================ -->


<!-- Rechts Menü -->	
<div class  = "div_logout col-xs-3" style = "float:right" >
<?php
// Benutzer Abmelden
	if($_SESSION['Username'] = $db->Admin) {
?>
				<div class = "well" >
				<H4 style = "text-align:center">Benutzer: <?php echo  $_SESSION['Username'];?></H3>
				<a href = "./Logout.php"><p class = "Abmelden" >Abmelden</p></a>
		</div>
<?php
	}
?>
</div> <!-- col-xs-3 -->
<!--Hilfe text-->
<div class = "col-xs-3 " style = "float: right; max-width: 400px;">

<?php
// Hilfe Text für Neue Benutzer
	if($_GET['level1']) {
?>
		<div class = "well"  style = "margin-top : 10px;" >
				<strong>Login Name :</strong>
					<p style = "padding-left: 15px">Kann später nicht mehr geändert werden</p>

				<strong>Standard-Kenwort für Benutzer:</strong>
					<p style = "padding-left: 15px">kennwort</p>
				<strong>Neue Abteilung :</strong>
				<ul>
					<li style = "padding-left: 15px">- Speichern Sie die Benutzerdetails, ohne Abteilung</li>
					<li style = "padding-left: 15px">- Zum 	<a href = "./User.php?level4=neueabt"> Neue Abteilung </a> und wählen Sie den Benutzer aus der Liste </li>
				</ul>
				<strong>Neue Gerät :</strong>
				<ul>
					<li style = "padding-left: 15px">- Details von <a href = "./Device.php?level1=neuedevice"> New Gerät </a>muss zuerst hier gespeichert werden </li>
				</ul>
		</div> <!-- well -->
<?php
	}else if($_GET['level2'] || $_POST['suche_benut']){
// Hilfe Text für Bearbeiten Benutzer	
?>
		<div class = "well"  style = "margin-top : 10px;">
				<strong>Bearbeiten :</strong>
				<ul>
					<li style = "padding-left:15px">- Ändern Benutzer Informationen</li>
					<li style = "padding-left:15px">- Passwort zurücksetzen für Benutzerkonto, um Standard-Passwort </li>
					<li style = "padding-left:15px">- Standard-kennwort ist <strong>kennwort<strong></li>
				</ul>
		</div>		<!-- well -->

<?php
	}else if($_GET['level0']){
// Hilfe Text für Gerät Uberblick
?>
		<div class = " well" style = "margin-top : 10px;"  >
				<strong>Gerätverwaltung:</strong>

				<p style = "padding-left:15px">Bitte wählen Sie die Geräteliste von oben an die Benutzer des Geräts anzeigen</p>

		</div>	<!-- well -->

<?php
	}else if($_GET['level3']){
// Hilfe Text für Loschen Benutzer	
?>
		<div class = " well"  style = "margin-top : 10px;" >
				<strong>Löschen Benutzer</strong>
				<p style = "padding-left:15px">Wählen Sie einen oder mehrere Benutzer, um zu löschen</p>

		</div>	<!-- well -->

<?php
	}else if($_GET['level4']){
// Hilfe Text für Neue Abteilung
?>
		<div class = " well" style = "margin-top : 10px;"  >
				<strong>Abteilung</strong>
				<p style = "padding-left:15px">Mindestens einen Benutzer sollte unter neuen Abteilung ausgewählt werden</p>

		</div>	<!-- well -->
<?php
	}else if($_GET['level6']){
// Hilfe Text für Loschen Abteilung	
?>
		<div class = "well" style = "margin-top : 10px;" >
				<strong>Lösen Abteilung</strong>
				<p style = "padding-left:15px">Wählen Sie mindestens eine Abteilung, um zu löschen</p>

		</div> <!-- well -->

<?php
	}
?>
</div> <!-- col-xs-3  -->
</div> <!-- row -->
<?php
// Hilfe Text für Sitzung abgelaufen
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
// Hilfe Text für Ungültiger Admin Login 
		$_SESSION['Error'] = "";
?>
		<div class="col-md-4 col-md-offset-4" style = "text-align:center">
			<div class = "">
				<strong><h3 class="text-danger">Fehler: Ungültiger Admin Login </h3></strong>
					<h4 class = "glyphicon glyphicon-hand-right"><a href = "./"  style = "color:#808080"> Zurück zu Login</a></h4>
	 	    </div>
	    </div>
<?php
}
?>
</div> <!-- Container -->
</body>