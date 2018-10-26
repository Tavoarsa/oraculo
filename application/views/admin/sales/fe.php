<!DOCTYPE html>
<html>
 <head>
  <title>Facturación Electronica MH Bistró 77</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>_template/js/conect_h.js" language="javascript"></script>

   <script src=""></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
  <br /><br />
  <div class="container" style="width:900px;">
   <h2 align="center">Facturación Electronica Zapaterias Isa</h2>
   <h3 align="center">Interfaz</h3><br />   
   <div class="row">
    <div class="col-md-4">
     <h3>Nombre completo de cliente</h3>
      <input type="" name="" class="Name">
        <br>
      <h3>Numero Ceduladel cliente</h3>
        <input type="" name="" class="cedula_client">
        <br>
      <h3>Situación de Contigencia </h3>
        <select id="myselect_Situation">
         <option value="normal">Normal</option>
         <option value="contingencia">Contingencia</option>
         <option value="sininternet">Sin internet</option>
        </select>
        <br>
      <h3>Tipo Documento</h3>
        <select id="myselect_TD">
         <option value="FE">Factura Electrónica</option>
         <option value="NC">Nota de Credito</option>
         <option value="ND">Nota de Debito</option>
         <option value="TE">Tiquete Electrónico</option>
         <option value="CCE">Confirmacion Comprabante Electronico</option>
         <option value="CPCE"> Confirmacion Parcial Comprbante Electronico</option>
         <option value="RCE">Rechazo Comprobante Electronico</option>
        </select>
       <label id="resultado"></label>
       <label id="resultado"></label>
    </div>
  <div class="col-md-4">
   <button type="button" name="Facturar" id="login" class="btn btn-info">Facturar</button>
  </div>
  <br>

   </div>
  </div>
 </body>
</html>


<script>



</script>