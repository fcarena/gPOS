<?php
require("../tool.php");

echo "var cMargenUtil  = parseFloat(".getSesionDato("MargenUtilidad"),");\n".
     "var cMoneda      = ". json_encode( getSesionDato("Moneda") ),";\n".
     "var cIPC         = parseFloat(".getSesionDato("IPC"),");\n".
     "var cIGV         = parseFloat(".getSesionDato("IGV"),");\n";

header("Content-Type: text/javascript");
?>

function nuevaCompraBuscar(){  
   location.href = 'modcompras.php?modo=buscarproductos'; 
}

function verOrdenCompraConfirmado(idpedido){
  url = 'modulos/ordencompra/modordencompra.php?modo=listarTodoOrdenCompra';
  var mainweb = parent.document.getElementById('WebNormal');
  var mainlist = parent.document.getElementById('WebLista');
  var weblist = parent.document.getElementById('weblist');
  var webstatus = parent.document.getElementById('status');
  mainweb.setAttribute('collapsed','false');
  mainlist.setAttribute('collapsed','true');
  mainweb.setAttribute('collapsed','true');
  mainlist.setAttribute('collapsed','false');
  weblist.setAttribute('src', url);
  webstatus.setAttribute('label', 'Area Compras - Pedidos');
  if(parent.window.innerWidth){
    var ancho = parent.window.innerWidth - 10;
    weblist.setAttribute('width',ancho);
  }
}

function verRecibirCompra(idpedido){
  url = 'modulos/recepcionpedido/modalmacenborrador.php?modo=recibirProductosAlmacen';
  var mainweb = parent.document.getElementById('WebNormal');
  var mainlist = parent.document.getElementById('WebLista');
  var weblist = parent.document.getElementById('weblist');
  var webstatus = parent.document.getElementById('status');
  mainweb.setAttribute('collapsed','false');
  mainlist.setAttribute('collapsed','true');
  mainweb.setAttribute('collapsed','true');
  mainlist.setAttribute('collapsed','false');
  weblist.setAttribute('src', url);
  webstatus.setAttribute('label', 'Area Almacén - Recibir Pedidos');
  if(parent.window.innerWidth){
    var ancho = parent.window.innerWidth - 10;
    weblist.setAttribute('width',ancho);
  }
}

function verPedidoConfirmado(idpedido){
  url = 'modulos/comprobantecompra/modcomprasborrador.php?modo=listarTodoOrdenCompra';
  var mainweb = parent.document.getElementById('WebNormal');
  var mainlist = parent.document.getElementById('WebLista');
  var weblist = parent.document.getElementById('weblist');
  var webstatus = parent.document.getElementById('status');
  mainweb.setAttribute('collapsed','false');
  mainlist.setAttribute('collapsed','true');
  mainweb.setAttribute('collapsed','true');
  mainlist.setAttribute('collapsed','false');
  weblist.setAttribute('src', url);
  webstatus.setAttribute('label', 'Area Compras - Facturas');
  if(parent.window.innerWidth){
    var ancho = parent.window.innerWidth - 10;
    weblist.setAttribute('width',ancho);
  }
}

function nuevaCompraBuscar(){  
location.href = 'modcompras.php?modo=buscarproductos'; 
}


function cambiodoc(tipo){
    /*
    var	url = "services.php?modo=getTipoDocCompra";
    var xrequest = new XMLHttpRequest();
    xrequest.open("GET",url,false);
    xrequest.send(null);
    var res = xrequest.responseText;
    if(res=='SD' && tipo!='SD'){
        var	url = "services.php?modo=ComprobarProveedor";
        var xrequest = new XMLHttpRequest();
        xrequest.open("GET",url,false);
        xrequest.send(null);
        var resultado = xrequest.responseText;
        if(resultado==0){
                var p = confirm('gPOS:\n\n Atención, esta acción Vaciara Carrito. \n Desea seguir? ');
            if(p){
                    var	url = "services.php?modo=ResetearCarritoCompra";
                    var xrequest = new XMLHttpRequest();
                    xrequest.open("GET",url,false);
                    xrequest.send(null);
                    var	url = "services.php?modo=settipodocCompra&tipodoc="+tipo;
                    var xrequest = new XMLHttpRequest();
                    xrequest.open("GET",url,false);
                    xrequest.send(null);
            }else{
                    //document.getElementById("SD").checked=true;
	            return s_radioComprobante('SD');
            }
        }
        if(resultado==1){
            var	url = "services.php?modo=settipodocCompra&tipodoc="+tipo;
            var xrequest = new XMLHttpRequest();
            xrequest.open("GET",url,false);
            xrequest.send(null);
        }
    }
    */
     
    var url = "services.php?modo=settipodocCompra&tipodoc="+tipo;
    var xrequest = new XMLHttpRequest();
    xrequest.open("GET",url,false);
    xrequest.send(null);

    //var buscar = parent.document.getElementById("btnbuscar");
    //if(tipo!=res){
    // buscar.oncommand();
    //parent.Compras_buscar();
    //}
}

function incluirIGV(aux){

    aux = ( cTipoPresupuestoCart == 'O')? true:aux;
    if(aux) getMe('ckImpuesto').setAttribute("checked",true);

    var	url = "services.php?modo=setincImpuestoDetCompra&opcion="+aux;
    var xrequest = new XMLHttpRequest();
    xrequest.open("GET",url,false);
    xrequest.send(null);
    //xrequest.responseText;
}

function incluirPercepcion(aux){
    var	url = "services.php?modo=setincPercepcionCompra&opcion="+aux;
    var xrequest = new XMLHttpRequest();
    xrequest.open("GET",url,false);
    xrequest.send(null);
    if(!document.getElementById("tpercepcion") ) return;
    if(!aux){
     document.getElementById("tpercepcion").setAttribute("style","display:none");  
     document.getElementById("ipercepcion").setAttribute("style","display:none");  
     document.getElementById("ImportePercepcion").value = 0;
    }

    if(aux){
     var xtotalneto  = parseFloat(document.getElementById("TotalNeto").value);
     document.getElementById("tpercepcion").setAttribute("style","");  
     document.getElementById("ipercepcion").setAttribute("style","");  
     document.getElementById("ImportePercepcion").value = (( cIPC * xtotalneto )/100).toFixed(2);
    }
     actualizaImportePago();
    //xrequest.responseText;
}

function aCredito(aux){
    var	url = "services.php?modo=setaCreditoCompra&opcion="+aux;
    var xrequest = new XMLHttpRequest();
    xrequest.open("GET",url,false);
    xrequest.send(null);
    //xrequest.responseText;
}
function cambiomoneda(tipo){
    var	url = "services.php?modo=settipomonedaCompra&tipomoneda="+tipo;
    var xrequest = new XMLHttpRequest();
    xrequest.open("GET",url,false);
    xrequest.send(null);
    actualizaImportePago();
}
function setfechadoc(){
    var fecha = document.getElementById("FechaDoc");
    if(fecha)
      if( validaFechaDDMMAAAA(fecha.value) ){
        var	url = "services.php?modo=setfdocCompra&fdoc="+fecha.value;
        var xrequest = new XMLHttpRequest();
        xrequest.open("GET",url,false);
        xrequest.send(null);
      }
      else
        fecha.value='';

}

function setfechapagodoc(){
  var fecha = document.getElementById("FechaPago");
  if(fecha)
    if( validaFechaDDMMAAAA(fecha.value) ){
        var url      = "services.php?modo=setfpdocCompra&fpdoc="+fecha.value;
        var xrequest = new XMLHttpRequest();
        xrequest.open("GET",url,false);
        xrequest.send(null);
    }
    else
        fecha.value='';
}

function setfechacambio(){
    var fecha = document.getElementById("FechaCambio");
    if(fecha)
      if( validaFechaDDMMAAAA(fecha.value) ){
        var	url = "services.php?modo=setfcambioCompra&fcambio="+fecha.value;
        var xrequest = new XMLHttpRequest();
        xrequest.open("GET",url,false);
        xrequest.send(null);
      }
      else
        fecha.value='';
}

 
totalTiempos = 0;
startTime=new Date().getTime();

function timingTerminaGeneracionPagina(tiempoProcesoPHP) {
 var endTime=new Date().getTime();
 echo('[Javascript time]: '+((endTime-startTime)/1000)+
      ' seconds.<br>');
 totalTiempos = totalTiempos + ((endTime-startTime)/1000);

 echo('[TOTAL Generacion JS]: '+totalTiempos+ ' seconds.<br>');
 echo('[TOTAL Generacion PHP]: '+tiempoProcesoPHP+ ' seconds.<br>');
 echo('[TOTAL JS+PHP]: '+(totalTiempos +tiempoProcesoPHP)+ ' seconds.<br>');

}

// GenCore, libreria compartida
var ancho_lista ='90%';

totalTiempos = 0;
startTime=new Date().getTime();

function timingTerminaGeneracionPagina(tiempoProcesoPHP) {
 var endTime=new Date().getTime();
 echo('[Javascript time]: '+((endTime-startTime)/1000)+
      ' seconds.<br>');
 totalTiempos = totalTiempos + ((endTime-startTime)/1000);

 echo('[TOTAL Generacion JS]: '+totalTiempos+ ' seconds.<br>');
 echo('[TOTAL Generacion PHP]: '+tiempoProcesoPHP+ ' seconds.<br>');
 echo('[TOTAL JS+PHP]: '+(totalTiempos +tiempoProcesoPHP)+ ' seconds.<br>');

}

// GenCore, libreria compartida
var ancho_lista = '90%';

function ckAction(me,id,max,ns,xid){ 
  var xcanttrans = parent.document.getElementById('CarritoTraspasoCant');
  var tipoAction = (me.checked)? "trans" : "notrans";     
  var p          = 0;

  if(xcanttrans.value >= 25 && tipoAction=="trans"){
    me.checked = false;
    return alert("gPOS: Carrito Almacén, tiene 25 productos seleccionados:\n\n     - Cantidad máxima permitida: 25 productos.");
  }

  if(tipoAction=="trans")
  {
    xcanttrans.value++;
    var main  = parent.getWebForm();
    var aviso = 'Cargando Existencias ...';
    var url   = 'modulos/kardex/selkardex.php?modo=xExistenciasAlmacenCarrito%xproducto='+xid+'%xalmacen='+id;

    var lurl  = 'modulos/compras/progress.php?modo=lWebFormAlmacen&aviso='+aviso+'&url='+url;

    main.setAttribute("src",lurl);  
    parent.xwebCollapsed(true);

  }

  if(tipoAction=="notrans")
  {
    xcanttrans.value--;
   var url = 'modalmacenes.php?modo='+tipoAction+'&id='+id+'&u='+p;
   Mensaje (url);  
  }
}

