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

function ChangeId(id)
{
	if (id.value != "")
	{
		window.location.href='#'+id.value;		
	}
}




</script>
		

	