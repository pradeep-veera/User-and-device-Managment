

	function ChangeId(id)
	{
		if (id.value != "")
		{
			window.location.href='#'+id.value;	
		}		
	}

/* Function zu Validate Bearbeiten Benutzer */	
function bbenutzer_validate()
{
	var bvor = document.forms["bbenutzer"]["edit_vorname"];
	var bnach = document.forms["bbenutzer"]["edit_nachname"];

	var vorReturn = FormNameValidate(bvor) ;
	var nachReturn = FormNameValidate(bnach) ;
	
	if(bvor.value == ""  &&  bnach.value == "")
	{
		$msg = "Bitte füllen Sie folgende felder aus:"+"\n"+"\n"+"	- Vorname"+"\n"+"	- Nachname";
		
		alert($msg);
		return false;
	}else if(bvor.value == "")
	{
		$msg = "Bitte füllen Sie folgende felder aus:"+"\n"+"\n"+"	- Vorname";
		
		alert($msg);
		return false;
	}else if(bnach.value == "")
	{
		$msg = "Bitte füllen Sie folgende felder aus:"+"\n"+"\n"+"	- Nachname";
		
		alert($msg);
		return false;
	}else if (!((vorReturn) && (nachReturn) )){
		return false;
	}
	else 
		return true;
}

/* Function zu Validate Neue Benutzer */	
function benutzer_validate()
{

	var vor =document.forms["neue_benutzer"]["neue_Vorname"];
	var nach = document.forms["neue_benutzer"]["neue_Nachname"];
	var login = document.forms["neue_benutzer"]["login_name"];

	var vorReturn = FormNameValidate(vor) ;
	var nachReturn = FormNameValidate(nach) ;
	var LoginReturn = FormNameValidate(login) ;

	if((vor.value == ""  &&  nach.value == "" && login.value == ""))
	{
		$msg = "Bitte füllen Sie folgende felder aus:"+"\n"+"\n"+"	- Vorname"+"\n"+"	- Nachname"+"\n"+"	- Loginname";
		
		alert($msg);
		return false;
	}else if(vor.value == ""  &&  nach.value == "")
	{
		$msg = "Bitte füllen Sie folgende felder aus:"+"\n"+"\n"+"	- Vorname"+"\n"+"	- Nachname";
		
		alert($msg);
		return false;
	}else if(vor.value == "" && login.value == "")
	{
		$msg = "Bitte füllen Sie folgende felder aus:"+"\n"+"\n"+"	- Vorname"+"\n"+"	- Loginname";
		
		alert($msg);
		return false;
	}else if( nach.value == "" && login.value == "")
	{
		$msg = "Bitte füllen Sie folgende felder aus:"+"\n"+"\n"+"	- Nachname"+"\n"+"	- Loginname";
		
		alert($msg);
		return false;
	}
	else if(vor.value == "")
	{
		$msg = "Bitte füllen Sie folgende felder aus:"+"\n"+"\n"+"	- Vorname";
		
		alert($msg);
		return false;
	}else if(nach.value == "")
	{
		$msg = "Bitte füllen Sie folgende felder aus:"+"\n"+"\n"+"	- Nachname";
		
		alert($msg);
		return false;
	}else if(login.value == "")
	{
		$msg = "Bitte füllen Sie folgende felder aus:"+"\n"+"\n"+"	- Loginname";
		
		alert($msg);
		return false;
	}else if (!((vorReturn) && (nachReturn) && (LoginReturn))){
		return false;
	}
	else 
		return true;	
}

function FormNameValidate(id)
{
	//alert("Form_validate")
	var letters = /^[A-Za-z]+$/;
	var name = id.value;
	//alert (name)
	if((name)&&(!(name.match(letters))))
	{
		alert("Bitte geben Alphabet Zeichen nur");
		return false
	}
	else if ((name)&&((name.length > 50)))
	{
		alert("Länge darf nicht mehr als 50 Zeichen lang sein");
		return false;
	}
	else return true;
}	

function FormLoginnameValidate(id)
{
	//alert("Form_validate")
	var letters = /^[A-Za-z]+$/;
	var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	var name = id.value;
	if ((name)&&((name.length > 50)))
	{
		alert("Länge darf nicht mehr als 50 Zeichen lang sein");
		return false;
	}
	else return true;
}


function FormTitelValidate(id)
{
	//alert("Form_validate")
	var letters = /^[A-Za-z]+$/;
	var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	var titel = id.value;
	if ((titel)&&((titel.length > 20)))
	{
		alert("Länge der Titel ist zu lang");
		return false;
	}else if((titel)&&(!(titel.match(letters))))
	{
		alert("Bitte geben Alphabet Zeichen nur");
		return false
	}
	else return true;
}	

function FormAbtNameValidate(id){

	//alert("Form_validate")
	var letters = /^[A-Za-z]+$/;
	var name = id.value;
	//alert (name)
	if((name)&&(!(name.match(letters))))
	{
		alert("Bitte geben Alphabet Zeichen nur");
		return false
	}
	else if ((name)&&((name.length > 150)))
	{
		alert("Länge darf nicth mehr als 150 Zeichen lang sein");
		return false;
	}
	else return true;

}	


/* Function zu Validate Neue Abteilung */	
function abt_validate()
{
	var abt_vor = document.forms["neue_abt"]["vorname_abt"].value;
	var abt_name =document.forms["neue_abt"]["neue_abteilung"];
	var abtReturn = FormAbtNameValidate(abt_name) ;
	
	if (!abt_vor && abt_name.value == "")
	{
		$msg = "Bitte füllen Sie folgende felder aus:"+"\n"+"\n"+"	- Benutzername"+"\n"+"	- Abteilungname";
		
		alert($msg);
		return false;		
	}else if (!abt_vor)
	{
		$msg = "Bitte füllen Sie folgende felder aus:"+"\n"+"\n"+"	- Benutzername";
		
		alert($msg);
		return false;
	}else if (abt_name.value== "")
	{
		$msg = "Bitte füllen Sie folgende felder aus:"+"\n"+"\n"+"	- Abteilungname";
		
		alert($msg);
		return false;		
	}else if (!abtReturn)
		return false;
	else 
		return true;
}


/* Function zu Validate Bearbeiten abteilung - II */	
function babtname_validate()
{
	var abt_name = document.forms["bb_abt"]["modified_abt"];
	
	if (abt_name.value == "")
	{
		$msg = "Bitte füllen Sie folgende felder aus:"+"\n"+"\n"+"	- Abteilungname";
		alert($msg);
		return false;		
	}else if (!(FormAbtNameValidate(abt_name)))
		return false;
	else 
		return true;
}

/* Function zu Validate Bearbeiten abteilung - I */	
function babt_validate()
{
	var abt = document.forms["b_abt"]["modify_abt"].value;
	if (abt == "Abteilungname"){
		$msg = "Bitte wählen Sie die Abteilungname";
		alert($msg);
		return false;
	}else 
		return true;	
}

/* Function zu Validate Bearbeiten abteilung - I */	
function bbnu_validate()
{
	var usr = document.forms["busr"]["suche_benut"].value;
	if (usr == ""){
		$msg = "Bitte wählen Sie die Benutzername";
		alert($msg);
		return false;
	}else 
		return true;	
}