function precioTransAlmacen(xid,xdato,xprecio)
{
    xdato.value = ( xdato.value < xprecio)? xprecio:xdato.value;
    var	url     = "modulos/kardex/selkardex.php"+
                  "?modo=setPrecioCarritoAlmacen"+
                  "&xid="+xid+
                  "&xdato="+xdato.value;
    Mensaje (url);  
}

function setalbadoc(xthis){

    if( xthis.value == ''  ) return xthis.focus();
    var arcodigo,xnum,xserie,ncodigos= new Array();
    var codigos  = xthis.value.split(',');

    for(var i in codigos){
      arcodigo =  codigos[i].split('-');
      if( arcodigo[1] )
	if ( !isNaN( parseInt( arcodigo[1] ) ) )
          if( arcodigo[0].length < 5 && String( parseInt( arcodigo[1] ) ).length < 8 )
  	      ncodigos.push( arcodigo[0]+'-'+parseInt( arcodigo[1] ) );
    }
    xthis.value = ncodigos.toString();

    var url      = "services.php?modo=setalbadocCompra&ndoc="+xthis.value;
    var xrequest = new XMLHttpRequest();
    xrequest.open("GET",url,false);
    xrequest.send(null);
}

function setndoc(xvl){
    xvl        = new String(xvl);
    var idprov = document.getElementById('IdProvHab');
    var ndoc   = document.getElementById("NDoc");
    var sdoc   = document.getElementById("SDoc");

    if( ndoc.value == ''  ) return ndoc.focus();
    if( sdoc.value == ''  ) return sdoc.focus();
    var codigo   = sdoc.value+'-'+ndoc.value;
    var url      = "services.php?modo=checkndocCompra&ndoc="+codigo+"&idprov="+idprov.value;
    var xrequest = new XMLHttpRequest();
    xrequest.open("GET",url,false);
    xrequest.send(null);
    var res = xrequest.responseText;

    if(res == '0'){
      alert("gPOS:\n\n Existe un registro "+codigo+" para este proveedor");
      ndoc.value = '';
      sdoc.value = '';
      return sdoc.focus();
    }
    
    if(res == '1'){
     var url      = "services.php?modo=setndocCompra&ndoc="+codigo;
     var xrequest = new XMLHttpRequest();
     xrequest.open("GET",url,false);
     xrequest.send(null);
    }
}
function settipocambio(value){
    value =new String(value);
    if(value <= 0 || isNaN(value) || value=="" || value.lastIndexOf(' ')>-1){
        alert("gPOS:\n\n Ingrese el tipo de cambio correctamente");
	//document.getElementById("TipoCambioMoneda").value=1;
	if(typeof enviar === 'function') enviar();
	return;
     }
     var url = "services.php?modo=settipocambioCompra&tipocambio="+value;
     var xrequest = new XMLHttpRequest();
     xrequest.open("GET",url,false);
     xrequest.send(null);

     if(typeof enviar === 'function') enviar();
}

function setflete(xvalue){
    xvalue =new String(xvalue);
    if(isNaN(xvalue) || xvalue=="" || xvalue.lastIndexOf(' ')>-1){
        alert("gPOS:\n\n Ingrese el flete correctamente");
	document.getElementById("ImporteFlete").value=0;
	xvalue = 0;
     }
     var url = "services.php?modo=setfleteCompra&flete="+xvalue;
     var xrequest = new XMLHttpRequest();
     xrequest.open("GET",url,false);
     xrequest.send(null);
     actualizaImportePago();
}

function setpercepcion(xvalue){
    xvalue =new String(xvalue);
    if(isNaN(xvalue) || xvalue=="" || xvalue.lastIndexOf(' ')>-1){
        alert("gPOS:\n\n Ingrese la percepción correctamente");
	document.getElementById("ImportePercepcion").value=0;
	xvalue = 0;
     }
     var url = "services.php?modo=setpercepcionCompra&percepcion="+xvalue;
     var xrequest = new XMLHttpRequest();
     xrequest.open("GET",url,false);
     xrequest.send(null);
     actualizaImportePago();
}
function actualizaImportePago(){
   if(!document.getElementById("ImportePercepcion")) return;

   var xpercepcion = parseFloat(document.getElementById("ImportePercepcion").value);
   var xcoreflete  = parseFloat(document.getElementById("ImporteFlete").value);
   var xtipocambio = parseFloat(document.getElementById("TipoCambioMoneda").value);
   var xflete      = ( document.getElementById("tipoDolar").checked )? xcoreflete/xtipocambio:xcoreflete;
   var xtotalneto  = parseFloat(document.getElementById("TotalNeto").value);

   document.getElementById("ImportePago").value = (xtotalneto+xpercepcion+xflete).toFixed(2);

   document.getElementById("ImportePagoMonedaBase").value = ( document.getElementById("tipoDolar").checked )? ( ( xtotalneto+xpercepcion )*xtipocambio + xcoreflete).toFixed(2) : (xtotalneto+xpercepcion+xcoreflete).toFixed(2);
    
}

function formatCurrency(num) {
// num = num.toString().replace(/\\$|\,/g,'');

 if(isNaN(num)) num = "0";

 var sign = (num == (num = Math.abs(num)));
  num = Math.floor(num*100+0.50000000001);
 var cents = num%100;
  num = Math.floor(num/100).toString();

 if(cents<10) cents = "0" + cents;

 for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
   num = num.substring(0,num.length-(4*i+3))+'.'+ num.substring(num.length-(4*i+3));

 return (((sign)?'':'-') + " "+cMoneda[1]['S']+" " +  num + '.' + cents );
}

/*++++++ PERSONALIZACION POPUPS +++++++++*/
var cPopupurl = '';
var ven = new Array();
//ven["talla"]= ''ven_normal';
//ven["marca"]='ven_normal';
ven["alta"]='ven_alta';
ven["codigobarras"]='ven_codigobarras';
ven["selcomprar"]='ven_seleccion';
ven["selalmacen"]='ven_seleccion';
ven["carrito"]='ven_carrito';
ven["printallcb"]='ven_printallcb';
ven["color"]='ven_color';
ven["talla"]='ven_talla';
ven["marca"]='ven_marca';
ven["avanzada"]='ven_avanzada';
ven["proveedorhab"] ='ven_prov';
ven["contenedor"] ='ven_contenedor';
ven["servicio"] ='ven_servicio';
ven["laboratoriohab"] ='ven_lab';
ven["altaproveedor"] ='ven_alta';
ven["addprodcart"] ='ven_addprodcart';
ven["altalaboratorio"] ='ven_alta';
ven["familiaplus"] ='ven_familiaplus';
ven["cuenta"] = 'ven_cuenta';

function popup(url,tipo) {

  //setWebBoxCollapsed(false);
  cPopupurl = tipo;

  var extra = '';
  //windows
  switch ( tipo ){
    case 'printallcb':
    case 'codigobarras':
       var extra = ( tipo == 'printallcb' )? 'dialogWidth:610px;dialogHeight:650px':
                                             'dialogWidth:320px;dialogHeight:420px';
       extra  =  extra+',dependent=yes,screenX=200,screenY=300,titlebar=no,status=0';
       window.showModalDialog(url,tipo,extra);
       return;
  }

  //iframe div
  document.getElementById('windowpopup').src=url;   //Carga link
  var extra = (ven[tipo])? ven[tipo]:'ver_clasico'; //Muestra box
  lanzapopup(extra);
}

function lanzapopup(extra){
  document.getElementById('box-popup').className='box-popup-on '+extra;
}

function closepopup(){

  document.getElementById('box-popup').className='box-popup-off';
  document.getElementById('windowpopup').src='about:blank';
  setWebBoxCollapsed(false);
  switch ( cPopupurl ){

    case 'addprodcart':
    
    location.reload();
    break;

  }

}
function loadFocusPopup(){
   windowpopup.loadfocus();
}
/*====== PERSONALIZACION POPUPS =========*/


/*=============== LISTADOS RAPIDOS =============*/



var K  = 0;// Iteracion en coleccion de objetos
var W  = 0;// coleccion de productos
var p  = new Array(); //Coleccion de objetos
var lastBase; //Memoria de bases activas
var iBase = 0;//Iterador dentro d e una base activa (para listados colapsables)

var echo = function(param) {
 //document.write("<xmp>"+param+"</xmp>"); 
 document.write( param ); 
};

var actionUrl = document.location.href.split("?")[0];

function ifConfirmGo( mensaje , url ){
  if (confirm(mensaje)){
    window.location.href = url;
  }
}

function ifConfirmExec( mensaje, command){
  if (confirm(mensaje)){
    eval(command);
  }	
}



function genPaginador(iz,der,num){
 if (iz || der) {
   echo ("<table class='forma'><tr class='f'>");
   if (iz) echo ("<td><a href='"+actionUrl +"?modo=pagmenos'>"+po_pagmenos+"</a></td>");
   if (der) echo ("<td><a href='"+actionUrl +"?modo=pagmas'>"+po_pagmas+"</a></td>");   
   echo ("</tr></table>");  
 }
}


/* ============== CLASE PRODUCTO ============ */
function Producto(id){
 this.id = id;
}
/* ================ CLASE PRODUCTO============ */



 function genCompraLinea() {
   echo("<tr class='f'>"+
  "<td class=referencia>"+this.referencia+"</td>"+
  "<td class=nombre>"+this.nombre+"</td>"+
  "<td class=boton><input class=sbtn type=button "+
  "onclick='AgnadirProductoCompra("+this.id+",0,0,0,0,0,0)'value='"+po_comprar+"'></td></tr>");
 }


function genProductoLinea() {
  var sel     = "";
  var xinput  = (this.servicio)? " style='display:none' ":""; 
  var ximagen = (this.imagen != '')? "":" style='display:none' "; 
  var xdiv    = (this.imagen != '')? "":" display:none "; 
  var xclick  = (this.imagen != '')? 'mostrarProductoImagen('+this.cb+',"'+this.imagen+'")':"";

 echo("<tr class='f'>"+
  "<td width='16' class='codigobarras'>"+this.cb+"</td>"+
  "<td class='color' width='45%'>"+this.color+"</td>"+
  "<td class='talla' width='45%'>"+this.talla+"</td>"+
  "<td class='botonicons' width='10%'><nobr>"+
  "<input class='sbtn' "+ ximagen +" type='image' title='Ver Imagen' src='img/gpos_prodimagen.png' onclick='"+xclick+"' value=''>"+" "+
  "<input class='tb' type='image' src='img/gpos_imprimircb.png' title='Imprimir CB' onclick=\"selImpresion('codigobarrasProducto','"+this.id+"');return 0;\">"+" "+
  "<div id='boximage_"+this.cb+"' class='productoimagen'  style='background-image:url(\"img/gpos_marcagua.png\");display: none;"+ xdiv +"' onclick='mostrarProductoImagen("+this.cb+")'></div>"+" "+
  "<input class='tb' type='image' src='img/gpos_modproducto.png' title='Modificar Producto' onclick='"+'javascript:location.href="modproductos.php?modo=editarbar&id='+this.id+'&idBase='+this.idBase+'"'+"' >"+" "+
"<input class='sbtn' "+ xinput +" type='image' title='Comprar Producto' src='img/gpos_prodcompras.png' onclick='AgnadirProductoCompra("+this.id+","+this.serie+","+ this.lote +","+ this.fv+","+ this.servicio+",0,0)' value=''>"+" "+
  "<input  class='tb' type='image' src='img/gpos_eliminarproducto.png' title='Eliminar Producto' onclick='ifConfirmGo(\"gPOS: "+po_avisoborrar+"\",\"modproductos.php?modo=borrar&id="+this.id+"&idBase="+this.idBase+"\")'></nobr>"+
  "</td>"+
  "</tr>\n"
   );   
  return 2;
}

