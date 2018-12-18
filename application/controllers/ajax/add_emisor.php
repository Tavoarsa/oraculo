<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// add_emisor
class add_emisor extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
	     
    }

	// Show view Page
	public function index(){

	$provincia=$_POST['provincia'];

	$sql="SELECT idCanton,nombreCanton FROM `codificacion_mh` WHERE idProvincia =  $provincia GROUP by nombreCanton";

	$result=mysqli_query($sql);

	$cadena="<label>SELECT 2 (paises)</label> 
			<select id='lista2' name='lista2'>";

	while ($ver=mysqli_fetch_row($result)) {
		$cadena=$cadena.'<option value='.$ver[0].'>'.utf8_encode($ver[2]).'</option>';
	}

	echo  $cadena."</select>";
	}

}
?>