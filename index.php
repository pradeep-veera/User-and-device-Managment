	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de-de" lang="de-de">

	<head>
		<meta http-equiv="X-UA-Compatible" content="text/html; charset=iso-8859-1" />
		<title>Geräteverwaltung PRO Klinik Holding GmbH</title>
		<link rel="shortcut icon" href=" " type="image/x-icon" />
	</head>
		<link rel="stylesheet" href="styles.css" type="text/css">
		<link rel="stylesheet" type = "text/css" href="bootstrap/bootstrap-select/bootstrap-select.css">
		<link href="bootstrap/css/bootstrap.css" media="screen" rel="stylesheet" type="text/css">
		<link href="bootstrap/css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css">	
		<link href="bootstrap/css/bootstrap-theme.css" media="screen" rel="stylesheet" type="text/css">	
		<link href="bootstrap/css/bootstrap-theme.min.css" media="screen" rel="stylesheet" type="text/css">	

	<script type='text/javascript' src="Benutzer.js"></script>
	<script type="text/javascript" src="bootstrap/jquery.js"></script>
	<script type='text/javascript' src="bootstrap/js/bootstrap.min.js"></script>
	<script type='text/javascript' src="bootstrap/bootstrap-select/bootstrap-select.min.js"></script>
	<!--script type="text/javascript" src="jquery-ui-multiselect-widget-master/src/jquery.multiselect.js"></script-->

	<body style="background:#fff;margin:0;padding:0;font-family:arial, helvetica, sans-serif;fontsize:11px;" >
	<a name="top"></a>
		<div id="header" style="float:left; width:100%; clear:both; height:160px; position:static; background:url(bilder/BG-Header.png) repeat-x center top #b50f1b; margin-bottom: 3px;">
			<div class = "logo">
				<a href="/">
					<img src = "bilder/logo.png"></img>	
				</a>
			</div>
		</div>	
		
	<?php 
		require "Database.php";
		$db = new Database;
		$con = $db->connect();
		$default = md5("kennwort");
		// check for Login name and password
		if ($_POST['Bname'] && $_POST['Bkenwort'])
		{
			$givenName = $_POST['Bname'];
			$givenKenwort = md5($_POST['Bkenwort']);
			$Userquery = mysql_query("Select login, Kenwort, Id From BemutzerLogin where login LIKE '$givenName' AND kenwort LIKE '$givenKenwort'");
			if ($row = mysql_fetch_array($Userquery))
			{
				$Username = $row["login"];
				$kenwort = $row["Kenwort"];
				$UserId = $row["Id"];
				session_start();
				// Initiate session variables
				$_SESSION['User'] = $Username;
				$_SESSION['Id'] =  $UserId;
				$_SESSION['ken'] = $kenwort;				
			} // $row = mysql_fetch_array($Userquery)
			else {
				$_SESSION['Error'] = "1";
			}
		} // $_POST['Bname'] && $_POST['Bkenwort']	
		
	if ($_SESSION['User']) {

		$overview = $db->select("Gerat","Nummer"); 
			if ($overview)
				$no =  $db->getResult();
	?>	
	<div class = "container-fluid">

<div class = "row" id = "level3">	
	<div class = " left_div col-xs-3">
		<ul class = "list" style = "padding-left:30px;">
			<a href = "./index.php?level0=User"><li class = "list-group-item"><img class = "userImage" src = "bilder/Overview.png">Überblick<span class = "badge"><?php echo count($no)?></span></img></li></a>
			<a href = "./index.php?level1=bearbeitenUser"><li class = "list-group-item"><img class = "userImage" src = "bilder/user.png">Meine Information</img></li></a>
			<a href = "./index.php?level2=kenwort"><li class = "list-group-item"><img class = "userImage" src = "bilder/user.png">Kennwort ändern</img></li></a>
<?php   
			if ($_SESSION['ken'] != $default){
?>			
			<a href = "./Benutzer_certificate.php?level3=<?php echo $_SESSION['Id']?>"><li class = "list-group-item"><img class = "userImage" src = "bilder/user.png">Drucken</img></li></a>
<?php
			}
?>			
		</ul>	
	</div>
	<div class = "middle_div col-xs-6" >
	<?php 
		// User to update the password
		if(($_POST['current_kenwort'] && $_POST['neue_kenwort'] && $_SESSION['Id']) || ($_SESSION['ken'] == $default && $_POST['neue_kenwort']))
		{
			$id  = $_SESSION['Id'];
			$old = md5($_POST['current_kenwort']);
			$where = "Id =  $id" ;
			if ($_SESSION['ken'] != $default){	
				// Get the current login details of the user
				$query = $db->select("BemutzerLogin","kenwort", $where);
				if ($query){
					$check = $db->getResult();
				}
			}// $_SESSION['ken'] != $default
			// Update the new password for the user	
			if (($check[0] == $old) || $_SESSION['ken'] == $default){	
				$neue = md5($_POST['neue_kenwort']);
				$update_kenwort = $db->update("BemutzerLogin",array("kenwort"), array($neue) , $where);
				if ($update_kenwort) {
					$_SESSION['ken'] = $neue;
	?>		
					<div class="alert ">
						<strong><img class = "successImage" src = "bilder/success.png">Kennwort aktualisiert</img></strong> 
						<p><?php die(mysql_error());?><p>
					</div>		
	<?php		} else{
	?>				<div class="alert ">
						<strong><img class = "dangerImage" src = "bilder/danger.png">Fehler: Kennwort nicht aktualisiert</img></strong> 
						<p><?php die(mysql_error());?><p>
					</div>		
	<?php	
				}
			} // ($check[0] == $old) || $_SESSION['ken'] == $default
			else {
	?>			
				<div class="alert ">
					<strong><img class = "dangerImage" src = "bilder/danger.png">Fehler: Aktuelles Kennwort nicht richtig</img></strong> 
					<p><?php die(mysql_error());?><p>
				</div>		
	<?php				
			}
		}
		// Display the form when password is default-password.
		if(($_GET['level2'])||($_SESSION['ken'] == $default)){
	?>
			<H3 class  = "title">Benutzer kennwort</H3>
			<br>
			<div class = "scrol_overview">
				<form name = "andre_kenn" class = "form-group" method = "POST" action= "./" onsubmit = "return Validate(this)">
					<dl class  = "UserDetails dl-horizontal">	
						<dt>Benutzer :</dt>
						<dd><?php echo $_SESSION['User']?></dd>
						<br>
	<?php	// Since 1st login only have default password			
			if ($_SESSION['ken'] != $default){	
	?>			
						<dt>Aktuelles Kennwort  :</dt>
						<dd><input  class="form-control"  name ="current_kenwort" id = "current_kenwort"  placeholder="Kennwort " type = "Password"></dd>
	<?php 	} // ($_SESSION['ken'] != $default)  ?>					
						<br>
						<dt>Neue Kennwort :</dt>
						<dd><input  class="form-control"  name ="neue_kenwort" id = "neue_kenwort"  placeholder="Kennwort" type  = "Password"></dd>
						<br>
						<dd><input class = "btn btn-default" type = "submit" value = "Speichern"></dd>							
						
					</dl>	
				</form>
			</div>
	<?php
		}// ($_GET['level2'])||($_SESSION['ken'] == $default)
		
		if ($_GET['level0'] && $_SESSION['ken']!= $default)
		{
			$device = mysql_query("Select concat(Titel,' ' ,Vorname,' ' ,Nachname) As UserName, b.Email ,(g.Name) From Gerat g, Benutzer b, Verwenden v Where b.`Benutzer_Id`= v.`Benutz_Id` AND g.Nummer = v.Gerat_nummer Order by b.`Benutzer_Id`");
			$device = mysql_query("Select concat( Titel,' ',Vorname,' ',Nachname) As UserName, Benutzer.Email, Benutzer_Id From Benutzer ");
	?>		
			<div class = "scrol_header">
				<H3 class  = "title">Überblick</H3>
	<?php 
				if($_GET['level0']) {
				$gerat = $db->select("Gerat", "Name");
				if ($gerat)
					$geratresult = $db->getResult();
	?>	
				<select class  = "selectpicker form-control" data-live-search = "True" " style  = "cursor:pointer " onchange = "ChangeId(this)">
							<option class  = "option_font_11" selected >Wählen Sie das Gerät hier</option>	
	<?php
				for($i=0;$i< count($geratresult);$i++)
				{
	?>			
					<option class = "option_font_11" value = "<?php echo $geratresult[$i]?>"><?php echo $geratresult[$i]?></option>
	<?php
				} // for
	?>				
				</select>
	<?php
				}//$_GET['level0']
	?>				
			</div> <!-- scrol_header -->
			<br>	
			
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
		} // $_GET['level0'] && $_SESSION['ken']!= $default

		if($_GET['level1'] &&  $_SESSION['Id'] && $_SESSION['ken']!= $default)
		{
			// Meine Information 
			$loginId =  $_SESSION['Id'];
			$query = mysql_query("Select * From Benutzer Where Benutzer_Id = $loginId");
			while ($row = mysql_fetch_array($query)) {
	 ?>	
			<H3 class  = "title">Angaben Übersicht</H3>
			<br>
			<div class = "scrol_overview">
				<dl class  = "dl-horizontal" >
					<dt >Titel :</dt>
					<dd><?php echo $row["Titel"]?></dd>
					<br>
					<dt>Vorname :</dt>
					<dd><?php echo $row["Vorname"]?></dd>
					<br>
					<dt>Nachname :</dt>
					<dd><?php echo  $row["Nachname"]?></dd>
					<br>			
					<dt>EMail :</dt>
					<dd><?php echo $row["Email"]?></dd>
					<br>				
<?php
			}
?>	
					<dt>Abteilung :</dt>
						
<?php							
			$abt_query = mysql_query("Select distinct Name From Abteilung where Benut_Id = $loginId");
			while ($row = mysql_fetch_array($abt_query)) 
			{
?>
					<dd><?php echo $row["Name"]?></dd>
<?php					
			}
?>					
					<br>					
					<dt>Gerät :</dt>

<?php							
			$gerat_query = mysql_query("Select Name From Gerat Where Nummer IN (Select Gerat_nummer From Verwenden Where Benutz_Id = $loginId)");
			while ($row = mysql_fetch_array($gerat_query)) 
			{
?>
					<dd><?php echo $row["Name"]?></dd>
<?php					
			} //while
?>				</dl>
			</div> <!-- scrol_overview -->
				
<?php	
		} // $_GET['level1'] &&  $_SESSION['Id'] && $_SESSION['ken']!= $default
		
?>	
	</div> <!-- middle_div col-xs-6 -->
<?php	
	}//$_SESSION['User']
	else if($_SESSION['Error'] == "1") {
		$_SESSION['Error'] = "";
		// Invalid password while benutzer login || Ungültiges Passwort, während Benutzer Login
?>
		<div class="col-md-4 col-md-offset-4" style = "text-align:center">
			<div class = "">
				<strong><h3 class="text-danger">Fehler: Ungültiger Login</h3></strong> 
					<h4 class = "glyphicon glyphicon-hand-right"> <a href = "./"  style = "color:#808080">Zurück zu Login</a></h4>	
			</div>	
		</div>
<?php	
	}// $_SESSION['Error'] == "1" 
	else {
	// Benutzer Login
?>
		<div class = "col-md-5 col-md-offset-4">
			<form  class="form-horizontal" action = "./index.php?level0=User" method = "POST" style = "width:70%" onsubmit = "return LoginValidate(this)">
				<H2 style  = "text-align: center ">Login für <br>Geräteverwaltung</H2>
				<br>
				<div class  = "form-group">
					<label>Benutzername</label>
					<input name  = "Bname" id =  "Bname"  class  = "form-control input-sm" type = "text-area" size = "10px" value = "Anett">
				</div>	
				<div class  = "form-group">
					<label>Kennwort</label>
					<input name = "Bkenwort" id = "Bkenwort"class  = "form-control input-sm" type = "Password" size = "10px" >
				
				</div>
				<div class  = "form-inline">
					<input style = "text-align:left" class = "btn btn-default" value = "Anmeldung" type = "submit">
					<label style = "float:right;padding:10px;"><a href = "./AdminLogin.php?" style = "font-weight: bold; color:#e21b26;">Admin Login</a></label>
				</div>
			</form>	
		</div> <!-- col-md-5 col-md-offset-4 -->
		
		 <div class = "col-xs-3" style = "float: right; max-width: 400px; margin-top:13%;padding-right:50px">
		 	<div class = "well"  style = "background : #ebebeb; margin-top : 10px; text-align:center">
				<strong style = "text-align:center">Kontakt :</strong>
				<p>Den Verantwortlichen für die Aktualisierung des erreichen Sie unter  Tel - </p>
			</div>
		 </div> <!-- col-xs-3 -->
<?php		
	} // $_SESSION['Error'] != "1"