function mostrarProductoImagen(xcb,ximage){

    var xdiv     = document.getElementById('boximage_'+xcb);
    var xdisplay = ( xdiv.style.display == 'block' )? 'none':'block';

    xdiv.style.backgroundImage = ( xdisplay == 'block' )? "url('productos_img/"+ximage+"')":"url('img/gpos_marcagua.png')";
    xdiv.style.display         = xdisplay;

}


function genProductoResumen() {
  var sel = "";
  var xmas = (this.servicio > 0)?'display:none':'';
  var xinput = (this.servicio)? " style='display:none' ":""; 
 echo("<tr class='f'>"+
  "<td width='16'></td>"+
  "<td class='color' width='45%'></td>"+
  "<td class='talla' width='45%'></td>"+
  "<td class='botonprod' width='10%'><nobr>"+
  "<input class='tb' type='image' src='img/gpos_nuevoproducto.png' title='Clonar Producto' onclick='"+'javascript:location.href="modproductos.php?modo=clonar&id='+this.id+'&idBase='+this.idBase+'"'+"'>"+" "+ "<input class='tb' type='image' src='img/gpos_masdetallesm.png' title='Detalle Almacen' onclick='expandCruzado("+this.id+");void(0);' "+xinput+"></nobr>"+
  "</td>"+
  "</tr><tr><td colspan='4' id='cruzado_"+this.id+"'></td></tr>\n"
   );   
}

var idCruzadoEnProceso = 0;
var xrequest = new XMLHttpRequest();

function idE(ncosa) {return document.getElementById(ncosa);};

var arrayExpandidos = new Array();
var arrayUnidades = new Array();

function cuentaUnidades(idbase,cantidad){
  var actual = arrayUnidades[idbase];
  if(!actual) actual = 0;
  
  arrayUnidades[idbase] = parseInt(actual,10) + parseInt(cantidad,10);  
  return arrayUnidades[idbase];
}

function expandCruzado( idCruzado ){

	if (arrayExpandidos[idCruzado]){ 
		idE("cruzado_"+idCruzado).innerHTML = "";
		arrayExpandidos[idCruzado] = 0;//Si estaba expandido ha sido comprimido, y marcado comprimido
		return;
	}

	if (idCruzadoEnProceso)
		return;

	idCruzadoEnProceso = idCruzado;
	var url = "simplecruzado.php?modo=soloficha&IdProducto="+ idCruzado;
	
	xrequest.open("GET",url,true);
	xrequest.onreadystatechange = RececepcionFicha;
	xrequest.send(null);			
}

function RececepcionFicha(){
	if (xrequest.readyState==4) {
		var rawtext = xrequest.responseText;			
		//alert(rawtext);
		var contenedor = idE("cruzado_"+idCruzadoEnProceso);
		
		if (!contenedor)
			return alert("no contenedor!");
		//else 
		//	alert(contenedor);
		arrayExpandidos[idCruzadoEnProceso] = 1;//Marcar como expandido
		
		contenedor.innerHTML = rawtext;		
		
		idCruzadoEnProceso = 0;		
	}
}


function genProductoResumenCompras() {
  var sel = "";

 echo("<tr class='f'>"+
  "<td width='16'></td>"+
  "<td class='color' width='40%'></td>"+
  "<td class='talla' width='40%'></td>"+
  "<td class='boton' width='20%'><nobr>"+
  "</td>"+
  "</tr>\n"
   );   

}


function genCompraLineaCompras() {
  var sel = "";

 echo("<tr class='f'>"+
  "<td width='16' class='codigobarras'>"+this.cb+"</td>"+
  "<td class='color' width='60%'>"+this.color+"</td>"+
  "<td class='talla' width='60%'>"+this.talla+"</td>"+
  "<td class=boton><nobr>"+
  "<input class='sbtn' type='image' title='Comprar Producto' src='img/gpos_prodcompras.png' "+
  "onclick='AgnadirProductoCompra("+this.id+","+this.serie+","+ this.lote +","+ this.fv+","+ this.servicio+",0,1)'value=' "+po_comprar+"'></nobr></td>"+
  "</tr>\n"
   );      
}


function cL(id,cb,L_talla,L_color,manejaserie,manejalote,manejafv,eservicio){ //Aparece en compras
  var o      = new Producto(id);
  o.id       = id;
  o.cb       = cb;
  o.talla    = L[L_talla];
  o.color    = L[L_color];
  o.serie    = manejaserie;
  o.lote     = manejalote;
  o.fv       = manejafv;
  o.servicio = eservicio;
  o.genLinea = genCompraLineaCompras;
  o.genResumen = genProductoResumenCompras;
  o.tipo = TIPO_NORMAL;
  p[K++] = o;
}


function cP(id,cb,L_talla,L_color,idBase,manejaserie,manejalote,manejafv,eservicio,esimagen){ //Aparece en productos
  var o        = new Producto(id);
  o.id         = id;
  o.idBase     = idBase;
  o.cb         = cb;
  o.talla      = L[L_talla];
  o.color      = L[L_color];
  o.serie      = manejaserie;
  o.lote       = manejalote;
  o.fv         = manejafv;
  o.servicio   = eservicio;
  o.imagen     = esimagen;
  o.genLinea   = genProductoLinea;
  o.tipo       = TIPO_NORMAL;
  o.genResumen = genProductoResumen;
  p[K++]       = o;
}

function genProductoLineaHead() { //Head de Listados de Productos
 idElemento('head_total').value++;
 var xicon = (this.servicio > 0)? icon_servicios:icon_productos;
 var xstyle = (this.servicio > 0)? 'display:none':'';

 echo("</table></div></td></tr>\n\n<tr class='t f'>"+
  "<td width='16' class='iconproducto'>"+xicon+"</td>\n"+
  "<td class='referencia'>"+this.referencia+"</td>\n"+
  "<td class='nombre'>"+this.descripcion+" "+this.marca+" "+this.lab+"</td>\n"+
 "<td class='familia'>"+this.familia+" - " +this.subfamilia+"</td>\n"+ 
  "<td class='botonplus' width='16'><nobr><input  class='tb' type='image' title='Modificar Producto Base' src='img/gpos_modproducto.png' onclick='document.location=\"modproductos.php?modo=editar&id="+this.id+"&idBase="+this.idBase+"\"'> "+
 "<input  class='tb' type='image' src='img/gpos_masdetalles.png' title='Producto Base - Mostrar Clones' onclick='MuestraBases("+this.idBase+")'></nobr></td>\n"+
   "</tr>\n\n"+
   "<tr><td colspan='8'><div id='base"+this.idBase+
"' style='display: none'><table class='subcaja' width='95%'>\n");  

 echo("<tr class='f lh'>"+
  "<td class='codigobarras'>"+icon_bar+"</td>"+
  "<td class='color'>"+po_color+"</td>"+
  "<td class='talla'>"+po_talla+"</td>"+
  "<td class='boton'>Opciones</td>"+
  "</tr>\n"
   ); 
 return 1;
}

function genProductoLineaHeadCompras() {//Head de listados de productos

 idElemento('head_total').value++;

 echo("</table></div></td></tr>\n\n<tr class='t f'>"+
  "<td width='16' class='iconproducto'>"+icon_productos+"</td>\n"+  
  "<td class='referencia'>"+this.referencia+"</td>\n"+
  "<td class='nombre'>"+this.descripcion+" "+this.marca+" "+this.lab+"</td>\n"+
 "<td class='familia'>"+this.familia+" - " +this.subfamilia+"</td>\n"+ 
  "<td class='botonplus' width='16'><nobr>"+
  "<input class='tb' type='image' src='img/gpos_altarapida.png' title='Clonar Producto' onclick='parent.parent.Compras_ClonarProducto("+this.id+")'>"+" "+
  "<input class='tb' type='image'title='Producto Base - Mostrar Clones' src='img/gpos_masdetalles.png' onclick='MuestraBases("+this.idBase+")'></nobr></td>\n"+
   "</tr>\n\n"+
   "<tr><td colspan='8'><div id='base"+this.idBase+"' style='display: none'><table  class='subcaja' width='95%'>\n");   

 echo("<tr class='f lh'>"+
  "<td class='codigobarras'>"+icon_bar+"</td>"+
  "<td class='color'>"+po_color+"</td>"+
  "<td class='talla'>"+po_talla+"</td>"+
  "<td class='boton'>Comprar</td>"+
  "</tr>\n"
   ); 

}

function cPH(id, nombre,ref, L_familia, L_subfamilia, descripcion,marca,lab,eservicio,idBase){
  var o = new Producto(id);
  o.id = id;
  o.idBase = idBase;
  o.nombre = nombre;
  o.descripcion = descripcion;
  o.marca = marca;
  o.lab = lab;
  o.servicio = eservicio;
  o.referencia = ref;
  o.familia = L[L_familia];
  o.subfamilia = L[L_subfamilia];
  o.genLinea = genProductoLineaHead;
  o.tipo = TIPO_HEAD;
  o.genResumen = genProductoResumen;
  p[K++] = o;
}

function cLH(id, nombre,ref, L_familia, L_subfamilia, descripcion,marca,lab,idBase){
  var o = new Producto(id);
  o.id = id;
  o.idBase = idBase;
  o.familia = L[L_familia];
  o.subfamilia = L[L_subfamilia];
  o.nombre = nombre;
  o.descripcion = descripcion;
  o.marca = marca;
  o.lab = lab;
  o.referencia = ref
  o.tipo = TIPO_HEAD;
  o.genLinea = genProductoLineaHeadCompras;
  p[K++] = o;
}

//CONTROL DE NUMERO SERIES 
var nsbug = new Array();
var nsnum = 0;
var nsfila =0;
//

