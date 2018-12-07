  <?php
  if(!isset($_SESSION['old_id']))
  {
    $_SESSION['old_id'] = 1;
  }

   
?>

<?php
// Add FIle
// include common file
 $this->load->view('admin/include/common.php'); 
// include header file
  $this->load->view('admin/include/header.php'); 
// include sidebar file  
  $this->load->view('admin/include/sidebar.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    
      <h1 align="center">
       Metodos de pago
        <small> </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Ventas</li>
      </ol>
      

  
    
    </section>
    <!-- Main content -->
    <section  align="center" class="content">
    
    <div class="row">
    <label >Total a pagar: <?php echo $pagar; ?></label>
     <input hidden="true" id="pagar"  name="pagar" value="<?php echo $pagar; ?>"></input>
    
      


    </div>
    <input id="deno"  name="deno"></input>

     <input hidden id="vuelto"  name="vuelto"></input>

       <input type="submit" align="center" value="Pagar" onclick="capturar()">





     
    </section>

  
            
             
       
        
        

  </div>

    

  <script type="text/javascript">

  $(document).ready(function(){
      $('#deno').focus();
      

      
  });

  function capturar(){

    var denominacion= document.getElementById("deno").value;
    var total_pagar=  document.getElementById("pagar").value;
    var vuelto= denominacion - total_pagar;

    alert("El vuento es: "+ vuelto);

   document.getElementById("vuelto").value = vuelto;

   location.href ="http://localhost/oraculo/index.php/sales/create";


  }
   
 

  </script>