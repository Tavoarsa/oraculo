<style>
.skin-blue .navbar .nav .my_own_class a {
  color: rgba(0, 0, 0, 0.8);
}
.goog-te-gadget-icon{
background:none !important;
}
</style>  
<script>
  
  
  setInterval(function() {
    var currentTime = new Date ( );    
  var cdate = currentTime.getDate();
  var cmonth = currentTime.getMonth()+1; 
  var cyear = currentTime.getFullYear(); 
    var currentHours = currentTime.getHours ( );   
    var currentMinutes = currentTime.getMinutes ( );   
    var currentSeconds = currentTime.getSeconds ( );
    currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;   
    currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;    
    var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";    
    currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;    
    currentHours = ( currentHours == 0 ) ? 12 : currentHours;    
    var currentTimeString =cdate + "/" + cmonth + "/" + cyear + " " + currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
    document.getElementById("ch_date").innerHTML = currentTimeString;
}, 1000);
</script>

<script type="text/javascript">
  function googleTranslateElementInit() {
    new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
  }
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
</script>


<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url() ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>POS</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b></b>San Carlos</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" id="bandh" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <li class="dropdown message-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span id="ch_date">
                
                </span>
              </a>
            </li>
            <li class="dropdown message-menu my_own_class" style="color:black !important; height:50px;">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span >
                <div id="google_translate_element">
                </div>
                </span>
              </a>
            </li>

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url() ?>_template/dist/img/user-login.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $this->session->userdata('username'); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url() ?>_template/dist/img/user-login.jpg" class="img-circle" alt="User Image">

                <p>
                  <?php echo $this->session->userdata('username'); ?>
                  <small></small>
                </p>
              </li>
             
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo base_url().'index.php/users/change_password' ?>" class="btn btn-default btn-flat">Cambiar Contraseña</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url().'index.php/login/logout' ?>" class="btn btn-default btn-flat">Cerrar sesión</a>
                </div>
              </li>
            </ul>
          </li>
          
        </ul>
      </div>
    </nav>
  </header>