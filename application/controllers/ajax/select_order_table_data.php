<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class select_order_table_data extends CI_Controller {

	public function __construct() 
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
	    
    }

	// Show view Page
	public function index()
	{

		$return = null;

		$admin_id = $this->session->userdata('userid');
		$q_result = $this->db->query("SELECT * FROM sales_tmp WHERE table_id =".$this->input->get('table_no')." AND admin_id = ".$admin_id."");

		if ($q_result->num_rows()) {
			
			foreach ($q_result->result() as $row)
			{

				$_option_p = (int)($row->product_option_id);
				$_qty = (int)($row->purchase_item_qty);
				$_ps = $row->purchase_serial_no;

				$product_r = $this->db->query("select product_actual_price,product_margin,product_name,product_actual_price,product_discount,product_serial_no,product_id from product where product_serial_no ='".$_ps."'");

				$product_option_r = $this->db->query("SELECT po.product_option_stock,po.option_parent_id,po.option_id,o.option_name,po.product_option_id FROM product_option po 
					INNER JOIN options o ON po.option_id=o.option_id
					WHERE product_option_id =".$_option_p."");
				$p_option = $product_option_r->row_array();
				$option_name = $p_option['option_name']; 

				foreach($product_r->result()  as $record)
				{
					$proid = $record->product_id;
					$_amt = intval($p_option['product_option_stock']) * $_qty ;
					$_pnm = $record->product_name;
					$_ppr = $p_option['product_option_stock'];
					$_disc = $record->product_discount;
					$_ps = $record->product_serial_no;
					$_mar = $record->product_margin;
					
					if($_mar != 0)
					{
						$margin = $_ppr * $_mar /100;
						$_ppr += $margin;
						
						$_amt = $_ppr * $_qty;
					}
					if($_disc != 0 &&  $_disc > 0)
					{
						$t_ma = $_amt * $_disc /100;
						$_amt = floor($_amt - $t_ma);
					}


					if($_ps != '')
					{
						$return .= '<tr id="row_'.$_amt.'">';
											
						$return .= '<input type="hidden" name="proid" id="pro_'.$_amt.'" value="'.$proid.'" />';
						
						$return .= '<td align="center" valign="middle">';
						$return .= '<strong>'.$_pnm.'</strong>';
						$return .= '</td>';
						
						$return .= '<td align="center" valign="middle">';
						$return .= '<strong>'.$_ppr.'</strong>';
						$return .= '</td>';
						
						$return .= '<td align="center" valign="middle">';
						$return .= '<strong>'.$_qty.'('.$option_name.')</strong>';
						$return .= '</td>';
						
						$return .= '</tr>';
							
					}

				}

			}

		}
		else
		{
			$return = "<tr>
						<td colspan='3' align='center' valign='middle'>
							<font color='red' size='5'><strong>This ".$_GET['table_no']." Table In No Order !!!!!</strong></font>
						</td>
					   </tr>";
		}

		echo $return;
		
		////////////////////////////////////////////////// SHOW DATA //////////////////////////////////////////////
		
		
		$_SESSION['old_id'] = $_GET['table_no'];

	}
}

?>