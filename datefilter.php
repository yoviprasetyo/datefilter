<?php
$data = array(
		'January 7, 2016',
		'February 11, 2017',
		'28/02/2017',
		'27/02/2017',
		'2017-02-28',
		'2009-06-27',
		'2001/02/28',
		'2001/10/26',
		'27 Feb 2015',
		'20 Ags 2015',
		'28 Februari 2017',
		'6 November, 2009',
		'7 November, 2018',
		'01 Mar 2017',
		'02 Feb 2017',
		'01 Maret 2017',
		'28 Februari 2017'
		);

class datefilter {

	public function filterdate($date){
		$separator = $this->checkseparator($date);
		$hasil = $this->format($separator,$date);
		return $hasil;
	}
	private function format($separator,$string){
		if($separator == 'slash'){
			$hasil = $this->doformat('/',$string);
		} else if($separator == 'strip'){
			$hasil = $this->doformat('-',$string);
		} else if($separator == 'spasi'){
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
	private function checkseparator($string){
		if(strpos($string,' ') !== false ){
			return 'spasi';
		} else if(strpos($string, '/') !== false){
			return 'slash';
		} else if(strpos($string, '-') !== false){
			return 'strip';
		}
	}

}

$a = new datefilter();

foreach ($data as $date) {
	echo $a->filterdate($date);
	echo "<br>";
}

?>