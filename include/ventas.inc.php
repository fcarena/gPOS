<?php

function DetallesVenta($IdComprobante,$IdLocal){	
  $sql = 
    "SELECT ges_comprobantesdet.Referencia,".
    "       ges_productos_idioma.Descripcion as Nombre,".
    "       ges_detalles.Talla as Talla, ".
    "       ges_modelos.Color as Color, " .
    "       ges_comprobantesdet.Cantidad as Cantidad,".
    "       ges_comprobantesdet.Precio as Precio,".
    "       ges_comprobantesdet.Descuento as Descuento,".
    "       ges_comprobantesdet.Importe as Importe,".
    "       ges_productos.IdProducto,".
    "       ges_comprobantesdet.CodigoBarras,".
    "       ges_laboratorios.NombreComercial as Lab, ".
    "       ges_marcas.Marca as Marca, ".
    "       ges_comprobantesdet.Serie, ".
    "       ges_comprobantesdet.Lote, ".
    "       ges_comprobantesdet.Vencimiento, ".
    "       ges_productos.Servicio, ".
    "       ges_productos.MetaProducto, ".
    "       ges_productos.VentaMenudeo as Menudeo, ".
    "       ges_contenedores.Contenedor, ".
    "       ges_productos.UnidadesPorContenedor, ".
    "       ges_productos.UnidadMedida, ".
    "       ges_comprobantesdet.IdComprobanteDet, ".
    "       ges_comprobantesdet.IdPedidoDet, ".
    "       ges_comprobantesdet.CostoUnitario as Costo, ".
    "       IF(ges_comprobantesdet.Concepto = '',' ',ges_comprobantesdet.Concepto) as Concepto, ".
    "       ges_comprobantesdet.IdAlbaran, ".
    "       ges_comprobantesdet.IdOrdenServicio, ".
    "       ges_comprobantesdet.CantidadDevolucion ".
    "FROM   ges_comprobantesdet ".
    "INNER JOIN ges_productos ON ges_comprobantesdet.IdProducto = ges_productos.IdProducto ".
    "INNER JOIN ges_productos_idioma ON ges_productos.IdProdBase= ges_productos_idioma.IdProdBase ".
    "INNER JOIN ges_detalles ON ges_productos.IdTalla = ges_detalles.IdTalla ".
    "INNER JOIN ges_modelos ON ges_productos.IdColor = ges_modelos.IdColor ".
    "INNER JOIN ges_laboratorios ON ges_productos.IdLabHab = ges_laboratorios.IdLaboratorio ".
    "INNER JOIN ges_marcas ON  ges_productos.IdMarca = ges_marcas.IdMarca ".
    "INNER JOIN ges_contenedores     ON ".
    "       ges_productos.IdContenedor = ges_contenedores.IdContenedor ".
    "WHERE  ges_comprobantesdet.IdComprobante = '$IdComprobante' ".
    "AND    ges_productos_idioma.IdIdioma = 1 ".
    "AND    ges_detalles.IdIdioma = 1 ".
    "AND    ges_modelos.IdIdioma = 1 ".
    "AND    ges_comprobantesdet.Eliminado = 0 ".
    "ORDER BY    ges_comprobantesdet.IdComprobanteDet ASC ";
	
	$res = query($sql);
	if (!$res) return false;
	$ventas = array();
	$t = 0;
	while($row = Row($res))
	  {
	    $nombre = "detalles_" . $t++;
	    
	    //SERVICIOS: remplaza texto 
	    if($row["Concepto"]!= ' ')
	      { $row["Nombre"] = $row ["Concepto"];
		$row["Marca"] = ' ';
		$row["Talla"] = ' ';
		$row["Color"] = ' ';
		$row["Lab"]   = ' ';
	      }
	    
	    //INFO: se reintegra el descuento para que el ticket tenga sentido
	    //$row["Importe"]     = ($row["Descuento"]>0)? $row["Importe"]*( 100 - $row["Descuento"])/100:$row["Importe"];	    
	    $DocumentoSalida    = ($row["IdAlbaran"])? $row["IdAlbaran"]:$IdComprobante;
	    $row["Serie"]       = ($row["Serie"])? getSeries2IdProductoVentas($DocumentoSalida,$row["IdProducto"],$row["IdPedidoDet"]):'false';
	    $row["Lote"]        = ($row["Lote"])? getLoteFromIdProductoVenta($row["IdPedidoDet"],$row["IdProducto"]): 'false';
	    $row["Vencimiento"] = ($row["Vencimiento"])? getVencimientoFromIdProductoVenta($row["IdPedidoDet"],$row["IdProducto"]):'false';
	    $ventas[$nombre] = $row; 		
	  }		
	return $ventas;
}

