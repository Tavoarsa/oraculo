$(document).ready(function(){

  

 $('#hacienda').click(function(){

  var sessionKey;
  var userName;

  login_api();
 // Upload_certif();
   
  
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
                         Upload_certif(sessionKey,userName);
                          console.log(sessionKey);
                          console.log(userName);
                      });
                  }
     })
    }
    else
    {
     alert(" Debe llenar los campos");
    }

    
}

 function Upload_certif(){

  var file = $('#csv')[0].files[0];
  var fileReader = new FileReader();
  /*fileReader.onloadend = function (e) {
    var arrayBuffer = e.target.result;
    var fileType = ".p12";
    blobUtil.arrayBufferToBlob(arrayBuffer, fileType).then(function (blob) {
      console.log('here is a blob', blob);
      console.log('its size is', blob.size);
      console.log('its type is', blob.type);
    }).catch(console.log.bind(console));
  };
  fileReader.readAsArrayBuffer(file);*/
   
   


    /*var parametros_upload_certif = {
                  "w" : "fileUploader",
                  "r" : "subir_certif",
                  "sessionKey": sessionKey,
                  "fileToUpload" :blob,                  
                  "iam" : userName
                  
          };
    if(parametros_upload_certif != '')
    {
    //alert(typeSituation);
     $.ajax({
      url:"http://mh.bovinapp.net/www/api.php",
      method:"POST",
      data:parametros_upload_certif,
      dataType:"JSON",
      beforeSend: function () {
                          $("#resultado").html("Procesando, espere por favor...");
                  },
                  success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                         console.log(response);
                        Object.entries(response).forEach(([key, value]) => {
                        // console.log(key + ' ' + value); // "a 5", "b 7", "c 9"     
                          idFile = value.idFile;
                          name = value.name;
                          downloadCode = value.downloadCode;
                         
                          console.log(downloadCode);
                          console.log(name);
                           });
                  }
     })
    }
    else
    {
     alert(" Debe llenar los campos");
    }*/


  


}
var Name_client =  "Emanuel Essquivel Canles"  //$('#Name').val(); // nombre del cliente
  var cedula_client =  "207340707"//$('#cedula_client').val();
  var typeDocument = $( "#myselect_TD option:selected" ).val(); // tipo de documento
  var typeSituation = $( "#myselect_Situation option:selected" ).val(); // situacion 
  var clave = 0; // clave para el xml
  var consecutivo = 0; // consecutivo para xml  
  var fecha= new Date()  // fecha de emision
  var horas= fecha.getHours() // hora de emision
  var minutos = fecha.getMinutes() // minutos de emision
  var segundos = fecha.getSeconds() // segundos de emision
  var dia = fecha.getDate() // dia de emision 
  var mes = fecha.getMonth() // mes de emision
  var ano = fecha.getFullYear() // año de emision
  var xml_FE= "";
  var tokenHacienda = "";
  var refresh_token = "";
  var token_Nuevo = "";
  var userName = "";
  var sessionKey = "";
  var arrayBuffer;
  var file;
  Generar_Clave();
  getTokenHacienda();
  login();
  var blob;
  Generar_Clave()
  //Parametros para gerenerar la clave y consecutivo
  function Generar_Clave() {
  
 var parametros_Clave = {
                "w" : "clave",
                "r" : "clave",
                "tipoCedula": "fisico",
                "cedula" : "206120231",
                "situacion": typeSituation,
                "codigoPais": "506",
                "consecutivo": "1522773402",
                "codigoSeguridad": "07756342",
                "tipoDocumento": typeDocument
        };

  if(parametros_Clave != '')
  {

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
                        //console.log(clave);
                      //  console.log(consecutivo);
                         });
                }
   })
  }
  else
  {
   alert(" Debe llenar los campos");
  }
}