function genAlmacenLinea() {
    unidadestotal = this.unidades;
    var ucontenedor = this.ucontenedor;

    if(ucontenedor!=0){

	if(unidadestotal<ucontenedor){
            var enteros = 0;
            var puchos = unidadestotal;
	}else{
            var decimal = unidadestotal/ucontenedor;
            var enteros = parseInt(decimal,10);
            var puchos = unidadestotal%ucontenedor;
	}   

    }else{
	enteros = unidadestotal;
	puchos = 0;  
    }

    if(this.ventamenudeo=="0"){
	var cadena = unidadestotal +"  "+ this.unidadmedida; 
    }

    if(this.ventamenudeo=="1"){
	var cadena = enteros+" "+this.contenedor+" + "+puchos+" "+this.unidadmedida;
	if(enteros==0)
	    var cadena = puchos+" "+this.unidadmedida;
	if(puchos==0)
	    var cadena = enteros+" "+this.contenedor;
    }

    nsfila++;
    if( bsmanejans == 1){
	if(this.statusns==0) imgns='img/gpos_barcode.png';
	if(this.statusns==1) imgns='img/gpos_barcode.png';
	if(this.statusns==2){
	    imgns='img/bar20kill.png';
	    nsbug[nsnum]=nsfila;
	    nsnum++;
	}
	botonserieprod =  "<a href='#'><img border='0' src="+imgns+" onclick='verseries("+this.id+","+this.unidades+")' title='Numeros de Serie'></a>\n";
    }
    else{
	botonserieprod =  " ";
    }

    var sel = "";
    if (this.seleccionado) sel = "checked='true'";
    sel = "<input type='checkbox' id='ck_"+this.id+"' "+sel+" onclick='ckAction(this,"+this.transid+","+this.unidades+","+bsmanejans+","+this.id+")'><label for='ck_"+this.id+"'></label> ";
    echo("<tr class='f'>"+
	 "<td class='iconos'>"+Iconos2Images(this.iconos)+" "+botonserieprod+"</td>"+
	 "<td class='local'>"+this.local+"</td>"+
	 "<td class='codigobarras'>"+this.cb+"</td>"+
	 "<td class='color'>"+this.color+"</td>"+
	 "<td class='talla'>"+this.talla+"</td>"+
	 "<td class='unidades'>"+cadena +"</td>"+
	 "<td class='precio'>"+formatCurrency(this.precio)+"</td>"+
	 "<td class='boton'>"+
	 "<input class='tb' type='image' src='img/gpos_modproducto.png' title='Modificar Propiedades' onclick='"+'javascript:location.href="modalmacenes.php?modo=editar&id='+this.transid+'"'+"'>"+" "+
	 "<input class='tb' type='image' src='img/gpos_movimientos.png' title='Movimientos kardex' onclick='"+'javascript:location.href="modulos/kardex/selkardex.php?modo=xMovimientosExistenciasAlmacen&id='+this.transid+'"'+"'>"+" "+
	 "</td>"+
	 "<td class='boton checkboxstock'>"+sel+"</td></tr>\n"
	);   
}


var autoexpand = new Array();

function cA(id,iconos,cb,unidades,precio,seleccionado,transid,L_talla,L_color,L_local,ManejaSerie,UnidadMedida,contenedor,ucontenedor,ventamenudeo,statusns){
  var o = new Producto(id);
  cuentaUnidades(lastBase,unidades);   
  
  o.idbase = lastBase;//ajustado por un cAH anterior
  o.iBase = iBase;//mantenido por esta misma funcion 
  iBase ++;
  o.iconos = iconos;
  o.cb = cb;
  o.unidades  = unidades;
  o.statusns = statusns;
  o.precio = precio;
  o.seleccionado = seleccionado;
  if (seleccionado) {
    autoexpand[lastBase] = 1;//Ordenamos que se autoexpanda este elemento    
  }
  o.transid = transid;
  o.talla = L[L_talla];
  o.color = L[L_color];
  o.local = L[L_local];
  o.unidadmedida = UnidadMedida;
  o.contenedor = contenedor;
  o.ventamenudeo = ventamenudeo; 
  o.ucontenedor = ucontenedor;
  o.genLinea = genAlmacenLinea;
  o.iK = K;
  p[K++] = o;
}

function genAlmacenLineaHead() {
    idElemento('head_total').value++;
    var display = "none";
    var iconusar, unidadestotal, extra;
    
    if (autoexpand[this.idBase])
	display = "normal";   
    
    unidadestotal = cuentaUnidades(this.idBase,0);
    
    if(unidadestotal>0){
	iconusar = icon_stockfull;
	extra = " "+unidadestotal+" "+this.unidadmedida+" ";
    } else {
	iconusar = icon_stock;	
	extra = " &nbsp; ";
    }
    bsmanejans = (this.serie == 1)? 1:0;
    botonserie = (this.serie == 1)? "<a href='#'><img border='0' title='Numeros de Serie' onclick='visualizarserie("+this.idBase+")' src='img/gpos_barcode.png'></a>\n":"";

    echo("</table></div></td></tr>\n\n<tr class='t f'>"+
	 "<td width='16' id='icon_stock_"+ this.idBase +"' class='iconstock'><nobr> "+iconusar+" "+botonserie+extra+"</nobr></td>"+
	 "<td class='referencia'>"+this.referencia+"</td>\n"+
	 "<td class='nombre'>"+this.descripcion+" "+this.marca+" "+this.lab+"</td>\n"+
	 "<td class='familia'>"+this.familia+" - "+this.subfamilia+"</td>\n"+
	 "<td class='botonplus' width='16'><input class='tb' type='image' title='Producto Base - Mostrar Clones' src='img/gpos_masdetalles.png' onclick='MuestraBases("+this.idBase+")'></td>\n"+
	 "</tr>\n\n"+
	 "<tr><td colspan='8'><div id='base"+this.idBase+
	 "' style='display: "+display+"'><table  class='subcaja' width='95%'>\n");   

    echo("<tr class='f lh'>"+
	 "<td class='iconos'>Atributos</td>"+
	 "<td class='local'>"+po_almacen+"</td>"+
	 "<td class='codigobarras'>CB</td>"+
	 "<td class='color'>"+po_color+"</td>"+
	 "<td class='talla'>"+po_talla+"</td>"+
	 "<td class='unidades'>"+po_unidades+"</td>"+
	 "<td class='precio'>"+po_costo+"</td>"+
	 "<td class='boton' width='80'>Opciones</td>"+
	 "<td class='iconos' width='10'>Selec</td></tr>\n"
	);   

}

function argsventana(width,height){
    x = (screen.width - width) / 2;
    y = (screen.height - height) / 3;       
    args = "dialogHeight:" + height+"px;dialogWidth:"+width +"px;dialogLeft:"+x+"px;dialogTop:"+y+"px";
    return args;
}

function verseries(idproducto,unidades){
    var main  = parent.getWebForm();
    var aviso = 'Cargando Número Series Almacén...';
    var url   = 'modulos/compras/selcomprar.php?id='+idproducto+'%modo=mostrarSeriesAlmacenxProducto%unid='+unidades;
    var lurl  = 'modulos/compras/progress.php?modo=lWebFormAlmacen&aviso='+aviso+'&url='+url;

    main.setAttribute("src",lurl);  
    parent.xwebCollapsed(true);

}

function visualizarserie(idbase){
    var main  = parent.getWebForm();
    var aviso = 'Cargando Número Series Almacén...';
    var url   = 'modulos/compras/selcomprar.php?id='+idbase+'%modo=mostrarSeriesAlmacen';
    var lurl  = 'modulos/compras/progress.php?modo=lWebFormAlmacen&aviso='+aviso+'&url='+url;

    main.setAttribute("src",lurl);  
    parent.xwebCollapsed(true);
}


function actualizarCantidadSeries(id,cantidad,fila){

        var caja      = document.getElementsByName("Cantidad"+fila);
	caja[0].value = cantidad;         

	actualizarImporte(fila);
	enviar();

}            

function actualizarCantidadCarrito(id,cantidad,precio,dscto,fila){

        var c_cantidad = document.getElementsByName("Cantidad"+fila);
        var c_precio   = document.getElementsByName("Precio"+fila);
        var c_dscto    = document.getElementsByName("Descuento"+fila);

	c_cantidad[0].value = cantidad;
	c_precio[0].value   = precio;
	c_dscto[0].value    = dscto;         

	actualizarImporte(fila);
	enviar();
}            


function visualizarNumSeries(id,fila){            

        var caja  = document.getElementsByName("Cantidad"+fila);
	var main  = parent.getWebForm();
	var aviso = 'Cargando Número Series Carrito Compras...';
	var url   = 'modulos/compras/selcomprar.php?id='+id+
	            '%modo=visualizarseriescart'+
		    '%u='+caja[0].value+
		    '%fila='+fila;

	var lurl  = 'modulos/compras/progress.php?modo=lWebFormCartSerieMod&aviso='+aviso+'&url='+url;

        main.setAttribute("src",lurl);  
	parent.xwebCollapsed(true);
}

function modificarCarritoProducto(fila,idproducto){

   var elcantidad = document.getElementsByName("Cantidad"+fila);
   var elprecio   = document.getElementsByName("Precio"+fila);
   var eldscto    = document.getElementsByName("Descuento"+fila);
   var dscto      = (eldscto)?    eldscto[0].value:0;
   var precio     = (elprecio)?   elprecio[0].value:0;
   var cantidad   = (elcantidad)? elcantidad[0].value:0;
   var menudeo    = getDatosProductoExtra(idproducto);
   var unidades   = 0;
   var main       = parent.getWebForm();
   var aviso      = 'Cargando formulario Carrito Compras...';

   cantidad       = parseFloat(cantidad);
   unidades       = ( menudeo[0]==1 )? cantidad % menudeo[1] : 0;
   cantidad       = ( menudeo[0]==1 )? ( cantidad - unidades ) / menudeo[1] : cantidad;

   var url = 'modulos/compras/selcomprar.php?'+
             'id='+idproducto+
	     '%modo=visualizarModificarProductoCarrito'+
	     '%manejalote='+menudeo[6]+
	     '%manejafv='+menudeo[7]+
	     '%menudeo='+menudeo[0]+
	     '%UContenedor='+menudeo[1]+
	     '%UMedida='+menudeo[2]+
	     '%Contenedor='+menudeo[3]+
	     '%manejaserie='+menudeo[5]+
	     '%CostoUnitario='+precio+
	     '%Cntidad='+cantidad+
	     '%dscto='+dscto+
	     '%unidades='+unidades+
	     '%fila='+fila;

    var lurl = 'modulos/compras/progress.php?modo=lWebFormCartMod&aviso='+aviso+'&url='+url;

    main.setAttribute("src",lurl);
    parent.xwebCollapsed(true);

 }

