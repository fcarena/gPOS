
<popupset>
  
  <popup id="AccionesBusquedaPago" class="media">
     <menuitem id="mheadNuevoPago" label="<?php echo _("Asociar Pago")?>" oncommand="NuevoPago()" <?php gulAdmite("Pagos") ?> />
     <menuseparator />
     <menuitem id="mheadImprimir" label="<?php echo _("Imprimir") ?>" oncommand="ImprimirPagoSeleccionada()"/>
     <menuitem id="mheadObs" label="<?php echo _("Observaciones") ?>" oncommand="VerObsComprobante('comprobante')" />
  </popup>

  <popup id="AccionesDetallesPago" class="media">
     <menuitem id="mheadEditar" label="Editar" oncommand="EditarPago()" <?php gulAdmite("Pagos") ?> />
     <menuitem id="mheadEliminarPago" label="Eliminar" oncommand="ModificarPago('Eliminar')" <?php gulAdmite("Pagos") ?> />
     <menuseparator />
     <menuitem id="mheadDocumento" label="Ver Pago" oncommand="verDocumento()"/>
     <menuitem id="mheadDetObs" label="Observaciones" oncommand="VerObsComprobante('pago')"/>
  </popup>

<!-- Menu de Documentos de Pagos -->

  <popup id="AccionesBusquedaDocumento">
     <menuitem label="Nuevo" oncommand="PagoDocumento('Nuevo')"/> 
     <menuitem id="mheadPagoEditar" label="Editar" oncommand="PagoDocumento('Modificar')"/> 
     <menuitem id="mheadModificarSaldo" label="Modificar Saldo" oncommand="ModificarSaldoPago()"/>
     <menuseparator />
     <menuitem label="Ver Detalle" oncommand="ImprimirPagoDocumento()"/>
     <menuitem id="mheadEliminar" label="Eliminar" oncommand="EliminarPagoDocumento()"/>
  </popup>

<!-- Menu Ventas -->
  <popup id="AccionesBusquedaVentas">
     <menuitem id="VentaRealizadaAbonar" label="Abonar" oncommand="VentanaAbonos()"/> 
     <menuseparator />
     <menuitem id="mheadImprimir" label="<?php echo _("Imprimir") ?>" oncommand="ImprimirCobroSeleccionada()"/>
     <menuitem id="mheadImprimirSuscripcion" label="<?php echo _("Imprimir Suscripción") ?>" oncommand="ImprimirSuscripcionSeleccionada()" collapsed="true"/>
  </popup>

  <popup id="AccionesBusquedaCobros">
     <menuitem id="mheadEliminar" label="Eliminar" oncommand="ModificarCobros('1')" 
               <?php gulAdmite("Cobros") ?>/>
  </popup>
</popupset>
