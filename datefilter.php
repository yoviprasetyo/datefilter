<?php

class DateFilter {

	// Array contain month's name
	$_month = array();

	/*
	The output format

	Type 1 = YYYY {delimiter} MM {delimiter} DD
	Type 2 = DD {delimiter} MM {delimiter} YYYY
	Type 3 = MM {delimiter} DD {delimiter} YYYY
	*/
	private $_out_format;

	/* 
	The default value of the delimiter
	Type 1 = space
	Type 2 = slash
	Type 3 = hyphen
	*/

	//	- in delimiter
	private $_in_delimiter = array();

	// - out delimiter
	private $_out_delimiter = array();

	// Flag to detect the input and output just month and year
	private $_month_year = 0;

	// Flag to detect the input and output just date and month
	private $_date_month = 0;

	// The data that inputted
	private $_unformated_date;

	// Data after the separation process
	private $_unassemble_date = array();

	// The data that will be show
	private $_formated_date;


	public function __construct() {
		$this->set_month();
	}

	private function set_month($month = array('january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december')) {
		$this->_month = $month;
		return $this;
	}

	private function set_unformated_date($date) {
		$this->_unformated_date = $date;
	}

	private function get_delimiter_type($type) {
		switch ($type) {
			case 1:
				$delimiter = ' ';
				break;
			case 2:
				$delimiter = '/';
				break;
			case 3:
				$delimiter = '-';
				break;
			default:
				$delimiter = ' ';
				break;
		}
		return $delimiter;
	}

	private function set_in_delimiter($type, $index) {
		if(is_numeric($type)) {
			$delimiter = $this->get_delimiter_type($type);
		} else {
			$delimiter = $type;
		}
		$this->_in_delimiter[$index] = $delimiter;
		return $this;
	}

	private function set_out_delimiter($type, $index) {
		if(is_numeric($type)) {
			$delimiter = $this->get_delimiter_type($type);
		} else {
			$delimiter = $type;
		}
		$this->_out_delimiter[$index] = $delimiter;
		return $this;
	}

	private function set_all_in_delimiter($type = 1) {
		$this->set_in_delimiter($type, 0)->set_in_delimiter($type, 1);
		return $this;
	}

	private function set_all_out_delimiter($type = 2) {
		$this->set_out_delimiter($type, 0)->set_out_delimiter($type, 1);
		return $this;
	}

	private function set_out_format($type = 1) {
		if($type < 1 OR $type > 3) {
			$out_format = 1;
		} else {
			$out_format = $type;
		}
		$this->_out_format = $out_format;
		return $this;
	}

	private function set_month_year() {
		$this->_month_year = 1;
		return $this;
	}

	private function set_date_month() {
		$this->_date_month = 1;
		return $this;
	}

	private function check_delimiter($string) {
		if(strpos($string,' ') !== false ){
			$delimiter = 1;
		} else if(strpos($string, '/') !== false){
			$delimiter = 2;
		} else if(strpos($string, '-') !== false){
			$delimiter = 3;
		} else {
			$delimiter = false;
		}
		return $delimiter;
	}

	private function separate() {
		if($this->_unformated_date !== null) {
			if(count($this->_in_delimiter) > 1) {
				if($this->_in_delimiter[0] === $this->_in_delimiter[1]) {
					$value = explode($this->_in_delimiter[0], $this->_unformated_date);
				} else {
					$exp_ = explode($this->_in_delimiter[0], $this->_unformated_date);
					$value[0] = $exp_[0];
					$exp_next_ = explode($this->_in_delimiter[1], $exp_[1]);
					$value[1] = $exp_next_[0];
					$value[2] = $exp_next_[1];
				}
			} else {
				$value = explode($this->_in_delimiter[0], $this->_unformated_date);
			}
		} else {
			$value = false;
		}
		$this->_unassemble_date = $value;
	}

	private function do_format() {

	}

	private function assemble() {
		$string_out = null;
		foreach ($this->_unassemble_date as $key => $value) {
			if($key !== 0) {
				$key_delimiter = $key - 1;
				$string_out .= $this->_out_delimiter[$key_delimiter];
			}
			$string_out .= $value;
		}
		return $string_out;
	}

	public function filterdate($date, $format = 1, $out = 2, $in = null) {
		if($in === null) {
			$delimiter = $this->check_delimiter($date);
		}
		
		$hasil = $this->format($delimiter,$date);
		return $hasil;
	}
	private function format($delimiter,$string){
		if($delimiter == 'slash'){
			$hasil = $this->doformat('/',$string);
		} else if($delimiter == 'hyphen'){
			$hasil = $this->doformat('-',$string);
		} else if($delimiter == 'space'){
			$hasil = $this->doformat(' ',$string);
		}
		return $hasil;
	}
	private function doformat($delimiter,$string){
		$a = explode($delimiter, $string);
		$b = 0;
		foreach ($a as $key) {
			if(!is_numeric($key))
				$b++;
		}
		if($b > 0){
			$a = $this->stringtonumeric($a);
		}
		if($a[0] < 10){
			$a[0] = str_replace('0', '', $a[0]);
		}
		if($a[1] < 10){
			$a[1] = str_replace('0', '', $a[1]);
		}
		if(strlen($a[0]) > 2){
			$tmp = $a[0];
			$a[0] = $a[2];
			$a[2] = $tmp;
			$construct = implode('-', $a);
		} else {
			$construct = implode('-', $a);
		}
		return $construct;
	}
	private function stringtonumeric($array){
		$i = 0;
		$j = 0;
		if(!is_numeric($array[0])){
			$j = 1;		
		}
		foreach ($array as $key) {
			$key = str_replace(',', '', $key);
			if(!is_numeric($key)){
				$key = $this->converttostring($key);
			}
			$a[$i] = $key;
			$i++;
		}
		if($j > 0){
			$tmp = $a[0];
			$a[0] = $a[1];
			$a[1] = $tmp;
		}
		return $a;
	}
	private function converttostring($string){
		$string = strtolower($string);
		if(substr($string,0,3) == 'jan'){
			return 1;
		}
		if(substr($string,0,1) == 'f'){
			return 2;
		}
		if(substr($string,0,3) == 'mar'){
			return 3;
		}
		if(substr($string,0,2) == 'ap'){
			return 4;
		}
		if(substr($string,0,3) == 'mei' || substr($string,0,3) == 'may'){
			return 5;
		}
		if(substr($string,0,3) == 'jun'){
			return 6;
		}
		if(substr($string,0,3) == 'jul'){
			return 7;
		}
		if(substr($string,0,2) == 'ag'){
			return 8;
		}
		if(substr($string,0,2) == 'se'){
			return 9;
		}
		if(substr($string,0,1) == 'o'){
			return 10;
		}
		if(substr($string,0,3) == 'nov'){
			return 11;
		}
		if(substr($string,0,2) == 'de'){
			return 12;
		}
	}
	

}