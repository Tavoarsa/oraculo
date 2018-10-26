$(document).ready(function(){
 $('#clave').click(function(){

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
  var fileP12;  
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
    url:"http://zapateriasisa.com/www/api.php",
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
                "clave": "50610091800020321066300100001011522773400107756342",
                "consecutivo":"00100001011522773400",
                "fecha_emision": ano+'-0'+mes+'-0'+dia+'T'+horas+':'+minutos+':'+segundos+'-'+'06:00',
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
                "detalles": {"1":["1", "Sp", "Honorarios", "100000", "100000", "100000", "100000"]}
  };

  if(parametros_genXML == '')
  {
    //console.log(parametros_genXML);
   $.ajax({
    url:"http://zapateriasisa.com/www/api.php",
    method:"POST",
    data: parametros_genXML,
    dataType:"JSON",
    beforeSend: function () {
                        $("#resultado").html("Procesando, espere por favor...");
                },
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                      //console.log(response);
                       //Object.entries(response).forEach(([key, value]) => {    
                        //xml_FE = value.xml; 
                        //console.log(consecutivo);
                         //});
                      
                }
   });
  }
  else
  {
   alert("Debe llenar los campos XML Generar");
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
    url:"http://zapateriasisa.com/www/api.php",
    method:"POST",
    data:parametros_Token,
    dataType:"JSON",
    beforeSend: function () {
                        $("#resultado").html("Procesando, espere por favor...");
                },
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                       //console.log(response);
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
    url:"http://zapateriasisa.com/www/api.php",
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
   alert(" Debe llenar los campos #Refresh Token Hacienda");
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
    
 // console.log(parametros_login);

  //alert(typeSituation);
   $.ajax({
    url:"http://zapateriasisa.com/www/api.php",
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
xhr.open('GET', '/020321066336.p12', true);
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
  xhr.open("POST", "/020321066336.p12"); 
  xhr.responseType = "blob";

//var file = new File([byteArrays], filename, {type: application/x-pkcs12, lastModified: Date.now()});

  function analyze_data(blob)
  {
    
    var myReader = new FileReader();
     myReader.readAsArrayBuffer(blob);
    
   // myReader.readAsDataURL(blob)

    myReader.onload = function (event) {
    arrayBuffer = event.target.result;

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
     "fileToUpload": uint8,
     "iam": userName
    };

    if(parametros_fileUploader == '')
    {
    console.log(parametros_fileUploader);

    //alert(typeSituation);
    $.ajax({
    url:"http://zapateriasisa.com/www/api.php",
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

});
});