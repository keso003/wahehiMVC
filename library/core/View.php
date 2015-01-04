<?php

class View {

	private $data = '';

	public static function load($file, $is_output = false) {
		$_view_path = APPPATH . 'view/';
		// check if file has .php extension
		// if has no .php append .php
		$_file_ext = pathinfo($file, PATHINFO_EXTENSION);
		$file = ($_file_ext == '') ? $file.'.php' : $file;


		if(!file_exists($_view_path . $file)) {
			die('Error file doesn\'t exists');
		}

		ob_start();
		include($_view_path . $file);

		if($is_output) {
			$output = ob_get_clean();
			@ob_end_clean();
			return $output;
		}
	}

	public function data($name, $data) {
		$this->data[$name] = (is_array($data))? $data : (array) $data;
	}
}