function DetallesServicios($idsubsidiario,$status,$ticket,$desde,$hasta){
	
	$idsubsidiario	= CleanID($idsubsidiario);
	$status 	= CleanRealMysql( $status );
	$ticket		= CleanRealMysql($ticket);
	$desde 	        = CleanRealMysql( $desde );
	$hasta		= CleanRealMysql($hasta);
	
	$extraSubsidiario	= ($idsubsidiario)?" AND ges_subsidiariostbjos.IdSubsidiario = '$idsubsidiario' ":"";
	$extraStatus 	= ($status)?" AND ges_subsidiariostbjos.Status = '$status' ":"";
	$extraTicket 	= ($ticket)?" AND ges_subsidiariostbjos.NTicket LIKE '%$ticket%' ":"";
	$extrafecha     = " AND DATE(ges_subsidiariostbjos.FechaRegistro) >= '$desde' ".
	                  " AND DATE(ges_subsidiariostbjos.FechaRegistro) <= '$hasta' ";

	$extraTicket = ($ticket)? $extraTicket:$extraSubsidiario.$extraStatus.$extrafecha;
	
	$sql = 
	  "SELECT ges_subsidiarios.NombreComercial AS NombreSubsidiario,".
	  "       CONCAT(ges_productos_idioma.Descripcion,' ',".
	  "       ges_marcas.Marca,' ',".
	  "       ges_modelos.Color,' ',".
	  "       ges_detalles.Talla,' ',".
	  "       ges_laboratorios.NombreComercial) as DescripcionProducto,".
 	  "	  ges_subsidiariosserv.Servicio As Servicios, ges_subsidiariostbjos.NTicket, ".
	  " 	  ges_subsidiariostbjos.Status, ".
	  "       IF(ges_subsidiariostbjos.FechaEnvio = '0000-00-00 00:00:00',' ',CONCAT(DATE_FORMAT(FechaEnvio,'%d/%m/%Y %H:%i'),'~',FechaEnvio)) AS FechaEnvio, ".
	  "       IF(ges_subsidiariostbjos.FechaRecepcion = '0000-00-00 00:00:00',' ',CONCAT(DATE_FORMAT(FechaRecepcion,'%d/%m/%Y %H:%i'),'~',FechaRecepcion)) AS FechaRecepcion, ".
	  "       ges_subsidiariostbjos.IdTbjoSubsidiario, ".
	  "       DATE_FORMAT(ges_subsidiariostbjos.FechaRegistro,'%d/%m/%Y %H:%i') AS FechaRegistro, ".
	  "       IF(ges_subsidiariostbjos.FechaEntrega = '0000-00-00 00:00:00',' ',CONCAT(DATE_FORMAT(FechaEntrega,'%d/%m/%Y %H:%i'),'~',FechaEntrega)) AS FechaEntrega, ".
	  "       ges_subsidiariostbjos.Coste, ".
	  "       ges_subsidiariostbjos.CostePendiente, ".
	  "       IF ( ges_subsidiariostbjos.Observaciones like '', ' ',ges_subsidiariostbjos.Observaciones) as Observaciones, ".
	  "       ges_subsidiariostbjos.DocSubsidiario, ".
	  "       ges_subsidiariostbjos.NDocSubsidiario ".
	  "FROM   ges_subsidiariostbjos ".
	  "INNER  JOIN ges_subsidiarios ON ".
	  "       ges_subsidiariostbjos.IdSubsidiario = ges_subsidiarios.IdSubsidiario ".
	  "INNER  JOIN ges_subsidiariosserv ON ".
	  "       ges_subsidiariosserv.IdServicio = ges_subsidiariostbjos.IdServicio ".
	  "INNER  JOIN ges_productos ON ".
	  "       ges_subsidiariostbjos.IdProducto = ges_productos.IdProducto ".
	  "INNER  JOIN ges_productos_idioma ON ".
	  "       ges_productos.IdProdBase =ges_productos_idioma.IdProdBase ".
	  "INNER  JOIN ges_detalles ON ".
	  "       ges_productos.IdTalla = ges_detalles.IdTalla ".
	  "INNER  JOIN ges_modelos ON ".
	  "       ges_productos.IdColor = ges_modelos.IdColor ".
	  "INNER  JOIN ges_laboratorios ON ".
	  "       ges_productos.IdLabHab = ges_laboratorios.IdLaboratorio ".
	  "INNER  JOIN ges_marcas ON ".
	  "       ges_productos.IdMarca = ges_marcas.IdMarca ".
	  "WHERE  ges_subsidiariostbjos.Eliminado = 0 ".
	  "$extraTicket".
	  "ORDER BY IdTbjoSubsidiario DESC ";
	
	
	$res = query($sql);
	if (!$res) return false;
	$arreglos = array();
	$t = 0;
	while($row = Row($res)){
		$nombre ="detalles_" . $t++;
		$arreglos[$nombre] = $row; 		
	}		
	return $arreglos;		
}


