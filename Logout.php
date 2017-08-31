<!--
	Diese datei zeigt den code für benutzer order Admin Abmelden	
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

	<script type="text/javascript" src="bootstrap/jquery.js"></script>
	<script type='text/javascript' src="bootstrap/js/bootstrap.min.js"></script>
	<script type='text/javascript' src="bootstrap/bootstrap-select/bootstrap-select.min.js"></script>
	<!--script type="text/javascript" src="jquery-ui-multiselect-widget-master/src/jquery.multiselect.js"></script-->
	<script type="text/javascript">

	$(document).ready(function() {
		$("#suche_benutzer2").selectpicker({});
		$("#bearibeten_gerat").selectpicker({});
		$("#bearibeten_abt").selectpicker({});
		$("#neue_gerat_user").selectpicker({});
		$("#neue_abt_user").selectpicker({});
		$("#del_abt").selectpicker({});
		$("#modify_abt").selectpicker({});
		$("#suche_benut").selectpicker({});
		$("#suche_device").selectpicker({});
	});

	function close_window() {
	  if (confirm("Close Window?")) {
	   window.top.close();
	  }
	}

	function ChangeId(id)
	{
		if (id.value != "")
		{
			window.location.href='#'+id.value;
			
		}
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
		<div class="col-md-5" style  = "margin-left : 30%;margin-right:40%; margin-top: 10%">
			<form class  = "form-group" action = "./" method = "POST" style = "text-align:center;">
				<div class = "alertas">
<!-- Hilfe Text für benutzer order Admin Abmelden -->				
					<div class = "form-group" style = "padding :20px;">
						<strong ><h3 class="text-danger">Sie haben sich erfolgreich ausgeloggt!</h3></strong> 
<?php
// Alle Session Variablen werden initialisert auf null	
						$_SESSION['Username'] = "";
						$_SESSION['User'] = "";
						$_SESSION['Error'] = "";
						$_SESSION['Id'] = "";
						$_SESSION['ken'] = "";
						session_destroy();
						

?>						
						<h4 class = "glyphicon glyphicon-hand-right"> <a href = "./"  style = "color:#808080">Ich will zurück zum Login</a></h4>
						</br>						
					</div>	
				</div>				
			</div>	
	</body>		
