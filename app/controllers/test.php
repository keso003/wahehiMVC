<?php

class Test extends Controller {
	

	public function __construct() {
		parent::__construct();
	}

	public function wahehi($id, $name) {
		$this->load->model('Tests');

		//print_r($this->Tests->test()); die;
		//include(APPPATH . 'view/test_view.php');
		View::load('template/header');
		View::load('template/footer');
	}
	
}