function genXML(clave , consecutivo ) {

var parametros_genXML = {
                "w": "genXML",
                "r": "gen_xml_fe",
                "clave": clave,
                "consecutivo": consecutivo,
                "fechaemision": ano+'-0'+mes+'-0'+dia+'T'+horas+':'+minutos+':'+segundos+'-'+"06:00",
                "emisor_nombre": "Alfredo Esquivel Rodriguez",
                "emisor_tipo_indetif": "01",
                "emisor_num_identif": "203210663",
                "nombre_comercial": "Alfredo Esquvel Rodriguez",
                "emisor_provincia": "06",
                "emisor_canton": "02",
                "emisor_distrito":"03",
                "emisor_barrio": "01",
                "emisor_otras_senas": "Frente la escuela DN",
                "emisor_cod_pais_tel": "506",
                "emisor_tel": "24603609",
                "emisor_cod_pais_fax": "506",
                "emisor_fax": "00000000",
                "emisor_email": "emanuel.esquivel94@gmail.com",
                "receptor_nombre": Name_client,
                "receptor_tipo_identif": "01",
                "receptor_num_identif":cedula_client,
                "receptor_provincia": "06",
                "receptor_canton": "02",
                "receptor_distrito":"03",
                "receptor_barrio" : "01",
                "receptor_cod_pais_tel": "506",
                "receptor_tel": "85540276",
                "receptor_cod_pais_fax": "506",
                "receptor_fax":"00000000",
                "receptor_email": "en_manuel14@hotmail.com",
                "condicion_venta":"01",
                "plazo_credito":"0",
                "medio_pago":"01",
                "cod_moneda":"CRC",
                "tipo_cambio":"564.48",
                "total_serv_gravados":"0",
                "total_serv_exentos": "20000",
                "total_merc_gravada": "0",
                "total_merc_exenta": "0",
                "total_gravados": "0",
                "total_exentos": "20000",
                "total_ventas": "20000",
                "total_descuentos": "0",
                "total_ventas_neta": "20000",
                "total_impuestos": "0",
                "total_comprobante": "20000",
                "otros": "muchas gracias",
                "detalles": {
  "1": {
    "cantidad": "1",
    "unidadMedida": "sp",
    "detalle": "Impresora",
    "precioUnitario": "10000",
    "montoTotal": "1000",
    "subtotal": "9900",
    "montoTotalLinea": "12177",
    "montoDescuento": "100",
    "naturalezaDescuento": "Pronto pago",
    "impuesto": {
      "1": {
        "codigo": "01",
        "tarifa": "13",
        "monto": "1287"
      },
      "2": {
        "codigo": "02",
        "tarifa": "10",
        "monto": "990"
      }
    }
  },
  "2": {
    "cantidad": "1",
    "unidadMedida": "sp",
    "detalle": "producto",
    "precioUnitario": "10000",
    "montoTotal": "10000",
    "subtotal": "10000",
    "montoTotalLinea": "11300",
    "impuesto": {
      "1": {
        "codigo": "01",
        "tarifa": "13",
        "monto": "1300",
        "exoneracion": {
          "tipoDocumento": "01",
          "numeroDocumento": "100",
          "nombreInstitucion": "Ministerio de Hacienda",
          "fechaEmision": "2016-09-26T13:00:00+06:00",
          "montoImpuesto": "130",
          "porcentajeCompra": "10"
        }
      }
    }
  }
}
};

  if(parametros_genXML == '')
  {
    //console.log(parametros_genXML);
   $.ajax({
    url:"http://mh.bovinapp.net/www/api.php",
    method:"POST",
    data: parametros_genXML,
    dataType:"JSON",
    beforeSend: function () {
                        $("#resultado").html("Procesando, espere por favor...");
                },
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                      console.log(response);
                       Object.entries(response).forEach(([key, value]) => {    
                        //xml_FE = value.xml;
                      
                       
                        
                        console.log(consecutivo);
                         });
                      
                }
   });
  }
  else
  {
   alert("Debe llenar los campos");
  }
}
function getTokenHacienda() {
 var parametros_Token = {
                "w" : "token",
                "r" : "gettoken",
                "grant_type": "password",
                "cedula" : "206120231",
                "client_id": "api-stag",
                "username": "cpf-02-0321-0663@stag.comprobanteselectronicos.go.cr",
                "password": "%.R60x_]A{[@au_F#.Sv"
                
        };

  if(parametros_Token == '')
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
                          
                        tokenHacienda = value.access_token;
                        refresh_token = value.refresh_token;
                        console.log(tokenHacienda);
                        console.log(refresh_token);
                        
                      });
                }
   })
  }
  else
  {
   alert(" Debe llenar los campos #Token Hacienda");
  }
}

