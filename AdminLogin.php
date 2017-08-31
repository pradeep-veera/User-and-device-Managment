<!--
	Diese datei zeigt den code für Admin Anmelden	
-->
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

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type='text/javascript' src="bootstrap/js/bootstrap.min.js"></script>
<script type='text/javascript' src="bootstrap/bootstrap-select/bootstrap-select.min.js"></script>

<script language="javascript" type="text/javascript" >

function Validateuser(id)
{
	$user = document.getElementById('Fname').value;
	$pass = document.getElementById('Fkenwort').value;
	if ($user == "" && $pass == "") {
		$msg = "Bitte füllen Sie folgende felder aus:"+"\n"+"\n"+"	- Benutzername"+"\n"+"	- Kennwort";
		
		alert($msg);
		return false;		
	}else if ( $pass == "") {
		$msg = "Bitte füllen Sie folgende felder aus:"+"\n"+"\n"+"	- Kennwort";
		
		alert($msg);
		return false;		
	}else if ($user == "" ) {
		$msg = "Bitte füllen Sie folgende felder aus:"+"\n"+"\n"+"	- Benutzername";
		
		alert($msg);
		return false;		
	}else 
		return true;
}



 </script>
<body style="background:#fff;margin:0;padding:0;font-family:arial, helvetica, sans-serif;fontsize:11px;" >
<a name="top"></a>
    <div id="header" style="float:left; width:100%; clear:both; height:160px; position:static; background:url(bilder/BG-Header.png) repeat-x center top #b50f1b; margin-bottom: 3px;">
		<div class = "logo">
			<a href="/">
				<img src = "bilder/logo.png"></img>
			</a>
		</div>
	</div>
<!-- Admin Abmelden -->
	<div class = "col-md-5 col-md-offset-4">
		<form name = "AdminLogin" id = "AdminLogin" class="form-horizontal" action = "./User.php?level0=alleUser" method = "POST" style = "width:70%" onsubmit = "return Validateuser(this)" >
			<H2 style  = "text-align: center "><img class = "loginImage" src = "bilder/admin_32.png">Admin Login<br> </H2>

			<br>
			<div class  = "form-group">
				<label>Benutzername</label>
				<input name  = "Fname" id =  "Fname" value = "admin"  class  = "form-control input-sm" type = "text-area" size = "10px">
			</div>
			<div class  = "form-group">
				<label>Kennwort</label>
				<input name = "Fkenwort" id = "Fkenwort"  value = "admin" class  = "form-control input-sm"  type = "Password" size = "10px">
			</div>
			<div class  = "form-inline">
				<input style = "text-align:left" class = "btn btn-default" value = "Anmeldung" type = "submit">
				<label style = "float:right;padding:10px;"><a href = "./" style = "font-weight: bold; color:#e21b26;">Benutzer Login</a></label>
			</div>
		</form>
	</div>

</body>