function VentasPeriodo($local,$desde,$hasta,$esSoloPendientes=false,$esSoloFinalizados=false,
		       $esSoloContado=false,$esSoloFactura=false,$esSoloBoleta=false,
		       $esSoloAlbaran=false,$esSoloAlbaranInt=false,$esSoloTicket=false,$nombre=false,
		       $esSoloCesion=false,$esSoloSuscripcion=false,$forzarfacturaid=false,
		       $TipoVenta,$forzarid,$forzaridsuscripcion,$usuario,
		       $esSoloReserva=false,$esSoloCaja=false,$tipoproducto=false){

        $xnombre       = CleanRealMysql($nombre);
	$cod          = ($forzarid != 'false')? explode("-",$forzarid) : "";
	$cod[0]       = (isset($cod[0]))? $cod[0]:'';
	$cod[1]       = (isset($cod[1]))? $cod[1]:'';
	$extraNombre  = ($nombre and $nombre != "")?true:false;
	$extraID      = ($forzarfacturaid>0)? " AND ges_comprobantes.IdComprobante = '$forzarfacturaid' ":"";
	$extraFechas  = ($extraID =="")? " AND DATE(ges_comprobantes.FechaComprobante) >= '$desde'".
	                                " AND DATE(ges_comprobantes.FechaComprobante) <= '$hasta' ":"";
	$extraFechas  = ($forzarid != 'false')? " AND ges_comprobantes.SerieComprobante like '%$cod[0]%' AND ges_comprobantes.NComprobante like '%$cod[1]%'" : $extraFechas;

	#Pendientes
	$extraStatus  = ( $esSoloPendientes )?" AND ges_comprobantes.Status = 1 ":"";

	#Suscripcion
	$extraSuscripcion = ($esSoloSuscripcion )? " AND ges_comprobantes.IdSuscripcion <> 0 ":"";
	$extraSuscripcion = ($forzaridsuscripcion != 0 )? " AND ges_comprobantes.IdSuscripcion = '$forzaridsuscripcion' ":$extraSuscripcion;
	$extraSuscripcion = ( $esSoloFinalizados && $esSoloSuscripcion )? $extraSuscripcion." AND ges_comprobantes.Status = 2 ":$extraSuscripcion;

	#Contado
	$extraCesion  = ( $esSoloContado )?" AND ges_comprobantes.SerieComprobante LIKE 'B%' ":"";
	$extraCesion  = ( $esSoloFinalizados && $esSoloContado )? $extraCesion." AND ges_comprobantes.Status = 2 ":$extraCesion;

	#Credito
	$extraCesion  = ( $esSoloCesion )?" AND ges_comprobantes.SerieComprobante LIKE 'CS%' AND ges_comprobantes.Reservado = 0 ":$extraCesion;
	$extraCesion  = ( $esSoloFinalizados && $esSoloCesion )? $extraCesion." AND ges_comprobantes.Status = 2 ":$extraCesion;

	#### Reverva
	$extraReserva = ( $esSoloReserva )?" AND ges_comprobantes.Reservado = 1 ":"";
	$extraReserva = ( $esSoloReserva && $esSoloPendientes )? $extraReserva." AND ges_comprobantes.FechaEntregaReserva = '0000-00-00 00:00:00.000000'":$extraReserva;//Pendiente
	$extraReserva = ( $esSoloReserva && $esSoloFinalizados )? $extraReserva." AND ges_comprobantes.FechaEntregaReserva <> '0000-00-00 00:00:00.000000'": $extraReserva;//Finalizado

	$extraStatus  = ( ( $extraReserva == '' && $extraCesion == '' && $extraCesion == '') && $esSoloFinalizados )?" AND ges_comprobantes.Status = 2 ": $extraStatus;


	$extraBoleta  = ($esSoloBoleta)?" AND ges_comprobantestipo.TipoComprobante = 'Boleta' ":"";
	$extraFactura = ($esSoloFactura)?" AND ges_comprobantestipo.TipoComprobante = 'Factura' ":"";
	$extraAlbaran = ($esSoloAlbaran)?" AND ges_comprobantestipo.TipoComprobante = 'Albaran' ":"";
	$extraAlbaranInt = ($esSoloAlbaranInt)?" AND ges_comprobantestipo.TipoComprobante = 'AlbaranInt' ":" AND ges_comprobantesnum.IdMotivoAlbaran <> 4 ";
	$extraTicket     = ($esSoloTicket)?" AND ges_comprobantestipo.TipoComprobante = 'Ticket' ":"";
	$extraTipoVenta  = ($TipoVenta)?" AND ges_comprobantes.TipoVentaOperacion = '$TipoVenta'":"";

	$extraLocal      = ($local != 0)? "AND  ges_comprobantes.IdLocal = '$local'":"";
	$extrausuario    = ($usuario != 'todos')? " AND ges_comprobantes.IdUsuario = '$usuario' ":"";
	$extraCaja       = ($esSoloCaja)?" AND ges_comprobantestipo.TipoComprobante in ('Ticket','Factura','Boleta','Albaran') ":"";

	// Filtro Tipo Producto
	$buscaProducto = ($tipoproducto == 'todos')? "":" INNER JOIN ges_comprobantesdet ON ges_comprobantes.IdComprobante = ges_comprobantesdet.IdComprobante INNER JOIN ges_productos ON ges_comprobantesdet.IdProducto = ges_productos.IdProducto ";
	$extraProducto = ($tipoproducto == 'Producto')? " AND ges_productos.Servicio = 0":"";
	$extraProducto = ($tipoproducto == 'Servicio')? " AND ges_productos.Servicio = 1":$extraProducto;
	$extraProducto = ($tipoproducto == 'todos')? "":$extraProducto;
	$extragroup    = ($tipoproducto == 'todos')? "":" GROUP BY ges_comprobantes.IdComprobante";

	$desde = CleanRealMysql($desde);
	$hasta = CleanRealMysql($hasta);

	$sql = "SELECT
                ges_usuarios.Nombre As Vendedor, 
                ges_comprobantes.SerieComprobante,
                ges_comprobantes.NComprobante,
                DATE_FORMAT(ges_comprobantesnum.Fecha,'%d/%m/%Y %H:%i') as Fecha,
                ges_comprobantes.TotalImporte,
                ges_comprobantes.ImportePendiente,
                ges_comprobantesstatus.Status, 
                ges_comprobantes.IdComprobante,
                CONCAT(ges_comprobantestipo.Serie,'-',ges_comprobantesnum.NumeroComprobante) as NumeroComprobante,
                ges_comprobantestipo.TipoComprobante as TipoDocumento,
                IF(Destinatario = 'Cliente',(SELECT CONCAT(ges_clientes.TipoCliente,' : ',ges_clientes.nombreComercial ) FROM ges_clientes WHERE ges_clientes.IdCliente = ges_comprobantes.IdCliente),(IF(Destinatario='Local',(SELECT CONCAT('Interno : ',ges_locales.nombreComercial) FROM ges_locales WHERE ges_locales.IdLocal = ges_comprobantes.IdCliente),  (SELECT CONCAT('Externo : ',ges_proveedores.NombreComercial) FROM ges_proveedores WHERE ges_proveedores.IdProveedor = ges_comprobantes.IdCliente)))) as Cliente, ges_comprobantes.IdCliente,
                ges_locales.NombreComercial as Local, ges_comprobantes.IdLocal,
                IF(ges_comprobantesnum.IdMotivoAlbaran = 0,' ',(SELECT ges_motivoalbaran.MotivoAlbaran FROM ges_motivoalbaran WHERE ges_motivoalbaran.IdMotivoAlbaran = ges_comprobantesnum.IdMotivoAlbaran)) as MotivoAlbaran,
                ges_comprobantes.IdSuscripcion,
                DATE_FORMAT(ges_comprobantes.FechaComprobante,'%d/%m/%Y %H:%i') as FechaEmision, 
                ges_comprobantes.PlazoPago, 
                ges_comprobantes.Cobranza, 
                IF(ges_comprobantes.Observaciones like '',' ',ges_comprobantes.Observaciones) as Observaciones, 
                ges_comprobantes.Reservado, 
	        IF(ges_comprobantes.FechaEntregaReserva = '0000-00-00 00:00:00',' ',CONCAT(DATE_FORMAT(ges_comprobantes.FechaEntregaReserva,'%d/%m/%Y %H:%i'),'~',ges_comprobantes.FechaEntregaReserva)) AS FechaEntregaReserva,ges_comprobantes.IdAlbaranes,ges_comprobantesnum.IdNumComprobante 
    		FROM ges_comprobantes " .
    		"LEFT JOIN ges_clientes ON ges_comprobantes.IdCliente = ges_clientes.IdCliente
                INNER JOIN ges_comprobantesstatus ON ges_comprobantes.Status = ges_comprobantesstatus.IdStatus
                INNER JOIN ges_locales ON ges_comprobantes.IdLocal = ges_locales.IdLocal
                INNER JOIN ges_usuarios ON ges_comprobantes.IdUsuario = ges_usuarios.IdUsuario
                INNER JOIN ges_comprobantesnum ON ges_comprobantesnum.IdComprobante = ges_comprobantes.IdComprobante
                INNER JOIN ges_comprobantestipo ON  ges_comprobantestipo.IdTipoComprobante = ges_comprobantesnum.IdTipoComprobante".
               " $buscaProducto ".
	       " WHERE ges_comprobantes.Eliminado = 0
                AND  ges_comprobantesnum.Eliminado = 0
                AND  ges_comprobantesnum.Status = 'Emitido'

                $extraLocal
                $extrausuario
                $extraTipoVenta
 	        $extraID
	        $extraFechas
                $extraStatus
                $extraBoleta 
                $extraFactura 
                $extraTicket
                $extraAlbaran 
                $extraAlbaranInt 
                $extraSuscripcion
                $extraCaja
                $extraReserva
                $extraCesion
                $extraProducto " .
                " $extragroup ".
	        " ORDER BY ges_comprobantes.IdComprobante DESC ";  
	$res = query($sql);
	if (!$res) return false;
	$ventas = array();
	$t = 0;
	while($row = Row($res)){

	  if($extraNombre){
	    $xclient = str_replace('ñ','Ñ',$row["Cliente"]);
	    $xnombre = str_replace('ñ','Ñ',$xnombre);
	    if(!strpos(strtoupper($xclient),strtoupper($xnombre)))
	      continue;
	  }
      $row["IdAlbaranes"] = ($row["IdAlbaranes"])? $row["IdAlbaranes"]: " ";
      $idguiarem = obtenerIdGuiaRemision($row["IdNumComprobante"]);
      $row["IdGuiaRemision"] = (!$idguiarem)? ' ':$idguiarem;
	  $nombre = "venta_" . $t++;
	  $ventas[$nombre] = $row;
	  
	  if(($row["ImportePendiente"] > 0) && ($row["Cobranza"] != 'Ninguno') && $row["PlazoPago"] != '0000-00-00')
	    checkEstadoPlazoPago($row["PlazoPago"],$row["Cobranza"],$row["IdComprobante"]);
	}

	return $ventas;
}