?>	
	<div class  = "div_logout col-xs-3" style = "float:right" >
<?php

if($_SESSION['User'] ) {
	// Div für benutzer abmelden
?>	 	
		<div class = "well"  style = "margin-top : 10px; text-align:center">
			<H4 style = "text-align:center; white-space: wrap">Benutzer :&nbsp;<?php echo  $_SESSION['User'];?></H3>
			<a href = "./Logout.php" style = "font-weight: bold; color:#e21b26;">Abmelden</a>			
		</div> <!-- well --> 
<?php
} // $_SESSION['User']
?>		
	</div>	<!-- div_logout col-xs-3 -->
	<div class = "col-xs-3" style = "float: right; max-width: 400px;">
<?php
	if($_GET['level1'] && $_SESSION['ken'] != $default && $_SESSION['User']){
	// Help text for My information || Hilfetext für Meine Informationen
?>
		<div class = "well"  style = "margin-top : 10px; ">
				<strong>Admin kontact:</strong>
				<p style = "padding-left:15px">Bitte kontaktieren Sie Admin für jede Änderung Ihrer Daten</p>
				<p style = "padding-left:15px">Telfon:  </p>	
		</div>		
<?php
	}else if($_GET['level0'] && $_SESSION['ken'] != $default && $_SESSION['User']){
	// Help text for Overview || Hilfetext für Übersicht
?>
		<div class = "well"  style = "margin-top : 10px; ">
				<strong>Gerätverwaltung:</strong>

				<p style = "padding-left:15px">Bitte wählen Sie die Geräteliste von oben an die Benutzer des Geräts anzeigen</p>	
				
		</div>	<!-- well --> 		
	
<?php
	}else if($_SESSION['ken'] == $default ){ 
	// Help text for the 1st time login || Hilfetext für das 1 Mal Login
?> 
		<div class = "well"  style = "margin-top : 10px; ">
				<strong>Benutzer Kennwort:</strong>

				<p style = "padding-left:15px">Bitte ändern Sie das Standard-Passwort</p>	
				
		</div>	<!-- well --> 	
	
<?php
	} // $_SESSION['ken'] == $default
?>	
	</div>	<!-- col-xs-3 -->
</div>	
</div>	
</body>
</html>
