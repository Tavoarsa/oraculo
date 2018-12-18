<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// add customer
class add_customer extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
	     
    }

	// Show view Page
	public function index(){
		$receptor_nombre 			= $_GET['receptor_nombre'];
		$receptor_tipo_identif	    = $_GET['receptor_tipo_identif'];
		$receptor_num_identif 		= $_GET['receptor_num_identif'];
		$receptor_provincia 		= $_GET['receptor_provincia'];
		$receptor_canton 			= $_GET['receptor_canton'];
		$receptor_distrito 			= $_GET['receptor_distrito'];
		$receptor_barrio 			= $_GET['receptor_barrio'];
		$receptor_cod_pais_tel		= $_GET['receptor_cod_pais_tel'];
		$receptor_tel 				= $_GET['receptor_tel'];
		$receptor_cod_pais_fax		= $_GET['receptor_cod_pais_fax'];
		$receptor_fax 				= $_GET['receptor_fax'];
		$receptor_email 			= $_GET['receptor_email'];

		if($receptor_nombre != '' && $receptor_tipo_identif != '' && $receptor_num_identif != '' && $receptor_provincia != '' && $receptor_canton != '' && $receptor_distrito != '' && $receptor_barrio != '' && $receptor_cod_pais_tel != '' && $receptor_tel != '' && $receptor_cod_pais_fax != '' && $receptor_fax != '' && $receptor_email != '')
		{
			$q = "INSERT INTO customer (receptor_nombre,receptor_tipo_identif,receptor_num_identif,receptor_provincia,receptor_canton,receptor_distrito,receptor_barrio,receptor_cod_pais_tel,receptor_tel,receptor_cod_pais_fax,receptor_fax,receptor_email)
						VALUES ('".$receptor_nombre."','".$receptor_tipo_identif."','".$receptor_num_identif."','".$receptor_provincia."','".$receptor_canton."','".$receptor_distrito."','".$receptor_barrio."','".$receptor_cod_pais_tel."',''".$receptor_tel."','".$receptor_cod_pais_fax."','".$receptor_fax."','".$receptor_email."',)";

			$this->db->query($q);
			if($this->db->insert_id())
			{
				echo 'Cliente Agregado Correctamente';
			}

		}
	}

}
?>