$(document).ready(function(){

  

  

 $('#hacienda').click(function(){

   var access_token;
   var clave;
   var consecutivo;
   var XML;
   var xmlFirmado;
  

  login_api();
  clave_consecutivo();
  gettoken();
  genXML();
  signXML();
  sendXML();


  
  
  //save_form();

  

function login_api() {
    
   var parametros_login = {
                  "w" : "users",
                  "r" : "users_log_me_in",
                  "userName": "Tavoarsa",
                  "pwd" : "123"
                  
          };

    if(parametros_login != '')
    {

    //alert(typeSituation);
     $.ajax({
      url:"http://mh.bovinapp.net/www/api.php",
      method:"POST",
      data:parametros_login,
      dataType:"JSON",
      beforeSend: function () {
                          $("#resultado").html("Procesando, espere por favor...");
                  },
                  success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                         // console.log(response);
                        Object.entries(response).forEach(([key, value]) => {
                        // console.log(key + ' ' + value); // "a 5", "b 7", "c 9"     
                          sessionKey = value.sessionKey;
                          userName = value.userName;
                         
                         // console.log('SessionKey: ',sessionKey);
                         // console.log('Username: ',userName);
                           });
                  }
     })


    }
    else
    {
     alert(" Debe llenar los campos");
   }   
}

function gettoken() {

 
 var str = "0000000000206650735";
 var ced = str.substr(-12, 12);
console.log(ced);


 var parametros_Token = {
                "w" : "token",
                "r" : "gettoken",
                "grant_type": "password",
                "cedula" : '206650735',
                "client_id": "api-stag",
                "username": "cpf-02-0665-0735@stag.comprobanteselectronicos.go.cr",
                "password": "c@Th+&HA^Q^{p(#=(qDW"
                
        };

  if(parametros_Token  != '')
  {

  //alert(typeSituation);
   $.ajax({
    url:"http://mh.bovinapp.net/www/api.php",
    method:"POST",
    data:parametros_Token,
    dataType:"JSON",
    beforeSend: function () {
                        $("#resultado").html("Procesando, espere por favor...");
                },
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                       // console.log(response);
                      Object.entries(response).forEach(([key, value]) => {
                          
                        access_token = value.access_token;
                        refresh_token = value.refresh_token;
                        sendXML(access_token);

                      console.log('Access_token: ',access_token);
                       // console.log('Refresh_token: ',refresh_token);
                        
                      });
                }
   })
  }
  else
  {
   alert(" Debe llenar los campos #Token Hacienda");
  }
}

function clave_consecutivo() {
  
 var parametros_Clave = {
                "w" : "clave",
                "r" : "clave",
                "tipoCedula": "fisico",
                "cedula" : "206650735",
                "codigoPais": "506",          
                "consecutivo": "0000000091",
                "situacion": "normal",
                "codigoSeguridad": "000052",
                "tipoDocumento": "FE",
                "terminal": "00001",
                "sucursal": "001"
        };

  if(parametros_Clave != '')
  {
//console.log(parametros_Clave);
  //alert(typeSituation);
   $.ajax({
    url:"http://mh.bovinapp.net/www/api.php",
    method:"POST",
    data:parametros_Clave,
    dataType:"JSON",
    beforeSend: function () {
                        $("#resultado").html("Procesando, espere por favor...");
                },
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                       // console.log(response);
                      Object.entries(response).forEach(([key, value]) => {
                      // console.log(key + ' ' + value); // "a 5", "b 7", "c 9"     
                        clave = value.clave;
                        consecutivo = value.consecutivo;
                        genXML(clave,consecutivo);
                     // console.log('Clave: ',clave);
                      //console.log('Consecutivo:  ',consecutivo);
                         });
                }
   })
  }
  else
  {
   alert(" Debe llenar los campos");
  }
}


function genXML() {

  var form = new FormData();
    form.append("w", "genXML");
    form.append("r", "gen_xml_fe");
    form.append("clave", clave);
    form.append("consecutivo", consecutivo);
    form.append("fecha_emision", "2018-09-09T23 : 30 : 00-06 : 00");
    form.append("emisor_nombre", "Gustavo Araya Salas");
    form.append("emisor_tipo_indetif", "01");
    form.append("emisor_num_identif", "00206650735");
    form.append("nombre_comercial", "Gustavo Araya Salas");
    form.append("emisor_provincia", "6");
    form.append("emisor_canton", "02");
    form.append("emisor_distrito", "03");
    form.append("emisor_barrio", "01");
    form.append("emisor_otras_senas", "Merces Norte");
    form.append("emisor_cod_pais_tel", "506");
    form.append("emisor_tel", "86415183");
    form.append("emisor_cod_pais_fax", "506");
    form.append("emisor_fax", "00000000");
    form.append("emisor_email", "tavo.cr23@gmail.com");
    form.append("receptor_nombre", "Deyli Espinoza");
    form.append("receptor_tipo_identif", "01");
    form.append("receptor_num_identif", "00115040552");
    form.append("receptor_provincia", "6");
    form.append("receptor_canton", "02");
    form.append("receptor_distrito", "03");
    form.append("receptor_barrio", "01");
    form.append("receptor_cod_pais_tel", "506");
    form.append("receptor_tel", "89604187");
    form.append("receptor_cod_pais_fax", "506");
    form.append("receptor_fax", "00000000");
    form.append("receptor_email", "tavoarsa@hotmail.com");
    form.append("condicion_venta", "0");
    form.append("plazo_credito", "0");
    form.append("medio_pago", "01");
    form.append("cod_moneda", "CRC");
    form.append("tipo_cambio", "600");
    form.append("total_serv_gravados", "0");
    form.append("total_serv_exentos", "200000");
    form.append("total_merc_gravada", "0");
    form.append("total_merc_exenta", "0");
    form.append("total_gravados", "0");
    form.append("total_exentos", "200000");
    form.append("total_ventas", "200000");
    form.append("total_descuentos", "0");
    form.append("total_ventas_neta", "200000");
    form.append("total_impuestos", "0");
    form.append("total_comprobante", "200000");
    form.append("otros", "Pura vida");
    form.append("detalles", "{\"1\":{\"cantidad\":\"1\",\"unidadMedida\":\"Unid\",\"detalle\":\"producto\",\"precioUnitario\":\"10000\",\"montoTotal\":\"10000\",\"subtotal\":\"10000\",\"montoTotalLinea\":\"11170\",\"impuesto\":{\"1\": {\"codigo\":\"01\",\"tarifa\":\"11.7\",\"monto\":\"1170\"}}}}");

var settings = {
  "async": true,
  "crossDomain": true,
  "url": "http://mh.bovinapp.net/www/api.php",
  "method": "POST",
  "headers": {
    "cache-control": "no-cache",
 
  },
  "processData": false,
  "contentType": false,
  "mimeType": "multipart/form-data",
  "data": form
}

$.ajax(settings).done(function (response) {

   var Xml= response.split(":");
   var c=Xml[2];
   var clave_ser= c.split(",");
   var clave= clave_ser[0];

  // console.log('Clave_XML:', clave);


   var x=Xml[3];
   var xml_ser=x.split(",");
   var xml= xml_ser[0];
   var xy= xml.split("}");
   XML=xy[0]; 

   signXML(XML);
   //console.log('XML',XML);
  });
}

function signXML(){


    var form = new FormData();
    form.append("w", "signXML");
    form.append("r", "signFE");
    form.append("p12Url", "749f78cd9435a005232cf5c7f0d25d2a");
    form.append("inXml", XML);
    form.append("pinP12", "1243");
    form.append("tipodoc", "FE");

var settings = {
  "async": true,
  "crossDomain": true,
  "url": "http://mh.bovinapp.net/www/api.php",
  "method": "POST",
  "headers": {
    "cache-control": "no-cache",
 
  },
  "processData": false,
  "contentType": false,
  "mimeType": "multipart/form-data",
  "data": form
}

$.ajax(settings).done(function (response) {

  var resp=response.split(":");

   var r=resp[2];
   //console.log('r',r)
   var xml_ser= r.split("}");
   //console.log('xml_ser',xml_ser)

   var xmlFirmado= xml_ser[0]; 
   sendXML(xmlFirmado);

 console.log('xmlFirmado',xmlFirmado);

});
}



function sendXML(){

  console.log('Clave',access_token);

    var form = new FormData();
    form.append("w", "send");
    form.append("r", "json");
    form.append("token", access_token );
    form.append("clave", clave);
    form.append("fecha", "2018-10-26T17 : 10 : 35-06 : 00");
    form.append("emi_tipoIdentificacion", "01");
    form.append("emi_numeroIdentificacion", "206650735");
    form.append("recp_tipoIdentificacion", "01");
    form.append("recp_numeroIdentificacion", "206650735");
    form.append("comprobanteXml", XML );
    form.append("client_id", "api-stag");

   
    var settings = {
        "async": true,
        "crossDomain": true,
        "url": "http://mh.bovinapp.net/www/api.php",
        "method": "POST",
        "headers": {
          "cache-control": "no-cache",
       
        },
        "processData": false,
        "contentType": false,
        "mimeType": "multipart/form-data",
        "data": form
  }



  $.ajax(settings).done(function (response) {

    console.log('Response1',response);

  });

}







/*
function save_form(){

   var customer=$('#id_customer').val();
    var customer1 = document.createElement('input');
    customer1.type="text";
    customer1.name="typeahead";
    customer1.id="skills";
    customer1.hidden="true";
 //--------------------------------------------------------------//
    var p_value=parseFloat($('#other_value').val()); 

    var inpt = document.createElement('input');
    inpt.type="text";
    inpt.name="txtother_value1";
    inpt.id="other_value1";
    inpt.hidden="true";
 //--------------------------------------------------------------//
    var p_value1=parseFloat($('#total_gtot').val());
    var inpt1 = document.createElement('input');
    inpt1.type="text";
    inpt1.name="txtgrand_total1";
    inpt1.id="grand_total1";
    inpt1.hidden="true";
    
 //--------------------------------------------------------------//

    document.frm.appendChild(inpt);
    document.frm.appendChild(inpt1);
    document.frm.appendChild(customer1);
    document.frm.innerHTML+="<br/>";

 //--------------------------------------------------------------//
    document.frm.other_value1.value = p_value;
    document.frm.grand_total1.value = p_value1;
    document.frm.skills.value = customer;
    //--------------------------------------------------------------//
   document.forms['frm'].submit();
}*/

  



});

}); 