var oldbases = new Array();

function MuestraBases(id){
    //alert(nsbug.toSource());
    //status = oldbases[id];
    if(oldbases[id]) status=1;
    else status=0;
    var elemento = null;
    elemento = document.getElementById("base"+id);
    if (status==1){
        oldbases[id] = 0;
        if(elemento)
            elemento.style.display = "none";
    } else {

        if(elemento)
            elemento.style.display = "block";
        oldbases[id] = 1;
    }
}


function cAH(idBase,nombre,referencia,descripcion, L_local, L_familia, L_subfamilia,ManejaSerie,UnidadMedida,contenedor,ucontenedor,marca,ventamenudeo,lab){
  var o = new Producto(idBase);
  lastBase = idBase; //Ajuste de base activa
  iBase = 0;//Empieza un listado con bases
  o.idBase = idBase;
  o.nombre  = nombre;
  o.referencia = referencia;
  o.descripcion = descripcion;
  o.marca = marca;
  o.lab = lab;
  o.local = L[L_local];
  o.familia = L[L_familia];
  o.subfamilia = L[L_subfamilia];
  o.serie = ManejaSerie;
  o.unidadmedida = UnidadMedida;
  o.contenedor = contenedor;
  o.ventamenudeo = ventamenudeo;
  o.ucontenedor = ucontenedor;
  o.genLinea = genAlmacenLineaHead;
  o.iK = K;
  p[K++] = o;
}

var AutoFocusIdBase = 0;//Pone en foco en este elemento del almacen

function cListAlmacen() {
 var t,o;
 echo ("<table class='forma' width='85%'><tbody><tr class='formaCabeza' ><td colspan='5' ><table style='display: none'><div class='formaTitulo'> Resultado: <span id='list_total'>0</span> <input type='text' id='head_total' style='display:none'/> productos en <span id='list_totalfam'>0</span> familias listadas</div>");
 var oldref = "";
 var tstock = 0;
 for(t=0;t<K;t++) {
   o = p[t];
   if(o) tstock++;
   o.genLinea();

 }
 echo ("</table></td></tr></tbody></table>");
 echo ("<script>setTotalListproductos("+K+")</script>");
     
 if (AutoFocusIdBase){ 
 	setTimeout("SetFocoAlmacen('"+AutoFocusIdBase+"')",200); 	
 } 
}

function idElemento(nombre) { return document.getElementById(nombre); };

function SetFocoAlmacen(idBase){
	var basediv = idElemento("base"+idBase);	
	if (!basediv) return;
	if (!basediv.focus) return;
	basediv.focus();			
}

var TIPO_HEAD = 1;
var TIPO_NORMAL = 0;

function cListProductos() {
 var t,o;
 echo ("<table class='forma' width='"+ancho_lista+"'><tbody><tr class='formaCabeza'><td colspan='5'><table style='display: none'><div id='t_comprov' class='formaTitulo'> Resultado: <span id='list_total'>0</span> <input type='text' id='head_total' style='display:none'/> productos en <span id='list_totalfam'>0</span> familias listadas</div>");
 var oldtipo = 0; 
 for(t=0;t<K;t++) {
   o = p[t];
   o.genLinea();   
   var tipo = p[t].tipo;
   if ((t+1)<K){
    var nextipo = p[t+1].tipo;
     if ( nextipo == TIPO_HEAD && tipo == TIPO_NORMAL ) {
        o.genResumen();
     }
   } else {
      o.genResumen();
   }
 }
 echo ("</table></td></tr></tbody></table>");
 echo ("<script>setTotalListproductos("+K+")</script>");
}

function cListCompras() {
 var t,o;
 
 echo ("<table class='forma' id='listProductoCompras' width='"+ancho_lista+"'><tbody><tr class='formaCabeza'><td colspan='5'><table style='display: none'><div id='t_comprov' class='formaTitulo'> Resultado: <span id='list_total'>0</span> <input type='text' id='head_total' style='display:none'/> productos en <span id='list_totalfam'>0</span> familias listadas</div>");
 for(t=0;t<K;t++) {
   o = p[t];
   o.genLinea();
 }
 echo ("</table></td></tr></tbody></table>");
 echo ("<script>setTotalListproductos("+K+")</script>");
}



/*=============== SISTEMAS AUXILIARES =============*/

function getDatosProductoExtra(idproducto){

    var	url = "services.php?modo=datosproductoextra&id="+idproducto;

    var xrequest = new XMLHttpRequest();
    xrequest.open("GET",url,false);
    xrequest.send(null);

    return xrequest.responseText.split(",");

}
function AgnadirProductoCompra(idproducto,manejaserie,manejalote,manejafv,eservicio,trasAlta,esPopup=0){
    var main       = (esPopup)? parent.document.getElementById("windowloadcart"):parent.getWebForm();
    var xval       = (esPopup)? '&':'%';
    var menudeo    = getDatosProductoExtra(idproducto);
    var noProducto = false;
    var aviso      = 'Cargando formulario Carrito Compras...';

    noProducto     = (menudeo[8]==1)?'Meta Producto':false; 
    noProducto     = (menudeo[9]==1)?'Servicio':noProducto; 

    if(noProducto)
       return alert("gPOS:\n\n Este es un "+noProducto+"; producto reservado de uso interno.");

    var url  = 'modulos/compras/selcomprar.php?'+
               'id='+idproducto+
	        xval+'modo=visualizarAgnadirProductoCompra'+
	        xval+'manejalote='+manejalote+
	        xval+'manejafv='+manejafv+
	        xval+'menudeo='+menudeo[0]+
	        xval+'UContenedor='+menudeo[1]+
	        xval+'UMedida='+menudeo[2]+
	        xval+'Contenedor='+menudeo[3]+
	        xval+'manejaserie='+manejaserie+
	        xval+'CostoUnitario='+menudeo[4]+
	        xval+'trasAlta='+trasAlta+
	        xval+'esPopup='+esPopup;
		
    var lurl = 'modulos/compras/progress.php?modo=lWebFormCartBuy&aviso='+aviso+'&url='+url;
    var xurl = (esPopup)? url:lurl;

    main.setAttribute("src",xurl);

    if( esPopup ) setWebBoxCollapsed(true);
    else          parent.xwebCollapsed(true);
}

function getWebBox(xframe){
    return ;
}

function setWebBoxCollapsed(xval){

 if( parent.document.getElementById("windowloadcart") ){
    parent.document.getElementById("windowpopup").className     = ( xval  )? 'noxframe':'xframe';
    parent.document.getElementById("windowloadcart").className = ( !xval  )? 'noxframe':'xframe';
 }else{

    if( document.getElementById("windowpopup")  ){
     document.getElementById("windowpopup").className     = ( xval  )? 'noxframe':'xframe';
     document.getElementById("windowloadcart").className = ( !xval  )? 'noxframe':'xframe';
    }
 }

}


function getMe(layerID) {      //busca elemento y lo devuelve
            if(document.getElementById){
                  return document.getElementById(layerID);
            }else if(document.all){
                  return document.all[layerID];
            }else if(document.layers){
                  return document.layers[layerID];
            }
            return null;
}

function deshabilitar(xthis,xblock){

//All check
if( xblock == 1) {
  return xthis.checked= ( !xthis.checked );
}

//Check Menudeo
if( xthis )
   if(xthis.id=='ventamenudeo'){
     if(xthis.checked) { 
          MuestraCapa("Motivo1"); 
          MuestraCapa("Motivo2");} 
     else {
       OcultaCapa("Motivo1");
       OcultaCapa("Motivo2");
     }
     return;
   }

 var unidmed      = document.getElementById("UnidadMedida");
 var check        = document.getElementById("NumeroSerie");
 var mtprod       = document.getElementById("MetaProducto");
 var servicio     = document.getElementById("Servicio");
 var lote         = document.getElementById("Lote");
 var fv           = document.getElementById("FechaVencimiento");
 var ventamenudeo = document.getElementById("ventamenudeo");
 var aplicamargen = document.getElementById("margensubfamilia");
 //existe?
 unidmed  = (unidmed)?  unidmed:false;
 check    = (check)?    check:false;
 mtprod   = (mtprod)?   mtprod:false;
 servicio = (servicio)? servicio:false;
 lote     = (lote)?     lote:false;
 fv       = (fv)?       fv:false;
 ventamenudeo = (ventamenudeo)? ventamenudeo:false;
 aplicamargen = (aplicamargen)? aplicamargen:false;

 if(unidmed && unidmed.value!='und')
  {
    check.checked=false; 
    mtprod.checked = false;
    servicio.checked=false;
  }

 if(mtprod.checked)
  {
   mtprod.checked = true;
   check.checked=true;
   mtprod.checked=true;
   ventamenudeo.checked=false;
   OcultaCapa("Motivo1");
   OcultaCapa("Motivo2");
   OcultaCapa("Motivo3"); 
  }

 if(servicio.checked)
  {
   servicio.checked=true;
   check.checked=false;
   lote.checked=false;
   fv.checked=false;
   mtprod.checked=false;
   ventamenudeo.checked=false;
   MuestraCapa("Motivo3"); 
   OcultaCapa("Motivo1");
   OcultaCapa("Motivo2");
  } else {
   OcultaCapa("Motivo3"); 
  }

 if(lote.checked)
  {
   lote.checked=true;
   servicio.checked=false;
   check.checked=false;
   mtprod.checked=false;
  }
 if(fv.checked)
  {
   fv.checked=true;
   servicio.checked=false;
   check.checked=false;
   mtprod.checked=false;
  }
 if(ventamenudeo.checked) {

     OcultaCapa("Motivo3"); 
     MuestraCapa("Motivo1"); 
     MuestraCapa("Motivo2");

 } else {
     OcultaCapa("Motivo1"); 
     OcultaCapa("Motivo2");
  }

 if(aplicamargen.checked) {
   MuestraCapaBase("MargenSubFamiliaTipoCosto"); 
   ListarProductosxSubFamilia();
 }
 else 
   OcultaCapa("MargenSubFamiliaTipoCosto"); 

}

function ListarProductosxSubFamilia(){

   var tipocosto= getMe("TipoCosto").value;
   var mud      = getMe("muvd").value;
   var muc      = getMe("muvc").value;
   var dsto     = getMe("dsto").value;
   var id       = getMe("IdBase").value;

   var	url = "modfamilias.php?modo=editarsubfamilia&mud="+mud+
     "&muc="+muc+"&dsto="+dsto+"&tipocosto="+tipocosto+"&id="+id;
   //return alert(url);
   location.href=url;
   
}

function MuestraCapaSubFamilia(nombre){
  var capa = getMe(nombre);
  if (!capa) 
    return;
 
  capa.style.visibility = "visible";
  capa.style.block = "auto";
}

