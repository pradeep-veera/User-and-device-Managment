
	function ChangeId(id)
	{
		if (id.value != "")
		{
			window.location.href='#'+id.value;	
		}		
	}
function Gerat_validate()
{
	
	var gerat_name = document.forms["neue_gerat"]["neue_Name"];
	
	if (gerat_name.value== "")
	{
		$msg = "Bitte füllen Sie folgende felder aus:"+"\n"+"\n"+"	- Gerätname";
		
		alert($msg);
		return false;		
	}else if(!(FormGerätnameValidate(gerat_name)))
		return false;
	else 
		return true;
}

function FormGerätnameValidate(id)
{
	//alert("Form_validate")
	var letters = /^[A-Za-z]+$/;
	var name = id.value;
	if ((name)&&((name.length > 100)))
	{
		alert("Länge darf nicht mehr als 100 Zeichen lang sein");
		return false;
	}
	else return true;
}


function bGerat_validate()
{
	
	var bgerat_name = document.forms["bearbeiten_gerat"]["modify_gerat_name"];
	if (bgerat_name.value == "")
	{
		$msg = "Bitte füllen Sie folgende felder aus:"+"\n"+"\n"+"	- Gerätname";
		
		alert($msg);
		return false;		
	}else if(!(FormGerätnameValidate(bgerat_name)))
		return false;
	else 
		return true;
}

function Geratsel_validate()
{
	var bgerat = document.forms["Geratsel"]["suche_device"].value;
	if (bgerat == 0 || !bgerat)
	{
		$msg = "Bitte wählen Sie die Gerätname";
		
		alert($msg);
		return false;		
	}else 
		return true;
}