function refreshTokenHacienda() {
 var parametros_Token = {
                "w" : "token",
                "r" : "refresh",
                "grant_type": "refresh_token",
                "cedula" : "206120231",
                "client_id": "api-stag",
                "refresh_token": refresh_token
   };

  if(parametros_Token == '')
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
                          
                        token_Nuevo = value.access_token;
                       
                      });
                }
   })
  }
  else
  {
   alert(" Debe llenar los campos #Token Hacienda");
  }
}
function login() {
   var parametros_login = {
     "w" : "users",
     "r" : "users_log_me_in",
     "userName": "Ema94",
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
                        //console.log(response);
                      Object.entries(response).forEach(([key, value]) => {
                        sessionKey = value.sessionKey;
                        username = value.userName;
                        fileUploader(sessionKey, username);
                        //console.log(sessionKey);
                        //console.log(username); 
                      });
                }
   })
  }
  else
  {
   alert(" Debe llenar los campos #LOgin");
  }
}

function cargarP12() {
 var xhr = new XMLHttpRequest();
xhr.open('POST', '/020321066336.p12', true);
xhr.responseType = 'blob';
 var blob;
xhr.onload = function(e) {
  if (this.status == 200) {
    // get binary data as a response
     blob = this.response;
     return blob;
  }
 //var blob1= instanceOfFileReader.readAsArrayBuffer(blob);
console.log(blob);
};

 xhr.send();
}

function fileUploader(sessionKey, userName) {

 var xhr = new XMLHttpRequest(); 
  xhr.open("GET", "/020321066336.p12"); 
  xhr.responseType = "blob";

//var file = new File([byteArrays], filename, {type: application/x-pkcs12, lastModified: Date.now()});

  function analyze_data(blob)
  {
    //console.log(blob);
    var myReader = new FileReader();
     myReader.readAsArrayBuffer(blob);
    
   // myReader.readAsDataURL(blob)

    myReader.onload = function (event) {
    arrayBuffer = event.target.result;
     console.log(arrayBuffer);
     //myReader.readAsArrayBuffer(blob);
     var uint8 = new Uint8Array(arrayBuffer);
   //console.log(uint8);

       file = uint8.toLocaleString();
  // file.next();
       console.log(uint8);



   var parametros_fileUploader = {
     "w" : "fileUploader",
     "r" : "subir_certif",
     "sessionKey": sessionKey ,
     "fileToUpload": blob,
     "iam": userName
    };

    if(parametros_fileUploader != '')
    {
    console.log(parametros_fileUploader);

    //alert(typeSituation);
    $.ajax({
    url:"http://mh.bovinapp.net/www/api.php",
    method:"POST",
    data:parametros_fileUploader,
    dataType:"JSON",
    beforeSend: function () {
                   $("#resultado").html("Procesando, espere por favor...");
                },
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                        console.log(response);
                     
                }
   })
  }
  else
  {
   alert(" Debe llenar los campos #fileUploader");
  }  
  }
  };
xhr.onload = function() 
{
    analyze_data(xhr.response);
    //console.log(xhr.response);

}
xhr.send(); 
}




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
}

  



});

}); 