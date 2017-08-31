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

function Validate(id)
{
	debugger;
	$ckenn = document.getElementById('current_kenwort').value;
	$nkenn = document.getElementById('neue_kenwort').value;
	if ($ckenn == "" && $nkenn == "") {
		$msg = "Bitte füllen Sie folgende felder aus:"+"\n"+"\n"+"	- Aktuelles Kennwort"+"\n"+"	- Neue Kennwort ";
		
		alert($msg);
		return false;		
	}else if ( $nkenn == "") {
		$msg = "Bitte füllen Sie folgende felder aus:"+"\n"+"\n"+"	- Neue Kennwort";
		
		alert($msg);
		return false;		
	}else if ($ckenn == "" ) {
		$msg = "Bitte füllen Sie folgende felder aus:"+"\n"+"\n"+"	- Aktuelles Kennwort";
		
		alert($msg);
		return false;		
	}else 
		return true;
}

function LoginValidate(id)
{
	$ckenn = document.getElementById('Bname').value;
	$nkenn = document.getElementById('Bkenwort').value;
	if ($ckenn == "" && $nkenn == "") {
		$msg = "Bitte füllen Sie folgende felder aus:"+"\n"+"\n"+"	- Benutzername"+"\n"+"	- Kennwort";
		
		alert($msg);
		return false;		
	}else if ( $nkenn == "") {
		$msg = "Bitte füllen Sie folgende felder aus:"+"\n"+"\n"+"	- Kennwort";
		
		alert($msg);
		return false;		
	}else if ($ckenn == "" ) {
		$msg = "Bitte füllen Sie folgende felder aus:"+"\n"+"\n"+"	- Benutzername";
		
		alert($msg);
		return false;		
	}else 
		return true;
}		
	
	