function  checkEstadoPlazoPago($PlazoPago,$Cobranza,$IdComprobante){
  $Hoy        = strtotime('now');
  $Fecha      = strtotime($PlazoPago);

  if(($Hoy > ($Fecha+86400)) && ($Cobranza != 'Coactivo')){
    $campoxdato = " Cobranza = 'Coactivo'";
    ActualizarEstadoPago($IdComprobante,$campoxdato);
  }
}

function  getTrabajosSubsidiario($xid){

	 $sql = 
	   "SELECT ges_subsidiarios.NombreComercial, ".
	   "       ges_subsidiarios.IdSubsidiario ".
	   "FROM   ges_subsidiariostbjos ". 
	   "LEFT   JOIN ges_subsidiarios ON 
            ges_subsidiariostbjos.IdSubsidiario = ges_subsidiarios.IdSubsidiario
            INNER  JOIN ges_subsidiariosserv ON
            ges_subsidiariosserv.IdServicio = ges_subsidiariostbjos.IdServicio 
            WHERE  ges_subsidiariostbjos.IdOrdenCompra = '".$xid."'";
	 
	 $res = query($sql);
	 if (!$res) return false;
	 return Row($res);

	}

function cajaescerrado(){
	  $TipoVenta = getSesionDato("TipoVentaTPV");
	  $IdLocalActivo = getSesionDato("IdTienda");
	  $sql=
	    "SELECT esCerrada ".
	    "FROM   ges_arqueo_caja ".
	    "WHERE  IdLocal            = '$IdLocalActivo' ".
	    "AND    TipoVentaOperacion = '$TipoVenta'".
	    "ORDER  BY IdArqueo DESC Limit 1 ";
	  $row = queryrow($sql);
	  if ($row){
	    $esCerrada =  intval($row["esCerrada"]); 
	  }	else {
	    $esCerrada = -1;
	  }    
	  return $esCerrada;
	}

