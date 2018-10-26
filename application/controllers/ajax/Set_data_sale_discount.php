<?PHP 
defined('BASEPATH') OR exit('No direct script access allowed');
// select data for sales discount
class set_data_sale_discount extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
	     
    }

	// Show view Page
	public function index(){
		$_amt =  trim(strip_tags($_GET['amt']));
		$proid = null;
		$_amt = -$_amt;
						
		$return = '<tr id="row_'.str_replace('.','_',$_amt).'">';
		
		$return .= '<input type="hidden" name="proid" id="pro_'.$_amt.'" value="'.$proid.'" />';
		
		$return .= '<td align="center" valign="middle" colspan="4">';
		
		$return .='<div style="float:left;width:10%;">';
		$return .= '<a href="javascript:void(0);" style="padding-right:20px;padding-left:12px;" onclick="javascript:return deleteprd(\''.$_amt.'\');"><img src="'.base_url().'_template/images/icon-delete.gif" width="15" height="15" /></a></div>';
						
		
		$return .= '<strong>Entire Bill Discount</strong><input type="hidden" value="Discount" name="select_order_products_name[]" />';
		
		$return .= '</td>';
		
		
		$return .= '<td align="center" valign="middle"><input type="hidden" id="p_amount_'.$_amt.'"  value="'.$_amt.'" name="select_products_amount[]" />';
		$return .= '<strong id="amt_'.$_amt.'">'.abs($_amt).'</strong>';
		$return .= '</td>';
		
		$return .= '</tr>';
				
	echo $return;
	}
}

?>