function MuestraCapa(nombre){
  var servicio     = document.getElementById("Servicio");
  var check        = document.getElementById("NumeroSerie");
  var mtprod       = document.getElementById("MetaProducto");

  if(servicio && nombre !='Motivo3') servicio.checked = false;
  if(check)    check.checked    = false;
  if(mtprod)   mtprod.checked   = false;

  var capa = getMe(nombre);
  if (!capa) 
    return;
 
  capa.style.visibility = "visible";
  capa.style.block = "auto";
}

function OcultaCapa(nombre){
  var capa = getMe(nombre);
  if (!capa) 
    return;
 
  capa.style.visibility = "hidden";
  capa.style.block = "auto";
}
function desapareceCapa(nombre){

  var capa = getMe(nombre);
  if (!capa) 
    return;
  capa.style.display = "none";
  capa.style.block = "auto";
}
function apareceCapa(nombre){

  var capa = getMe(nombre);
  if (!capa) 
    return;

   switch(nombre){
        case 'vtotalmonedabase': 
        case 'ctotalmonedabase': 
	  capa.style.display = "block";
	break;

	default:
 	  capa.style.display = "inline";
	  capa.style.block   = "auto";
   }
}

function s_radioComprobante(aux){
   cTipoPresupuestoCart = aux;
   switch(aux){
        case 'O':
	desapareceCapa('ndoc');
	apareceCapa('fdoc');
	apareceCapa('acred');
	apareceCapa('pgdoc');
	desapareceCapa('albdoc');
	CambiaTextDoc(1,'Pedido');
	incluirIGV(true);
	cambiodoc('O');
	break;

        case 'F':
	apareceCapa('ndoc');
	apareceCapa('fdoc');
	apareceCapa('acred');
	apareceCapa('pgdoc');
	apareceCapa('albdoc');
	CambiaTextDoc(0,'Factura'); 
	cambiodoc('F');
	break;

        case 'R':
	apareceCapa('ndoc');
	apareceCapa('fdoc');
	apareceCapa('acred');
	apareceCapa('pgdoc');
	desapareceCapa('albdoc');
	CambiaTextDoc(0,'Boleta'); 
	cambiodoc('R');
	break;

        case 'G':
	apareceCapa('ndoc');
	apareceCapa('pgdoc');
	apareceCapa('acred');
	apareceCapa('fdoc');
	desapareceCapa('albdoc');
	CambiaTextDoc(0,'Albarán'); 
	cambiodoc('G');
	break;
	
        case 'SD':
	desapareceCapa('ndoc');
	apareceCapa('fdoc');
	desapareceCapa('acred');
	desapareceCapa('albdoc');
	apareceCapa('pgdoc');
	CambiaTextDoc();
	CambiaTextDoc(0,'Ticket'); 
	cambiodoc('SD');
	break;
   }

}

function CambiaTextDoc(op,ttext){

  var ftext = getMe('fecha_op');
  var bcapt = parent.document.getElementById("bcapturar");
  var bcanc = parent.document.getElementById("bcancelar");
  var tcomp = document.getElementById("t_comprov");

  if(ttext)
   tcomp.innerHTML = ttext;

  if (!ftext) 
    return;
  if(op){  
    ftext.firstChild.nodeValue="Fecha Entrega:";
    bcapt.setAttribute("label",' Finalizar Pedido');
    bcanc.setAttribute("label",' Cancelar Pedido');
  }
  else{
    ftext.firstChild.nodeValue="Fecha Emisión:";
    bcapt.setAttribute("label",' Finalizar Compra');
    bcanc.setAttribute("label",' Cancelar Compra');
  }
}


//Cambia el valor de un campo para nombre conocido

function AjustarCampo(nombre,valor){

 getMe(nombre).value = valor;

}

function formatDineroBase(numero) {
    
    var num = new Number(numero);
    num = num.toString();
    
    if(isNaN(num)) num = "0";
    
    num = Math.round(num*100)/100;
    //num = Math.round(num*10)/10;
    //more  alert(num);
    var sign = (num == (num = Math.abs(num)));
    num = num.toFixed(2);
    	var num = new Number(numero);
        num = num.toString().replace(/\$|\,/g,'');
	
        if(isNaN(num)) num = "0";
	
        var sign = (num == (num = Math.abs(num)));
        num = Math.floor(num*100+0.50000000001);
        var cents = num%100;
        num = Math.floor(num/100).toString();
	
        if(cents<10) cents = "0" + cents;
	
        for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
            num = num.substring(0,num.length-(4*i+3))+','+ num.substring(num.length-(4*i+3));
	    
            return (((sign)?'':'-') + num + '.' + cents);
    return (((sign)?'':'-') + num );   
}

function trimBase(cadena) { 
    cadena = new String(cadena);
    for(i=0; i<cadena.length; ) { 
        if(cadena.charAt(i)==" " || cadena.charAt(i)=="\t" ) 
            cadena=cadena.substring(i+1, cadena.length); 
        else 
            break; 
    } 
    for(i=cadena.length-1; i>=0; i=cadena.length-1) { 
        if(cadena.charAt(i)==" " || cadena.charAt(i)=="\t" ) 
            cadena=cadena.substring(0,i); 
        else 
            break; 
    } 
    return cadena; 
}

function soloNumerosBase(evt,num){
    keynum = (window.event)?evt.keyCode:evt.which;
    if(keynum == 46) 
    {
        var sChar=String.fromCharCode(keynum);
        if(isNaN(num+sChar)) return false;
    }
    return (keynum <= 13 || (keynum >= 48 && keynum <= 57) || keynum == 46);
}

function soloNumerosEnterosBase(evt,num){
    // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46
    keynum = (window.event)?evt.keyCode:evt.which;
    if(keynum == 46) 
    {
        var sChar=String.fromCharCode(keynum);
        if(isNaN(num+sChar)) return false;
    }
    return (keynum <= 13 || (keynum >= 48 && keynum <= 57));
}

