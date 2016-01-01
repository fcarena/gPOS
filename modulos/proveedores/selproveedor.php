<?php

include("../../tool.php");

SimpleAutentificacionAutomatica("visual-xulframe");

StartXul(_("Elige proveedor"));

switch($modo){
	case "proveedorhab":
			
		echo "<vbox class='box' flex='1'><groupbox flex='1'><caption class='box' label='" . _("Proveedor") . "'/>";		
		echo "<textbox id='buscaproveedor'  onkeyup='BuscaProveedor(); if (event.which == 13) agnadirDirecto();' onkeypress='return soloAlfaNumerico(event);'/>";
		$familias = genArrayProveedores();		
		echo "<script>\n";
		echo " provhab =new Object();\n";
		foreach ($familias as $key=>$value){
			echo "provhab[$key] = '$value';\n";			
		}
		echo "\n</script>";						
				
		echo "<listbox flex='1' id='Proveedor' onclick='parent.changeProvHab(this,provhab[this.value]);parent.closepopup();return true;'>";
		echo  genXulComboProveedores();				
		echo "</listbox>";
		//echo "<button label='". _("Cerrar")."' oncommand='parent.closepopup()'/>";	
		echo "</groupbox></vbox>";
		
		break;				

	case "proveedorpost":
			
		echo "<vbox class='box' flex='1'><groupbox flex='1'><caption label='" . _("Proveedor") . "'/>";		
		echo "<textbox id='buscaproveedor'  onkeyup='BuscaProveedor(); if (event.which == 13) agnadirDirecto();' onkeypress='return soloAlfaNumerico(event);'/>";
		$familias = genArrayProveedores();		
		echo "<script>\n";
		echo " provhab =new Object();\n";
		foreach ($familias as $key=>$value){
			echo "provhab[$key] = '$value';\n";			
		}
		echo "\n</script>";						
				
		echo "<listbox flex='1' id='Proveedor'  onclick='parent.setProvPost(this,provhab[this.value]);return true;'  onkeypress='if (event.which == 13) { parent.setProvPost(this,provhab[this.value]);return true; } '>";
		echo  genXulComboProveedores();				
		echo "</listbox>";
		//echo "<button label='". _("Cerrar")."' oncommand='parent.closepopup()'/>";	
		echo "</groupbox></vbox>";
		
		break;				
	default:
		break;	
}
?>

<script>//<![CDATA[

function BuscaProveedor(){
    var elemento = document.getElementById("buscaproveedor");
    var ns = new String(elemento.value);
    ns = ns.toUpperCase();
    var lista = document.getElementById("Proveedor");
    var texto2  = document.getElementsByTagName('listitem');
    if(ns.length >0){
        for (var i=0;i<lista.itemCount;i++){
            var cadena = new String(texto2[i].attributes.getNamedItem('label').nodeValue);
            cadena = cadena.toUpperCase();
            if(cadena == ns){
                lista.ensureIndexIsVisible(i);
                lista.selectedIndex=i;
                lista.onclick();
                return;
            }
            if(cadena.indexOf(ns) != -1){
                lista.ensureIndexIsVisible(i);
                lista.selectedIndex=i;
            }
        }
    }
}

function agnadirDirecto(){
    var theList=document.getElementById('Proveedor');
    if(theList.selectedIndex == -1){
        return;
    }
    theList.onclick();
}

function soloAlfaNumerico(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz0123456789";
    especiales = [8, 13];
    tecla_especial = false
    for(var i in especiales){
        if(key == especiales[i]){
            tecla_especial = true;
            break;
        }
    }
    
    if(letras.indexOf(tecla)==-1 && !tecla_especial){
        return false;
    }
}


function loadfocus(){
    document.getElementById('buscaproveedor').focus();
}

//]]></script>
<?php
EndXul();


?>

