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
      <h1>
        Users
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header">
                <h3 class="box-title">Add</h3>
                <a href="<?php echo base_url().'index.php/users'; ?>" class="btn btn-primary btn-small pull-right">Back to List</a>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <?php if(validation_errors() != false){ ?>
                <div class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h4><i class="icon fa fa-ban"></i> Error!</h4>
                    <?php echo validation_errors(); ?>
                </div>
                <?php } ?>
              <?php 
                $attributes = array('id' => 'frm','name'=>'frm');
                  echo form_open('users/create',$attributes); ?>

                  <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash'];?>" />
					           <div class="form-group"> 
                        <label>User group :</label>
                        <select name="txt_user_group_id" class="form-control ">
                            
                         <?php 
                            $CI =& get_instance();
                            $group = $CI->get_All_group();
                            foreach ($group as $value) {
                                ?>
                                <option value="<?php echo $value->user_group_id; ?>"><?php echo $value->user_group_name; ?></option>
                                <?php
                            }
                          ?>
                        </select>

                    </div>


					          <div class="form-group">
                        <label>User name :</label>
                        <input type="text" name="txt_user_name" class="form-control " placeholder="User name Here..." value="" />
                    </div>
					
					          <div class="form-group">
                        <label>Password :</label>
                        <input type="password" name="txt_password" class="form-control " placeholder="Password Here..." value="" />
                    </div>

                    <div class="form-group">
                        <label>Confirm Password :</label>
                        <input type="password" name="confirm_password" class="form-control " placeholder="Confirm Password Here..." value="" />
                    </div>
					         
                   <div class="form-group">
                        <label>User active :</label>
                        <input type="radio" name="txt_user_active" checked value="yes" /> Yes
                        <input type="radio" name="txt_user_active" value="no" /> No
                    </div>

                    <table class="table">
                      <tr>
                        <th><label>User Rights...</label></th> 
                      </tr>
                      <tr>
                        <td>
                          <table class="table">
                            <tr>
                              <td width="40%"><strong>Rights Name</strong></td>
                              <td width="10%"><strong>View</strong></td>
                              <td width="10%"><strong>Add</strong></td>
                              <td width="10%"><strong>Edit</strong></td>
                              <td width="15%"><strong>Delete</strong></td>
                              <td width="15%"><strong>Sales Return</strong></td>
                            </tr>
                            <?php 
                              $CI =& get_instance();
                              $component = $CI->get_component();
                              $i = 0;
                              foreach ($component as  $_c) {
                                $i++;
                                ?>
                                <tr <?php if($_c->component_name == 'setup' || $_c->component_name == 'report') echo 'class="bg-blue"';  ?>>
                                  <td>
                                    <?php if($_c->component_name == 'order-view') echo 'Chef monitoring Screen'; else echo $_c->component_name; ?>
                                  </td>
                                  <?php
                                    if($_c->component_name == 'report')
                                    {
                                        ?>
                                          <td>
                                            <label class="pull-right">Bill </label>
                                          </td>
                                          <td>  
                                            <input type="checkbox" name="chk1_<?php echo $i; ?>" id="chk1_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/" />
                                          </td>
                                          <td>
                                            <label class="pull-right">Table Bill </label>
                                          </td>
                                          <td>
                                            <input type="checkbox" name="chk2_<?php echo $i; ?>" id="chk2_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/table" />
                                          </td>
                                          <td></td>
                                        <?php
                                    }
                                    else if($_c->component_name == 'setup')
                                    {
                                        ?>
                                          <td> 
                                            <label class="pull-right">Setup</label>
                                          </td>
                                          <td>
                                            <input type="checkbox" name="chk1_<?php echo $i; ?>" id="chk1_<?php echo $i; ?>" value="company/edit" />
                                          </td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                        <?php
                                    }
                                    else if($_c->component_name == 'order-view')
                                    {
                                        ?>
                                          <td>
                                            <input type="checkbox" name="chk1_<?php echo $i; ?>" id="chk1_<?php echo $i; ?>" value="sales/order_view" />
                                          </td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                        <?php
                                    }
                                    else
                                    {
                                  ?>
                                          <td>
                                            <input type="checkbox" name="chk1_<?php echo $i; ?>" id="chk4_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/" />
                                          </td>
                                          <td>
                                            <input type="checkbox" name="chk2_<?php echo $i; ?>" id="chk4_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/create" />
                                          </td>
                                          <td>
                                            <input type="checkbox" name="chk3_<?php echo $i; ?>" id="chk4_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/edit" />
                                          </td>
                                          <td>
                                            <input type="checkbox" name="chk4_<?php echo $i; ?>" id="chk4_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/delete" />
                                          </td>
                                          <?php 
                                            if($_c->component_name == 'sales')
                                            {
                                              ?>
                                              <td>
                                                <input type="checkbox" name="chk5_<?php echo $i; ?>" id="chk4_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/return_sales" />
                                              </td>
                                              <?php
                                            }
                                  }
                                  ?>
                                </tr>
                                <?php
                              }

                            ?>
                          </table>
                        </td>
                      </tr>
                    </table>

                    
                    <div class="form-group">
                      <input type="submit" name="btnsubmit" class="btn btn-primary" value="Save"/>
                      <input type="button" title="Cancel" value="Cancel" class="btn btn-danger" onclick="javascript:window.location.href='<?php echo base_url().'index.php/users' ?>'" />
                    </div>

              <?php echo form_close(); ?>
              </div>
            </div>
          </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <?php 
	// include footer file
 
 $this->load->view('admin/include/footer.php'); ?>