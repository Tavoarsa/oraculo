 $provincias_result = mysql_query("select * from PROVINCIA_CR");
   
 echo "var p=new Array();var c=new Array();var d=new Array();";

 while ($provincia_row = mysql_fetch_row($provincias_result)) {
    
  echo "p[" . $provincia_row[0] . "]='" . $provincia_row[1] . "';";
    
  $cantones_result = mysql_query("select * from CANTON_CR where codigo_provincia = ". $provincia_row[0]);

   $canton_line = "c[". $provincia_row[0] . "]='"; 
   $distrito_lines = "";

   while ($canton_row = mysql_fetch_row($cantones_result)) {

    $canton_line = $canton_line . $canton_row[2] ."@" .  $canton_row[1] . "~";
      
    $distritos_result = mysql_query("select * from DISTRITO_CR where codigo_canton = "
     . $canton_row[0]);
       
    $distrito_line = "d[". $canton_row[1] . "]='";   
    
    while ($distrito_row = mysql_fetch_row($distritos_result)) {
      $distrito_line .= $distrito_row[2] ."@" .  $distrito_row[1] . "~";
    }
    $distrito_line=substr_replace($distrito_line ,"",-1); // Remueve último caracter.
    $distrito_lines .= $distrito_line . "';";
   }
   $canton_line=substr_replace($canton_line ,"",-1); // Remueve último caracter.
   echo $canton_line . "';";
   echo $distrito_lines;   
 }