function OperarPagoSobreTicket($IdComprobante,$pago_efectivo, $pago_bono, $pago_tarjeta,
			       $concepto,$fechapago=false,$modalidadpago=1,$doccobro=false,
			       $IdUsuario){

        $TipoVenta = getSesionDato("TipoVentaTPV");
	$pago = $pago_efectivo + $pago_bono + $pago_tarjeta;

	$sql = "SELECT IdCliente, ImportePendiente FROM ges_comprobantes ".
	       "WHERE IdComprobante='$IdComprobante' AND  TipoVentaOperacion = '$TipoVenta'";
	$row = queryrow($sql);

        $pendiente = $row["ImportePendiente"];
	$idcliente = $row["IdCliente"];
	$resto     = $pendiente - $pago;

	if( $pendiente == 0 ) return "";

	/* Movimientos de dinero */
	$IdLocal =  getSesionDato("IdTienda");
	$IdUsuario = (!$IdUsuario)? getSesionDato("IdUsuario"):$IdUsuario;

	EntregarCantidades("Abonando pendiente ".$concepto, $IdLocal,$pago_efectivo, 
			   $pago_bono, $pago_tarjeta,$IdComprobante,"Ingreso",
			   $fechapago,$modalidadpago,$doccobro,$IdUsuario);
	
	
	/* Estudiamos el estado final */
		
	if($resto<0.01){
		$newstatus = FAC_PAGADA;
		$newpendiente = 0;
	}	else {
		$newstatus = FAC_PENDIENTE_PAGO;
		$newpendiente = $resto;
	}
	
	/* Actualizamos estado y cantidades pendientes */	
	$sql = "UPDATE  ges_comprobantes SET Status='$newstatus', 
                        ImportePendiente = '$newpendiente'
                WHERE IdComprobante = '$IdComprobante' 
                AND  TipoVentaOperacion = '$TipoVenta'";	
	query($sql,"Abonando un ticket");

	if( $idcliente > 1 )
	  actualizarImportePendienteCliente($row["IdCliente"]);

	//Abono con Nota de Credito o Bono...
	$pago_bono    = ($modalidadpago == 10)? $pago_efectivo:$pago_bono;
	$pago_credito = ($modalidadpago == 9)?  $pago_efectivo :0;

	if($pago_bono > 0)
	  registrarMovimientoBonoCliente($idcliente,"-".$pago_bono,1,$IdLocal,
					 $IdComprobante,$IdUsuario);
	if($pago_credito > 0)
	  registrarMovimientoCreditoCliente($idcliente,"-".$pago_credito,1,$IdLocal,
                                        $IdComprobante,$IdUsuario,$concepto,false);


	return $newpendiente;		
}

