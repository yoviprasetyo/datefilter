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

require('datefilter.php');

$a = new datefilter();

foreach ($data as $k => $v) {
	echo $a->filterdate($v);
	echo "<br>";
}