function soloNumericoCodigoSerieBase(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "-0123456789";
    especiales = [8, 13, 9];
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

function selImpresion(tipo,id){    
 
  p = prompt( po_cuantascopias , '1')

  if (p>0){
     popup('selimpresion.php?modo='+tipo+'&id='+id+'&copias='+p,'codigobarras');
  }
}

function selAllImpresion(){    
     popup('vercarrito.php?modo=imprimirtodas','printallcb');
}

function soloAlfaNumericoBase(e){

    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " abcdefghijklmnñopqrstuvwxyz0123456789%-";
    especiales = [8, 13, 9, 39, 46];
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

function soloAlfaNumericoCadenaBase(e){
    
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "abcdefghijklmnñopqrstuvwxyz0123456789%-,";
    especiales = [8, 13, 9, 39];
    tecla_especial = false;

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

function soloAlfaNumericoSerieBase(e){

    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "abcdefghijklmnopqrstuvwxyz0123456789";
    especiales = [8, 13, 9, 39, 46];
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

function soloAlfaNumericoCodigoBase(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "abcdefghijklmnopqrstuvwxyz0123456789";
    especiales = [8, 13, 9, 39, 46];
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

function soloAlfaNumericoReferenciaFabrBase(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "abcdefghijklmnñopqrstuvwxyz0123456789-";
    especiales = [8, 13, 9, 39];
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

function editatemplate(id) {		     
 window.open( "modtemplates.php?modo=editar&id=" + id,
 'Input',
 'dependent=yes,width=1100,height=750,screenX=0,screenY=0,titlebar=yes');	
}


function dotab(e,me) //Captura tab y lo mete en donde estemos
{

 if (!e) {
   e = window.event;
   return false; 
 } 

 if (e.keyCode == 9) // tab 
 {
 //   e.srcElement.value = e.srcElement.value + "\\\\t";
   // e.srcElement.focus() 
    me.value = me.value + "\\\\t";
   me.focus();

    return false;
 }
 return true;
}


//Combos de cambiar familia, subfamilia, color...

function ResetMarca() {  
  o = getMe("IdMarca");
  if (o) o.value = false;
  o = getMe("TextoMarca");
  if (o) o.innerHTML = "";
}

function ResetTalla() {  
  o = getMe("IdTalla");
  if (o) o.value = false;
  o = getMe("TextoTalla");
  if (o) o.innerHTML = "";
}

function ResetSubfamilia() {  
  o = getMe("IdSubFamilia");
  if (o) o.value = false;
  o = getMe("TextoSubFamilia");
  if (o) o.innerHTML = "";
}

function ResetProveedorHab() {  
  o = getMe("IdProvHab");
  if (o) o.value = false;
  o = getMe("TextoProvHab");
  if (o) o.innerHTML = "";
}

function ResetColor() {  
  o = getMe("IdColor");
  if (o) o.value = false;
  o = getMe("TextoColor");
  if (o) o.innerHTML = "";
}

//
// VENTANAS AUXILIARES
//

function auxCarritoCompra(){     popup('vercarrito.php?modo=check','carrito');  }
//function auxCarritoMover(){     popup('modulos/almacen/vertrans.php?modo=check','carrito');  }
function auxSeleccionRapidaAlmacen(IdLocal){    popup('modulos/almacen/selalmacen.php?modo=empieza&IdLocal='+IdLocal,'selalmacen'); }
function auxAlta(){    popup('modulos/altarapida/altarapida.php?modo=altaycompra','alta');  }
function auxColor(idfamilia){    popup('modulos/productos/selmodelo.php?modo=color&idfamilia='+idfamilia,'color');  }
function auxProductoAlias(idfamilia,id,txtalias){    popup('modulos/productos/selproductoalias.php?modo=alias&idfamilia='+idfamilia+'&id='+id+'&txtalias='+txtalias,'color');  }
function auxProveedorHab() {     popup('modulos/proveedores/selproveedor.php?modo=proveedorhab','proveedorhab');  }
function auxSubsidiarioHab() {     popup('modulos/subsidiarios/selsubsidiario.php?modo=subsidiariohab','proveedorhab');  }
function auxLaboratorioHab() {     popup('modulos/laboratorios/sellaboratorio.php?modo=laboratoriohab','laboratoriohab');  }
function auxAltaProv() { popup('modproveedores.php?modo=altapopup','altaproveedor'); }
function auxAddProdCart() { popup('modcompras.php?modo=buscarproductos','addprodcart'); }
function auxAltaSubsidiario() { popup('modsubsidiarios.php?modo=altapopup','altaproveedor'); }
function auxAltaLab() { popup('modlaboratorios.php?modo=altapopup','altalaboratorio'); }
function auxMarca(){    popup('modulos/productos/selmarca.php?modo=marca','marca'); }
function auxTipoServicio(){    popup('modulos/productos/seltiposervicio.php?modo=servicio','servicio'); }
function auxContenedor(){    popup('modulos/productos/selcontenedor.php?modo=contenedor','contenedor'); }

function auxTalla(tipo,idfamilia){    
 if (tipo=='nuevo') { //Se debe elegir primero tallaje
   popup('modulos/productos/selmodelo.php?modo=tallaje&idfamilia='+idfamilia,'talla');     
   return;
 }
 popup('modulos/productos/selmodelo.php?modo=talla&IdTallaje='+tipo+'&idfamilia='+idfamilia,'talla');  
}


function auxFamilia(){
    //ResetSubfamilia();
    var vfamilia = getMe("IdFamilia").value;
//    popup('modulos/productos/selfamilia.php?modo=familia','familia');
    popup('modulos/productos/selsubfamilia.php?modo=familia&IdFamilia='+vfamilia,'familiaplus');
}

function auxSubFamilia(){
	auxFamilia();
/*
  var vfamilia = getMe("IdFamilia").value;

  popup('modulos/productos/selfamilia.php?modo=subfamilia&IdFamilia='+vfamilia,'subfamilia');
  */
}

function auxNroCuenta(idprov,nro){    
  popup("modulos/pagoscobros/selcuentabancaria.php?modo=cuenta&xidprov="+idprov+"&xcta=0"+"&xnro="+nro,'cuenta');
}

function change(o,label){
  value = o.value;
  vf = getMe("TextoFamilia");

 if (!vf) {
  window.alert("no texfamilia!");
  return;
 }
 vf.innerHTML = ""+ label+ "";

 vf = getMe("IdFamilia");

 if (!vf) {
  window.alert("no idsub!");
  return;
 }
 
 vf.value = value;
}


function changeFamYSub(idsubfamilia,idfamilia,texsubfamilia, texfamilia ){

 //alert("Recibe: idsub"+idsubfamilia+",idfam"+idfamilia+",texsub["+texsubfamilia+",texfam["+texfamilia);
 getMe("TextoFamilia").innerHTML = ""+ texfamilia + "";
 getMe("TextoSubFamilia").innerHTML = ""+ texsubfamilia + "";
 getMe("IdFamilia").value = idfamilia;
 getMe("IdSubFamilia").value = idsubfamilia;
 UpTextBaseDescrip();

}

function changeUM(valor){

   var medida       ="";
   var servicio     = document.getElementById("Servicio");
   var check        = document.getElementById("NumeroSerie");
   var mtprod       = document.getElementById("MetaProducto");

   if(check)
   check.checked    = (valor=='und')?true:false;

   if(mtprod)
   mtprod.checked   = (mtprod.checked)?false:false;

   if(servicio)
     servicio.checked = (servicio.checked)?false:false;

   switch(valor){
        case 'und':
                medida="Unidades";
                break;
        case 'mts':
                 medida="Metros";
                break;
        case 'lts': 
                medida="Litros";
                break;

        case 'kls':
                medida="Kilos";
                break;
    }
    getMe("UM").innerHTML = ""+medida+"";
}


function changeProvHab(o,label){
  value = o.value;
  modo =getMe('modopagina');
  if(modo){
    if(modo.value=='Compras'){
        var ndoc = getMe('NDoc');
        var url = "services.php?modo=checkndocCompra&ndoc="+ndoc.value+"&idprov="+value;
        var xrequest = new XMLHttpRequest();
        xrequest.open("GET",url,false);
        xrequest.send(null);
        var resultado = xrequest.responseText;
        if(resultado=='0'){
            var ndoc = document.getElementById("NDoc");
            alert("gPOS:\n\n Existe un registro de este Nro. Documento para este Proveedor.");
            ndoc.focus();
            return;
        }
        if(resultado=='1'){
                var	url = "services.php?modo=setprovdocCompra&provdoc="+value+"&nombreprov="+label;
                var xrequest = new XMLHttpRequest();
                xrequest.open("GET",url,false);
                xrequest.send(null);
                //var buscar = parent.document.getElementById("btnbuscar");
                //buscar.oncommand();
		//parent.Compras_buscar()
        }
     }
   }

   vf = getMe("TextoProvHab");
   if (!vf) 
      return window.alert("no prov hab!");

   vf.innerHTML = label;
   vf.setAttribute("value",label);

  vf = getMe("IdProvHab");
  if (!vf) 
      return window.alert("no idprohab!");
 
   vf.value = value;
 }

function changeSubsidHab(o,label){
  value = o.value;
  vf = getMe("TextoSubsiHab");
  vf.setAttribute("value",label);
  vf = getMe("IdSubsiHab");
  vf.value = value;

  var url = "services.php?modo=setsubsiddocCompra&subsiddoc="+value+"&nombresubsid="+label;
  var xrequest = new XMLHttpRequest();
  xrequest.open("GET",url,false);
  xrequest.send(null);

}


function changeLabHab(o,label){
  value = o.value;
  vf = getMe("TextoLabHab");

 if (!vf) {
  window.alert("no lab hab!");
  return;
 }
 vf.innerHTML = ""+ label+ "";

 vf = getMe("IdLabHab");

 if (!vf) {
  window.alert("no idlabhab!");
  return;
 }
 
 vf.value = value;
}


function changeSub(o,label){
  valor = o.value;
 
  vf = getMe("TextoSubFamilia");

 if (!vf) {
  window.alert("no textofamilia!");
  return;
 }
 vf.innerHTML = ""+ label+ "";

 vf = getMe("IdSubFamilia");

 if (!vf) {
  window.alert("no idsub!");
  return;
 } 
 vf.value = valor;
 UpTextBaseDescrip();
}



function changeColor(o,label){
  valor = o.value;
 
  vf = getMe("TextoColor");

 if (!vf) {
  window.alert("no textocolor!");
  return;
 }
 vf.innerHTML = ""+ label+ "";

 vf = getMe("IdColor");

 if (!vf) {
  window.alert("no color!");
  return;
 } 
 vf.value = valor;
}

function changeProductoAlias(o,label,vid){

  var valor    = o.value;
  var idalias0 = getMe("IdProductoAlias0");
  var idalias1 = getMe("IdProductoAlias1");

  //Control
  if( idalias0.value == valor ) return;
  if( idalias1.value == valor ) return;

  var txtAlias = getMe("TextoProductoAlias"+vid);
  var idAlias  = getMe("IdProductoAlias"+vid);

  txtAlias.innerHTML = ""+ label+ "";
  idAlias.value      = valor;
  return;

}

function changeNewProductoAlias(valor,label,vid){

  var txtAlias = getMe("TextoProductoAlias"+vid);
  var idAlias  = getMe("IdProductoAlias"+vid);

  txtAlias.innerHTML = ""+ label+ "";
  idAlias.value      = valor;
}

function changeNewColor(IdColor,label){
  valor = IdColor;
 
  vf = getMe("TextoColor");

 if (!vf) {
  window.alert("no textocolor!");
  return;
 }
 vf.innerHTML = ""+ label+ "";

 vf = getMe("IdColor");

 if (!vf) {
  window.alert("no color!");
  return;
 } 
 vf.value = valor;
}


function changeTalla(o,label){
  valor = o.value;
 
  vf = getMe("TextoTalla");

 if (!vf) {
  window.alert("no textotalla!");
  return;
 }
 vf.innerHTML = ""+ label+ "";

 vf = getMe("IdTalla");

 if (!vf) {
  window.alert("no talla!");
  return;
 } 
 vf.value = valor;
}

function changeNewTalla(idtalla,label){
  valor = idtalla;
 
  vf = getMe("TextoTalla");

 if (!vf) {
  window.alert("no textotalla!");
  return;
 }
 vf.innerHTML = ""+ label+ "";

 vf = getMe("IdTalla");

 if (!vf) {
  window.alert("no talla!");
  return;
 } 
 vf.value = valor;
}

function changeMarca(o,label){
  valor = o.value;
 
  vf = getMe("TextoMarca");

 if (!vf) {
  window.alert("no textomarca!");
  return;
 }
 vf.innerHTML = ""+ label+ "";

 vf = getMe("IdMarca");

 if (!vf) {
  window.alert("no marca!");
  return;
 } 
 vf.value = valor;
}

function changeNewTipoServicio(xid,label){
  var vf = getMe("TextoTipoServicio");
  var xf = getMe("IdTipoServicio");
  vf.innerHTML = ""+ label+ "";
  xf.value = xid;
}

function changeTipoServicio(valor,label){

  var txtTP = getMe("TextoTipoServicio");
  var tdTP  = getMe("IdTipoServicio");
  txtTP.innerHTML = ""+ label+ "";
  tdTP.value = valor;
}

function changeContenedor(o,label){
  valor = o.value;
 
  vf = getMe("TextoContenedor");

 if (!vf) {
  window.alert("no textocontenedor!");
  return;
 }
 vf.innerHTML = ""+ label+ "";

 vf = getMe("IdContenedor");

 if (!vf) {
  window.alert("no contenedor!");
  return;
 } 
 vf.value = valor;
}

function AjustarModo(modo) {
 AjustarCampo('modoactual',modo);
}						

/*==== SISTEMAS COMUNICACION ASINCRONA ==========*/

var xmlhttp;

function remoteThis(url) {  
  xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange=xmlhttpChange;
  xmlhttp.open("GET",url,true);
  xmlhttp.send(null);
}

function Mensaje(url) {  
  xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange=DummyFunction();
  xmlhttp.open("GET",url,true);
  xmlhttp.send(null);
}

function DummyFunction() {};


function xmlhttpChange() {
 if (xmlhttp.readyState==4) {  // if "OK"
  if (xmlhttp.status==200) {         eval( xmlhttp.responseText );           } 
 }
}

function genMensajeros(){};


//Al documento en curso lo llama y le pasa el campo y su valor actual, para que compruebe su validez.
function Valida(me) {
  var url = document.location.href.split("?");
  remoteThis(url[0] + "?modo=valida&campo="+me.name+"&valor="+me.value+"&idcampo="+me.id);
}

function preciosugerido(){
  var elemento    = document.getElementById("PrecioVenta");
  var elemento2   = document.getElementById("CosteSinIVA");
  elemento2.value = parseFloat(elemento2.value);
  var valorventa  = parseFloat(elemento2.value) + parseFloat(elemento2.value)*cMargenUtil/100;
  elemento.value  = Math.round( (parseFloat(valorventa) + parseFloat(valorventa) * cIGV/100)*100)/100;
}

//"	" <-- tabulador

/*==== SISTEMAS COMUNICACION ASINCRONA ==========*/

/*========== GRAFOS ICONOS ============*/
var icons = new Array();

icons["$"] = "<img src='img/gpos_sinoferta.png'>";
icons["S"] = "<img src='img/gpos_enoferta.png'>";
//icons["V"] = "<img src='img/enventa16.gif'>";
//icons["x"] = "<img src='img/enventa16gray.gif'>";
icons["V"] = "<img src='img/gpos_enventa.png'>";
icons["x"] = "<img src='img/gpos_reservado.png'>";



/* Convierte grafos en imagenes */
function Iconos2Images(cad){
 var out;
 if(!cad) return;
 out = icons[cad[0]]+" "+icons[cad[2]];
 return out;
}

/* Convierte grafos en imagenes y emite por pantalla */
function gI2I(cad){
 echo(Iconos2Images(cad));
}


var icon_stock 		= "<img src='img/gpos_cajavacia.png'>";
var icon_stockfull 	= "<img src='img/gpos_cajallena.png'>";
var icon_productos 	= "<img src='img/gpos_productos.png'>";
var icon_servicios 	= "<img src='img/gpos_servicio.png'>";
var icon_bar 		= "<img src='img/gpos_barcode.png'>";

function iconStockMark(idmark)
{
    return "<img id='icon_stock_"+idmark+"' src='img/gpos_cajavacia.png'>";
}


function verseriescarritoalma(unidades,id,producto){

    var main  = parent.getWebForm();
    var aviso = 'Cargando Existencias ...';
    var url   = 'modulos/compras/selcomprar.php?modo=mostrarSeriesAlmacenCarrito'+
                '%xproducto='+producto+
                '%unid='+unidades+
                '%xalmacen='+id;

    var lurl  = 'modulos/compras/progress.php?modo=lWebFormAlmacen&aviso='+aviso+'&url='+url;

    main.setAttribute("src",lurl);  
    parent.xwebCollapsed(true);

}

function verificarDescuento(){
  var muvd = document.getElementById("muvd").getAttribute('value');
  var muvc = document.getElementById("muvc").getAttribute('value');
  var dsto = document.getElementById("dsto").getAttribute('value');
}

function habilitarpasslocal(){
 var conpass = document.getElementById("concontrasenia");
 conpass = (conpass)? conpass:false;

 if(conpass.checked) {
   MuestraCapaBase("rPassword"); 
 }
 else 
   OcultaCapa("rPassword"); 
}

function MuestraCapaBase(nombre){
  var capa = getMe(nombre);
  if (!capa) 
    return;
 
  capa.style.visibility = "visible";
  capa.style.block = "auto";
}

function validarPasswordLocal(){

  var conpass = document.getElementById("concontrasenia");

  conpass = (conpass)? conpass:false;
  if(conpass.checked){
    var xpass = getMe('Password');
    var pass  = xpass.value;
    var login = getMe('Identificacion').value;

    validarPassword(pass,login);
  }
}

function validarPasswordUser(){
  var pass = getMe('Password').value;
  var login = getMe('Identificacion').value;
  validarPassword(pass,login);
}



function validarPassword(xpass,login){
  if(login == xpass){
    getMe('Password').value = '';
    alert("La contraseña debe ser diferente de identificación");
    return ;
  }

  if(xpass.length < 8){
    getMe('Password').value = '';
    alert("La contraseña debe ser como mínico 8 caracteres");
    return;
  }

  var tchar = contienCharNum(1,xpass);
  var tnum  = contienCharNum(0,xpass);

  if(tchar == 0 || tnum == 0){
    getMe('Password').value = '';
    alert("La contraseña debe contener caracteres, números y símbolos");
    return;
  }

}

function contienCharNum(xchar,texto){
  xchar = (xchar == 0)? "0123456789":"abcdefghyjklmnñopqrstuvwxyz"
  texto = texto.toLowerCase();

  for(i=0; i<texto.length; i++){
      if (xchar.indexOf(texto.charAt(i),0)!=-1){
         return 1;
      }
   }
   return 0;
}

function mostrarGrupoLocales(xval){
  if(xval != 0) {
    MuestraCapaBase("rGrupoLocales"); 
  }
  else 
    OcultaCapa("rGrupoLocales"); 
}

function verficarExistenciaLocal(ident){

  var idlocal  = getMe('id').value;
  var url      = "services.php?modo=existelocal&ident="+ident+'&idl='+idlocal;
  var xrequest = new XMLHttpRequest();
  xrequest.open("GET",url,false);
  xrequest.send(null);
  var res   = xrequest.responseText;
  var local = getMe('NombreComercial').value;

  if(res){
    alert("gPOS: el local está registrado" );
    if(idlocal != 0)
      location.href = 'modlocal.php?modo=editar&id='+idlocal; 
    else
      getMe('Identificacion').value = '';
  }
}

function verficarExistenciaUsuario(ident){
  
  var iduser   = (getMe('id'))? getMe('id').value:0;
  var url      = "services.php?modo=existeuser&ident="+ident+'&idu='+iduser;
  var xrequest = new XMLHttpRequest();
  xrequest.open("GET",url,false);
  xrequest.send(null);
  var res  = xrequest.responseText;
  var user = getMe('Nombre').value;

  if(res){
    alert("gPOS: el usuario está registrado" );
    if(iduser != 0)
      location.href = 'modusers.php?modo=editar&id='+iduser; 
    else
      getMe('Identificacion').value = '';
  }
}

function changeNroCuenta( quien, txtcuenta, idprov, nro) {

    if(idprov == 0){
      if(nro == 1){
	getMe('IdCuentaBancaria').value = quien.value;
	getMe('CuentaBancaria').value = txtcuenta;
      }
      if(nro == 2){
	getMe('IdCuentaBancaria2').value = quien.value;
	getMe('CuentaBancaria2').value = txtcuenta;
      }

    }else{
      if(nro == 1){
	getMe('IdCuentaBancaria').value = quien.value;
	getMe('CuentaBancaria').value = txtcuenta;
      }
      if(nro == 2){
	getMe('IdCuentaBancaria2').value = quien.value;
	getMe('CuentaBancaria2').value = txtcuenta;
      }
    }
}

function Compras_buscar(){
  setTimeout("run_Compras_buscar()",400);
}
function run_Compras_buscar()
{  
  var xnombre     = document.getElementById("c_Nombre").value; 
  var codigo      = document.getElementById("c_CB").value;
  var referencia  = document.getElementById("c_Referencia").value;
  var obsoletos   = ( document.getElementById("c_Obsoletos").checked )?1:0;
  var porproveedor= ( document.getElementById("c_PorProveedor").checked )?1:0;
  var stockminimo = ( document.getElementById("c_StockMinimo").checked )?1:0;

  var extra ="";
	extra = extra + "&CodigoBarras="+codigo;
	extra = extra + "&Nombre="+xnombre;
	extra = extra + "&Referencia="+referencia;
	extra = extra + "&Obsoletos="+obsoletos;
	extra = extra + "&PorProveedor="+porproveedor;
	extra = extra + "&StockMinimo="+stockminimo;

  url = "modcompras.php?modo=buscarproductos" + extra; 
  location.href=url;
  //subweb.setAttribute("src", url);
  //document.getElementById("c_Nombre").focus();
}

function setTotalListproductos(xAll){
  if(xAll>0) 
  {
    idElemento('list_total').innerHTML=parseInt(xAll)-parseInt(idElemento('head_total').value);
    idElemento('list_totalfam').innerHTML=idElemento('head_total').value;
  }
  idElemento('head_total').value=0;
}

function validaFechaDDMMAAAA(xfecha){
return /^(0[1-9]|[12]\d|3[01])\/(0[1-9]|1[0-2])\/(19|20)\d{2}$/.test(xfecha);
}

function VerificarNumeroFiscal(xtipocliente){
  var nfiscal = document.getElementById("NumeroFiscal").value;
  var xclient = (document.getElementById("IdCliente"))? document.getElementById("IdCliente").value:false;
  var xval = "";

  switch(xtipocliente){
    case 'Empresa':
      if(nfiscal != '' && nfiscal.length != 11)
	xval = 'RUC debe tener 11 dígitos';

      if(existeNumeroFiscal(nfiscal,false,'Cliente'))
	xval = 'RUC: '+nfiscal+", ya está registrado";
      break;
    case 'Particular':
      if(nfiscal != '' && nfiscal.length != 8)
	xval = 'DNI debe tener 8 dígitos';
      if(existeNumeroFiscal(nfiscal,false,'Cliente'))
	xval = 'DNI: '+nfiscal+", ya está registrado";
      break;
  }

  if(xval != ''){
    var oldfiscal = obtnenerNumeroFiscal(nfiscal,xclient,'Cliente');
    document.getElementById("NumeroFiscal").value = (xclient)? oldfiscal:'';
    alert(xval);
    document.getElementById("NumeroFiscal").focus();
    return;
  }
}

function obtnenerNumeroFiscal(nfiscal,xid,xtipo){
  //var xprov = (esprov)? '1':'';
  var url = "services.php?modo=verificarnumerofical&xnfiscal="+nfiscal+"&xid="+xid+"&xtipo="+xtipo;
  var xrequest = new XMLHttpRequest();
  xrequest.open("GET",url,false);
  xrequest.send(null);
  return xrequest.responseText;  
}

function existeNumeroFiscal(nfiscal,xid,xtipo){

  var res = obtnenerNumeroFiscal(nfiscal,xid,xtipo);

  if(res == '' || !res)
    return false;
  else
    return true;
}

function VerificarNumeroFiscalProv(){
  var nfiscal = document.getElementById("NumeroFiscal").value;
  var xprov = (document.getElementById("IdProveedor"))? document.getElementById("IdProveedor").value:false;
  var xval = "";

  if(nfiscal != '' && nfiscal.length != 11)
    xval = 'RUC debe tener 11 dígitos';
  
  if(existeNumeroFiscal(nfiscal,false,'Proveedor'))
    xval = 'RUC: '+nfiscal+", ya está registrado";
  

  if(xval != ''){
    var oldfiscal = obtnenerNumeroFiscal(nfiscal,xprov,'Proveedor');
    document.getElementById("NumeroFiscal").value = (xprov)? oldfiscal:'';
    alert(xval);
    document.getElementById("NumeroFiscal").focus();
    return;
  }
}

function VerificarNumeroFiscalSubs(){
  var nfiscal = document.getElementById("NumeroFiscal").value;
  var xsubs = (document.getElementById("IdSubsidiario"))? document.getElementById("IdSubsidiario").value:false;
  var xval = "";

  if(nfiscal != '' && nfiscal.length != 11)
    xval = 'RUC debe tener 11 dígitos';
  
  if(existeNumeroFiscal(nfiscal,false,'Subsidiario'))
    xval = 'RUC: '+nfiscal+", ya está registrado";
  

  if(xval != ''){
    var oldfiscal = obtnenerNumeroFiscal(nfiscal,xsubs,'Subsidiario');
    document.getElementById("NumeroFiscal").value = (xsubs)? oldfiscal:'';
    alert(xval);
    document.getElementById("NumeroFiscal").focus();
    return;
  }
}
