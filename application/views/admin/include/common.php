<?php error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>TPV  <?php echo ucfirst($this->uri->segment(1));  ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<!-- Bootstrap 3.3.5 -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/bootstrap/css/bootstrap.min.css">
<!-- font Awesome -->
<link href="<?php echo base_url(); ?>_template/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!-- Ionicons -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/bootstrap/css/ionicons.min.css">
<!-- Button css  -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/css/button_switch.css">
<!-- jvectormap -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/dist/css/skins/_all-skins.min.css">

<link rel="stylesheet" href="<?php echo base_url(); ?>_template/bootstrap/css/developer.css">
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/plugins/select2/select2.min.css">
<!-- Date Picker -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/css/datepicker.css" type="text/css" />
<!-- daterange picker -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/plugins/daterangepicker/daterangepicker-bs3.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/plugins/iCheck/all.css">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/plugins/colorpicker/bootstrap-colorpicker.min.css">
<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/plugins/timepicker/bootstrap-timepicker.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/css/datepicker.css" type="text/css" />


<script type="text/javascript"  src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js" language="javascript"></script>

<script type="text/javascript"  src="//s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js
" language="javascript"></script>

<!--Conectar Hacienda-->


<script type="text/javascript" src="<?php echo base_url(); ?>_template/js/common.js" language="javascript"></script>
<!--MAscaras-->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js" language="javascript"></script>

<script type="text/javascript" src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js" language="javascript"></script>


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="_template/https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="_template/https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