function obtnerPendienteComprobante($IdComprobante){
       $sql = "SELECT ImportePendiente FROM ges_comprobantes ".
	 "WHERE  IdComprobante      = '$IdComprobante' ";
       $row = queryrow($sql);
       return $row["ImportePendiente"];
}

function actualizarPendienteComprobante($IdComprobante,$Importe,$IdCliente){
  //$resto = $Pendiente - $Pago;
	
	if($Importe<0.01){
		$newstatus = FAC_PAGADA;
		$newpendiente = 0;
	}	else {
		$newstatus = FAC_PENDIENTE_PAGO;
		$newpendiente = $Importe;
	}

	$sql = "UPDATE ges_comprobantes ".
	       "SET    Status='$newstatus', ".
	       "       ImportePendiente   = '$newpendiente' ".
	       "WHERE  IdComprobante      = '$IdComprobante' ";
	query($sql,"Abonando un ticket");

	if( $IdCliente > 1 )
	  actualizarImportePendienteCliente($IdCliente);

	return $newpendiente;  
}

function DetallesCobro($IdComprobante){
  $TipoVenta    = getSesionDato("TipoVentaTPV");
  $TipoVenta    = ($TipoVenta == 'VD')? 'Caja: B2C':'Caja: B2B';
  $sql = "SELECT ModalidadPago, ".
         "DATE_FORMAT(ges_dinero_movimientos.FechaPago, '%e %b %y  %H:%i') AS Fecha, ".
         "Importe, ".
         "ges_usuarios.Nombre As Usuario, ".
         "IdOperacionCaja, ".
         "ges_locales.NombreComercial as Local, ".
         "ges_modalidadespago.IdModalidadPago, ".
         "ges_dinero_movimientos.TipoVentaOperacion ".
         "FROM ges_dinero_movimientos ".
         "INNER JOIN ges_usuarios ON ges_dinero_movimientos.IdUsuario = ges_usuarios.IdUsuario ".
         "INNER JOIN ges_modalidadespago ON ges_dinero_movimientos.IdModalidadPago = ges_modalidadespago.IdModalidadPago ".
         "INNER JOIN ges_locales ON ges_dinero_movimientos.IdLocal = ges_locales.IdLocal ".
         "WHERE ges_dinero_movimientos.Eliminado = 0 ".
         "AND IdComprobante = '$IdComprobante' ".
         "ORDER BY IdOperacionCaja ASC ";

  $res = query($sql);
  if (!$res) return false;
  $PagoDocumento = array();
  $t = 0;
  while($row = Row($res)){
    $nombre = "DetPago_" . $t++;
    $tvo    = ($row["TipoVentaOperacion"] == 'VD')? 'Caja: B2C':'Caja: B2B';
    $row["LocalPago"] = $tvo;
    $PagoDocumento[$nombre] = $row;
  }

  $sql = "SELECT 'EFECTICO' AS ModalidadPago, ".
         "DATE_FORMAT(ges_librodiario_cajagral.FechaInsercion, '%e %b %y  %H:%i') AS Fecha, ".
         "Importe, ".
         "ges_usuarios.Nombre As Usuario, ".
         "IdOperacionCaja, ".
         "ges_locales.NombreComercial as Local, ".
         "'1' AS IdModalidadPago, ".
         "'CG' AS TipoVentaOperacion ".
         "FROM ges_librodiario_cajagral ".
         "INNER JOIN ges_usuarios ON ges_librodiario_cajagral.IdUsuario = ges_usuarios.IdUsuario ".
         "INNER JOIN ges_locales ON ges_librodiario_cajagral.IdLocal = ges_locales.IdLocal ".
         "WHERE ges_librodiario_cajagral.Eliminado = 0 ".
         "AND IdComprobante = '$IdComprobante' ".
         "ORDER BY IdOperacionCaja ASC ";

  $res = query($sql);
  if (!$res) return false;
  //echo $t;
  while($row = Row($res)){
    $nombre = "DetPago_" . $t++;
    $row["ModalidadPago"] = 'EFECTIVO';
    $row["LocalPago"] = 'Caja: GRAL';
    $PagoDocumento[$nombre] = $row;
    //echo $t;
  }
  
  return $PagoDocumento;
}

function ModificarSubsidiarioTbjo($xid,$campoxdato){
  $Tb         = 'ges_subsidiariostbjos';
  $IdKey      = 'IdTbjoSubsidiario';
  $Id         = CleanID($xid);
  $KeysValue  = $campoxdato;
  $sql   =
    " update ".$Tb.
    " set    ".$KeysValue." ".
    " where  ".$IdKey." = ".$Id;	
  return query($sql); 
}

