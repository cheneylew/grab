<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {	
	public function __construct(){
		parent::__construct();
		$this->load->model('api_model');
		ini_set("max_execution_time", "360000");
	}
	public function index()
	{
		echo "I'am API";
	}
	public function getBuyersList(){
		$result_array=$this->api_model->getBuyerList();
		$json_string=json_encode($result_array);
		echo $json_string;
	}
	public function updateABuyer(){
		$phone=$this->input->post('phone');
		$name=$this->input->post('name');
		$comment=$this->input->post('comment');
		$email=$this->input->post('email');
		$id=$this->input->post('id');
		if (empty($id)) {
			echo 'id cannt be null';
			return ;
		}
		$isOK=$this->api_model->updateABuyer($phone,$name,$comment,$email,$id);
		if ($isOK) {
			echo "true";
		}else echo "false";
	}
	public function addABuyer(){
		$phone=$this->input->post('phone');
		$name=$this->input->post('name');
		$comment=$this->input->post('comment');
		$email=$this->input->post('email');
		$row_id=$this->api_model->addABuyer($phone,$name,$comment,$email);
		if ($row_id>0) {
			echo "true";
		}else echo "false";
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */