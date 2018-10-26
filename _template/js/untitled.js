var parametros_genXML = {

                "w": "genXML",
                "r": "gen_xml_fe",
                "clave": clave,
                "consecutivo":consecutivo,
                "fecha_emision": "2018-06-17T12:00:00-06:00",
                "emisor_nombre": "Gustavo Araya Salas",
                "emisor_tipo_indetif": "01",
                "emisor_num_identif": "206650735",
                "nombre_comercial": "Gustavo Araya Salas",
                "emisor_provincia": "6",
                "emisor_canton":"02",
                "emisor_distrito":"03",
                "emisor_barrio": "01",
                "emisor_otras_senas": "Merces Norte",
                "emisor_cod_pais_tel": "506",
                "emisor_tel": "86415183",
                "emisor_cod_pais_fax": "506",
                "emisor_fax": "00000000",
                "emisor_email": "tavo.cr23@gmail.com",
                "receptor_nombre": "Deyli Espinoza",
                "receptor_tipo_identif": "01",
                "receptor_num_identif":"115040552",
                "receptor_provincia": "06",
                "receptor_canton": "02",
                "receptor_distrito":"03",
                "receptor_barrio" : "01",
                "receptor_cod_pais_tel": "506",
                "receptor_tel": "86415183",
                "receptor_cod_pais_fax": "506",
                "receptor_fax":"00000000",
                "receptor_email": "tavoarsa@hotmail.com",
                "condicion_venta":"0",
                "plazo_credito":"0",
                "medio_pago":"01",
                "cod_moneda":"CRC",
                "tipo_cambio":"600",
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
                "detalles" :{"2":{"cantidad":"1","unidadMedida":"Unid","detalle":"producto","precioUnitario":"10000","montoTotal":"10000","subtotal":"10000","montoTotalLinea":"11170","impuesto":{"1": {"codigo":"01","tarifa":"11.7","monto":"1170"}}}}
              };

  if(parametros_genXML!= '')
  {
    console.log('Parametros_genXML',parametros_genXML);
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
                       clave = value.clave;
                       xml = value.xml;
                      
                       
                        
                        console.log('Clave:',clave);
                        console.log('XML:', xml);

                         });
                      
                }
   });
  }
  else
  {
   alert("Debe llenar los campos");
  }