function obtenerCostePendiente($xid){
  $sql = "SELECT CostePendiente FROM ges_subsidiariostbjos ".
         "WHERE  IdTbjoSubsidiario      = '$xid' ";
  $row = queryrow($sql);
  return $row["CostePendiente"];
}

function ModificarFechaEmicionComprobante($Fecha,$TipoComprobante,$IdComprobante,$accion){

  $validacaja     = ValidarFechaAperturaCaja($Fecha);
  if($validacaja != 1){
    echo $validacaja;
    return;
  }

  ModificarFechaDineroMovimiento($IdComprobante,$Fecha);

  $sql   =
    " update ges_comprobantes ".
    " set    FechaComprobante = '$Fecha'".
    " where  IdComprobante = '$IdComprobante'";	
  echo "~".query($sql);

}

function ActualizarEstadoPago($xid,$campoxdato){
  $Tb         = 'ges_comprobantes';
  $IdKey      = 'IdComprobante';
  $Id         = CleanID($xid);
  $KeysValue  = $campoxdato;
  $sql   =
    " update ".$Tb.
    " set    ".$KeysValue." ".
    " where  ".$IdKey." = ".$Id;	
  return query($sql); 
}

function  ActualizaPagoAdelantadoPresupuesto($idPresupuesto,$idComprobante,$textCaja){

  $sql = 
    " select ImporteAdelanto, TipoVentaOperacion,IdLocal,NPresupuesto ".
    " from   ges_presupuestos".
    " where  IdPresupuesto   = '".$idPresupuesto."'";
  $row       = queryrow($sql);
  $Monto     = $row["ImporteAdelanto"];

  if(!($Monto > 0)) return;

  $TipoVenta = $row["TipoVentaOperacion"];
  $IdLocal   = $row["IdLocal"];
  $arqueo    = new movimiento;
  $IdArqueo  = $arqueo->GetArqueoActivo($IdLocal);
  $FechaCaja = $arqueo->getAperturaCaja($IdLocal,$TipoVenta);
  $IdPartida = ($TipoVenta == 'VD')? 22:23;
  $concepto  = "Metalico: Adelanto Proforma Nro. ".$row["NPresupuesto"]." - ".$textCaja;

  //Sustraccion Caja.
  EntregarOperacionCaja($IdLocal,$Monto,$concepto,$IdPartida,'Sustraccion',
			$FechaCaja,$IdArqueo,$TipoVenta);
  //Abono Metalico Ticket
  $xpendiente = OperarPagoSobreTicket($idComprobante,$Monto, 0, 0,$textCaja,false,1,false,false);
}

function ActualizarReservaEntregado($IdComprobante,$fecha){
  
  $sql   =
    " update ges_comprobantes ".
    " set    FechaEntregaReserva = '$fecha' ".
    " where  IdComprobante = '$IdComprobante' ".
    " AND    FechaEntregaReserva = '0000-00-00 00:00:00'";
  return query($sql);  
}

function realizarAbonoBrutalCliente( $IdCliente,$xmonto ){

 $sql = " select ges_comprobantes.IdComprobante,ges_comprobantes.ImportePendiente,
           concat( ges_comprobantestipo.TipoComprobante,' ',ges_comprobantestipo.Serie,' - ',ges_comprobantesnum.NumeroComprobante) as Documento
	              from   ges_comprobantes 
	              inner  join ges_comprobantesnum  
	              on     ges_comprobantes.IdComprobante = ges_comprobantesnum.IdComprobante      
	              inner  join ges_comprobantestipo 
	              on     ges_comprobantesnum.IdTipoComprobante = ges_comprobantestipo.IdTipoComprobante 
	              where  ges_comprobantes.ImportePendiente > 0 
	              and    ges_comprobantes.Status IN(1,3) 
	              and    ges_comprobantes.Destinatario = 'Cliente' 
	              and    ges_comprobantes.IdCliente = ".$IdCliente." 
	              and    ges_comprobantestipo.TipoComprobante in ('Ticket','Factura','Boleta','Albaran') 
	              and    ges_comprobantesnum.Status in ('Emitido','Facturado') 
                      order  by ges_comprobantes.FechaComprobante asc";
  $res = query($sql);
  
  while( $row = Row( $res ) )
    {
      if( $xmonto <= 0 ) continue;

      $xpendiente    = $row["ImportePendiente"];
      $xmontoAbonar = ( $xmonto >= $xpendiente )? $xpendiente:$xmonto;
      $xmonto       = ( $xmonto >= $xpendiente )? $xmonto - $xpendiente: 0;

      OperarPagoSobreTicket($row["IdComprobante"],$xmontoAbonar, 0, 0,$row["Documento"],
      			    false,1,false,false);  
    }

  //if( $IdCliente > 1 )
  // actualizarImportePendienteCliente($IdCliente);
}

