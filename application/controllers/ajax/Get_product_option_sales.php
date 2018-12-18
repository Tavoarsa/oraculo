<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class get_product_option_sales extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
	    
    }

	// Show view Page
	public function index(){

		$p_s = $this->input->get("name");
		$_arr_1 = array();
		$arr_1 = array();
		$html = '';

		if($p_s != '')
		{
			$query = $this->db->query("SELECT product_id FROM product WHERE product_serial_no = '".$p_s."'");
			$rowp = $query->row_array();

			if($rowp['product_id'] != '')
			{

				$o_q = $this->db->query("SELECT po.product_option_stock,po.option_parent_id,po.option_id,o.option_name,po.product_option_id FROM product_option po 
						INNER JOIN options o ON po.option_id=o.option_id
						WHERE product_id =".$rowp['product_id']." ");
				$i = 0;

				foreach($o_q->result()  as $orow)
				{
					$i++;
					if($i == 1){ $check = 'checked="checked"'; } else { $check = "";}

					$html .='<input type="radio" name="option" id="option_name" value='.$orow->product_option_id.' '.$check.' />'.$orow->option_name.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
				}
			}
			echo $html;
		}
	}
}

?>
