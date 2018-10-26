<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class get_product_data_sale extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
	     
    }

	// Show view Page
	public function index(){

		$_btno = '';
		$_qty = '';
		$_rt = '';
		$_pid = '';
		$_amt = '';
		$_mid = '';
		$arrprd = array(); 
		$return = '';

		 $_btno = trim(strip_tags($_GET['btno']));
		 $_qty = (int) trim(strip_tags($_GET['qty']));
		 
		 $_option_p = (int) trim(strip_tags($_GET['option_p']));
		 
		 $_ps = trim(strip_tags($_GET['pid']));
		
		 $product_r = $this->db->query("select product_actual_price,product_margin,product_name,product_actual_price,product_discount,product_serial_no,product_id from product where product_serial_no ='".$_ps."'");

		 	$product_option_r = $this->db->query("SELECT po.product_option_stock,po.option_parent_id,po.option_id,o.option_name,po.product_option_id FROM product_option po 
				INNER JOIN options o ON po.option_id=o.option_id
				WHERE product_option_id =".$_option_p."");
			$p_option = $product_option_r->row_array();
			$option_name = $p_option['option_name'];

			foreach($product_r->result()  as $record)
			{
				echo $proid = $record->product_id;
				$_amt = floatval($p_option['product_option_stock']) * $_qty ;
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
						
						$return = '<tr id="row_'.str_replace('.','_',$_amt).'">';
						
						$return .= '<input type="hidden" name="proid" id="pro_'.$_amt.'" value="'.$proid.'" />';
						
						$return .= '<td align="center" valign="middle"> <input type="hidden" name="select_order_serialno1[]" value='.$_ps.' />';
						
						$return .='<div style="float:left;width:20%;"><input type="hidden" value="'.$_btno.'" name="select_order_btno[]" />';
						$return .= '<a href="javascript:void(0);" style="padding-right:20px;padding-left:10px;" onclick="javascript:return deleteprd(\''.$_amt.'\');"><img src="'.base_url().'/_template/images/icon-delete.gif" width="15" height="15" /></a></div>';
						
						$return .= '<strong>'.substr($_pnm,0,15).'</strong><input type="hidden" value="'.$_pnm.'" name="select_order_products_name[]" />';
						$return .= '<input type="hidden" value="'.$_mid.'" name="select_order_m_name[]" />';
						$return .= '</td>';
						
						$return .= '<td align="center" valign="middle">';
						$return .= '<strong>'.$_ps.'</strong><input type="hidden" id="serno'.str_replace('.','_',$_amt).'" value="'.$_ps.'" name="select_order_serialno[]" />';
						$return .= '</td>';
						
						$return .= '<td align="center" valign="middle">';
						$return .= '<strong>'.$_ppr.'</strong><input type="hidden" value="'.$_ppr.'" id="aprice_'.$_amt.'" name="select_order_products_rate[]" />';
						$return .= '</td>';
						
						$return .= '<td align="center" valign="middle"><input type="hidden" value="'.$_qty.'" id="qty_'.$_amt.'" name="select_products_qty[]" />
									<input type="hidden" value="'.$_option_p.'" id="option_'.$_amt.'" name="select_products_option[]" />';
						$return .= '<strong>'.$_qty.'('.$option_name.')</strong>';
						$return .= '</td>';
						
						
					    $return .= '<td align="center" valign="middle"><input type="hidden" id="p_amount_'.$_ps.'_'.$_option_p.'_'.$_qty.'" value="'.$_amt.'" name="select_products_amount[]" />';
						$return .= '<strong id="amt_'.$_amt.'">'.$_amt.'</strong>';
						$return .= '</td>';
						
						$return .= '</tr>';
				}


			} 

			echo $return;
		 
	}

}
?>