function ModificarCobros($Opcion,$IdComprobante,$IdOperacionCaja,$IdCliente,$IdModalidadPago,$ImporteCobro,$IdLocal,$TipoVenta){
  $IdUsuario = getSesionDato("IdUsuario");

  switch($Opcion){
    case '1': //Eliminar Movimiento de caja
      $Pendiente    = obtnerPendienteComprobante($IdComprobante);
      $Importe      = obtenerImporteComprobante($IdComprobante);
      $newimporte   = $Pendiente + $ImporteCobro;
      $newimporte   = ($newimporte > $Importe)? $Importe:$newimporte;
      $ImporteCobro = ($Pendiente >= $Importe)? 0:$ImporteCobro;

      if($Pendiente < $Importe)
	actualizarPendienteComprobante($IdComprobante,$newimporte,$IdCliente);
      
      if($IdModalidadPago == 10 && $ImporteCobro > 0)
	registrarMovimientoBonoCliente($IdCliente,$ImporteCobro,0,$IdLocal,$IdComprobante,
				       $IdUsuario);

      //EliminarMovimientoBancario($IdOperacionCaja,$IdLocal);

      $IdCuenta = obtenerCtaMovimientoBancario($IdOperacionCaja,$IdLocal);

      if($IdCuenta){
	$concepto = "Movimiento cancelado por error de operación";
	$IdOperacionCaja = ($TipoVenta == 'CG')? 0:$IdOperacionCaja;
	$IdOperacionCajaGral = ($TipoVenta == 'CG')? $IdOperacionCaja:0;
	
	RegistrarMovimientoBancario($IdLocal,$IdOperacionCaja,$IdOperacionCajaGral,
				    $IdUsuario,$IdCuenta,'Salida',$concepto,
				    $ImporteCobro);
      }

      EliminarDocCObrosClientes($IdOperacionCaja,$IdLocal);

      $dato = ($TipoVenta == 'CG')? EliminarMovimientoCajaGral($IdOperacionCaja):EliminarMovimientoCaja($IdOperacionCaja);
      return $dato;
      break;
  }
}

function EliminarMovimientoCaja($IdOperacionCaja){
  $sql = "UPDATE ges_dinero_movimientos SET Eliminado = 1 ".
         "WHERE IdOperacionCaja = '$IdOperacionCaja' ";
  return query($sql);
}

function EliminarMovimientoCajaGral($IdOperacionCaja){
  $sql = "UPDATE ges_librodiario_cajagral SET Eliminado = 1 ".
         "WHERE IdOperacionCaja = '$IdOperacionCaja' ";
  return query($sql);
}

function ModificarFechaPagoComprobante($IdComprobante,$fecha){
  
  $sql   =
    " update ges_comprobantes ".
    " set    PlazoPago = '$fecha' ".
    " where  IdComprobante = '$IdComprobante' ";

  echo query($sql);  
}

function verificarPendienteComprobante($IdComprobante){
  $sql   =
    " SELECT ges_comprobantes.ImportePendiente  ".
    " FROM   ges_comprobantes ".
    " where  IdComprobante = '$IdComprobante' ";
  $row = queryrow($sql);
  return $row["ImportePendiente"];
}

function ModificarEstadoReservaComprobante($IdComprobante,$reserva){
  $sql   =
    " update ges_comprobantes ".
    " set    Reservado = '$reserva' ".
    " where  IdComprobante = '$IdComprobante' ";

  echo query($sql);    
}

function obtenerImporteComprobante($idc){
  $sql = "SELECT TotalImporte as Importe ".
         "FROM ges_comprobantes ".
         "WHERE ges_comprobantes.IdComprobante IN ($idc) ";

  $row = queryrow($sql);
  return $row["Importe"];
}

function EliminarMovimientoBancario($IdOperacionCaja,$IdLocal){
  $sql   =
    " update ges_movimiento_bancario ".
    " set    Eliminado = 1 ".
    " where  IdOperacionCaja = '$IdOperacionCaja' ".
    " and    IdLocal = $IdLocal ";
  
  query($sql);      
}

function EliminarDocCObrosClientes($IdOperacionCaja,$IdLocal){
  $sql   =
    " update ges_cobrosclientedoc ".
    " set    Eliminado = 1 ".
    " where  IdOperacionCaja = '$IdOperacionCaja' ".
    " and    IdLocal = $IdLocal ";
  
  query($sql);        
}

function obtenerCtaMovimientoBancario($IdOperacionCaja,$IdLocal){
  $sql   =
    " SELECT ges_movimiento_bancario.IdCuentaBancaria  ".
    " FROM   ges_movimiento_bancario ".
    " where  IdOperacionCaja = '$IdOperacionCaja' ".
    " or     IdOperacionCajaGral = '$IdOperacionCaja' ".
    " and    IdLocal = $IdLocal ";
  $row = queryrow($sql);
  return $row["IdCuentaBancaria"];  
}

function obtenerIdGuiaRemision($IdNumComprobante){
    $sql = "SELECT IdGuiaRemision ".
           "FROM ges_guiaremision ".
           "WHERE IdComprobanteNum = $IdNumComprobante ".
           "AND Eliminado = 0 ";
    $row = queryrow($sql);

    if($row["IdGuiaRemision"] == '' || !$row )
        return false;
    else
        return $row["IdGuiaRemision"];
}
?>
