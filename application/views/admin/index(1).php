<?php
  
  $CI =& get_instance();
  $totaluser = $CI->total_user();
  $totalcustomer = $CI->total_customer();
  $totalparty = $CI->total_party();
  $totalproduct = $CI->total_product();
  $total_bill = $CI->total_bill();
  
  $recored = $CI->sales();
  $order = $CI->order();
  //print_r($order);exit;
  $product = $CI->get_product();

  $arpn = array();
  $arpt = array();
  $sales = $CI->get_sales_chart();

  foreach ($sales as  $row) {
    $arpn[] = $row->purchase_item_name;
    $total = $CI->get_sales_qty($row->purchase_item_name); 
    $arpt[] = $total['total'];
  }

  $salevalue = array();
  for ($i =1 ; $i<=14; $i++){
    $val = $CI->sale_month_r($i);
    $salevalue[] = intval($val);
  }
  $sv = implode(',',$salevalue); 

?>

<?php include('include/common.php'); ?>

  <?php include('include/header.php'); ?>
  
  <?php include('include/sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Panel de Control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
          <h3><?php echo $total_bill; ?></h3>
                  <p>Total de Ventas</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="<?php echo base_url() ?>index.php/sales" class="small-box-footer">Mas info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $totaluser; ?></h3>
                  <p>Total User</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="<?php echo base_url() ?>index.php/users" class="small-box-footer">Mas info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo $totalcustomer; ?></h3>
                  <p>Total Clientes</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="<?php echo base_url() ?>index.php/customer" class="small-box-footer">Mas info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
      <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php echo $totalproduct; ?></h3>
                  <p>Total Product</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="<?php echo base_url() ?>index.php/product" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
      
          </div><!-- /.row -->

      <div class="row">
      
        
            <div class="col-md-8">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Monthly Recap Report</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <div class="btn-group">
                      <button class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown"><i class="fa fa-wrench"></i></button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                      </ul>
                    </div>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
                      <p class="text-center">
                        <strong>Sales: 1 Jan, <?php echo date('Y'); ?> - 31 Desc, <?php echo date('Y'); ?></strong>
                      </p>
                      <div class="chart">
                        <!-- Sales Chart Canvas -->
                        <canvas id="salesChart" style="height: 295px;"></canvas>
                      </div><!-- /.chart-responsive -->
                    </div><!-- /.col -->
                    
                  </div><!-- /.row -->
                </div><!-- ./box-body -->
                
              </div><!-- /.box -->
            </div><!-- /.col -->
      
      <div class="col-md-4">
        <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Product Sale Report</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="chart-responsive">
                        <canvas id="pieChart" height="320"></canvas>
                      </div><!-- ./chart-responsive -->
                    </div><!-- /.col -->
                    
                  </div><!-- /.row -->
                </div><!-- /.box-body -->
                
              </div><!-- /.box -->
      </div>
      
         
 
      
      </div>
      <!-- /.row -->


      <div class="row">
      <div class="col-md-8">
      <!-- TABLE: LATEST ORDERS -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Latest Orders</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                        <tr>
                          <th>Order ID</th>
                          <th>Item</th>
                          <th>Status</th>
                          <th>Grand Total</th>
                        </tr>
                      </thead>
                      <tbody>
            <?php
            
            foreach($order as $_order)
            {
              ?>
              <tr>
                <td><a href="javascript:order_info('<?php echo $_order->purchase_no ?>');"><?php echo  $_order->purchase_no; ?></a></td>
                <td><?php echo  $_order->purchase_item_name; ?></td>
                <td><span class="label label-danger">Delivered</span></td>
                <td><span class="label label-success"> &nbsp;<?php echo  $_order->grand_total; ?></span></td>
              </tr>
              <?php
            }
            
            ?>
                        
                        
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                  <a href="<?php echo base_url() ?>index.php/sales/create" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
                  <a href="<?php echo base_url() ?>index.php/sales" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
                </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->
      
      <div class="col-md-4">
        <!-- PRODUCT LIST -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Productos recientemente agregados</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <ul class="products-list product-list-in-box">
          <?php
          foreach($product as $_pro)
          {
            $photo = 'file/product/'.$_pro->product_image_1;
            $dphoto = base_url().'_template/images/default-50x50.png';
            ?>
          <li class="item">
                      <div class="product-img">
                        <img height="50" width="50" src="<?php if(file_exists($photo)) echo base_url().$photo; else echo $dphoto;  ?>" alt="Image">
                      </div>
                      <div class="product-info">
                        <a class="product-title"><?php echo $_pro->product_name; ?></a>
                        <span class="product-description">
              Serial Number :
                          <?php echo $_pro->product_serial_no; ?>
                        </span>
                      </div>
                    </li><!-- /.item -->
            <?php
          }
          ?>
                    
                  </ul>
                </div><!-- /.box-body -->
                <div class="box-footer text-center">
                  <a href="<?php echo base_url() ?>index.php/product" class="uppercase">Ver Todos los Productos</a>
                </div><!-- /.box-footer -->
              </div><!-- /.box -->
      </div>
      
    </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <?php include('include/footer.php'); ?>

<!-- Sparkline -->
    <script src="<?php echo base_url() ?>_template/plugins/sparkline/jquery.sparkline.min.js"></script>
 <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?php echo base_url() ?>_template/distm/js/pages/dashboard2.js"></script>
 <!-- ChartJS 1.0.1 -->
    <script src="<?php echo base_url() ?>_template/plugins/chartjs/Chart.min.js"></script>

 <script>
  //-----------------------
  //- MONTHLY SALES CHART -
  //-----------------------
$(function(){
  // Get context with jQuery - using jQuery's .get() method.
  var salesChartCanvas = $("#salesChart").get(0).getContext("2d");
  // This will get the first returned node in the jQuery collection.
  var salesChart = new Chart(salesChartCanvas);

  var salesChartData = {
    labels: ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"],
    datasets: [
      {
        label: "Digital Goods",
        fillColor: "rgba(60,141,188,0.9)",
        strokeColor: "rgba(60,141,188,0.8)",
        pointColor: "#3b8bba",
        pointStrokeColor: "rgba(60,141,188,1)",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(60,141,188,1)",
        data: [<?php echo $sv ?>]
      }
    ]
  };

  var salesChartOptions = {
    //Boolean - If we should show the scale at all
    showScale: true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines: false,
    //String - Colour of the grid lines
    scaleGridLineColor: "rgba(0,0,0,.05)",
    //Number - Width of the grid lines
    scaleGridLineWidth: 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines: true,
    //Boolean - Whether the line is curved between points
    bezierCurve: true,
    //Number - Tension of the bezier curve between points
    bezierCurveTension: 0.3,
    //Boolean - Whether to show a dot for each point
    pointDot: false,
    //Number - Radius of each point dot in pixels
    pointDotRadius: 4,
    //Number - Pixel width of point dot stroke
    pointDotStrokeWidth: 1,
    //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
    pointHitDetectionRadius: 20,
    //Boolean - Whether to show a stroke for datasets
    datasetStroke: true,
    //Number - Pixel width of dataset stroke
    datasetStrokeWidth: 2,
    //Boolean - Whether to fill the dataset with a color
    datasetFill: true,
    //String - A legend template
    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%=datasets[i].label%></li><%}%></ul>",
    //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio: true,
    //Boolean - whether to make the chart responsive to window resizing
    responsive: true
  };

  //Create the line chart
  salesChart.Line(salesChartData, salesChartOptions);

  //---------------------------
  //- END MONTHLY SALES CHART -
  //---------------------------
  
  //-------------
  //- PIE CHART -
  //-------------
  // Get context with jQuery - using jQuery's .get() method.
  var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
  var pieChart = new Chart(pieChartCanvas);
  var PieData = [
  
    <?php
  $a = 'abcdefghijklmnopqrstuvwxyz123456789';
    for($i =0;$i < count($arpn);$i++ )
    {
      $color;
        
        $color = substr(md5(rand()), 0, 6); 
      
      ?>
      {
        value : <?php echo $arpt[$i] ?>,
        color : "#<?php echo $color ?>",
        highlight: "#<?php echo $color ?>",
        label: "<?php echo $arpn[$i] ?>" 
      
      <?php
      echo '}';
      if(count($arpn) == $i)
      {
        echo '';
      }
      else
      {
        echo ',';
      }
    }
  
  ?>
  
  ];
  var pieOptions = {
    //Boolean - Whether we should show a stroke on each segment
    segmentShowStroke: true,
    //String - The colour of each segment stroke
    segmentStrokeColor: "#fff",
    //Number - The width of each segment stroke
    segmentStrokeWidth: 1,
    //Number - The percentage of the chart that we cut out of the middle
    percentageInnerCutout: 50, // This is 0 for Pie charts
    //Number - Amount of animation steps
    animationSteps: 100,
    //String - Animation easing effect
    animationEasing: "easeOutBounce",
    //Boolean - Whether we animate the rotation of the Doughnut
    animateRotate: true,
    //Boolean - Whether we animate scaling the Doughnut from the centre
    animateScale: false,
    //Boolean - whether to make the chart responsive to window resizing
    responsive: true,
    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio: false,
    //String - A legend template
    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>",
    //String - A tooltip template
    tooltipTemplate: "<%=value %> :: <%=label%> "
  };
  //Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  pieChart.Doughnut(PieData, pieOptions);
  //-----------------
  //- END PIE CHART -
  //-----------------

  
});


  function order_info(_orderno)
  { 
    var w = 900;
    var h = 600;
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    window.open("<?php echo base_url() ?>index.php/report/order_info/"+_orderno,"_blank","resizable=yes,location=no,menubar=no,scrollbars=yes,status=no,toolbar=no,fullscreen=no,dependent=no,copyhistory=no,width="+w+",height="+h+",left="+left+",top="+top);
  }
</script>