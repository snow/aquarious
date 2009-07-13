<?php
	/**
	 * draw date pulldown input field
	 * 
	 * $usage $vars['start_year']
	 * $usage $vars['end_year']
	 * $usage $vars['internalname']
	 * $usage $vars['value']
	 */
	/**
	 * @author Snow.Hellsing <snow.hellsing@firebloom.cc>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */

	$internalname = $vars['internalname'];
	$value = $vars['value'];
	/**
	 * create years and months and days for later use
	 */
	//if not assigned,set years in pulldown to 1900 - now
	$start_year = isset($vars['start_year'])?$vars['start_year']:1900;
	$end_year = isset($vars['end_year'])?$vars['end_year']:date('Y');
	
	if ($start_year > $end_year) 
		throw new ConfigurationException("start_year=$start_year,end_year=$end_year");	
	//build arrays
	$years = array('' => elgg_echo('year'));
	$months = array('' => elgg_echo('month'));
	$days = array('' => elgg_echo('day'));
	//years array from now to 1900.For better user experience
	for($i = $end_year;$i >= $start_year;$i--){
		$years[$i] = $i;
	}
	for($i = 1;$i <= 12;$i++){
		$months[$i] = $i;
	}
	for($i = 1;$i <= 31;$i++){
		$days[$i] = $i;
	}
	/**
	 * convert unix timestamp into array of year,month and day
	 */
	if (!empty($value)) {
		$date = explode('-',date('Y-m-d',$value));
	}
	
	echo '<span class="datepulldown" style="display:none">';
	$onclick = 'onchange="process_date_input(\''.$internalname.'\')"';
	/**
	 * now build input form
	 */
	echo elgg_view("input/pulldown",
					array(
						'internalname' => "year",
						'value' => $date[0],
						'options_values' => $years,
						'js' => 'id="'.$internalname.'_years" '.$onclick,
						)
					);
	echo elgg_view("input/pulldown",
					array(
						'internalname' => "month",
						'value' => $date[1],
						'options_values' => $months,
						'js' => 'id="'.$internalname.'_months" '.$$onclick,
						)
					);
	echo elgg_view("input/pulldown",
					array(
						'internalname' => "day",
						'value' => $date[2],
						'options_values' => $days,
						'js' => 'id="'.$internalname.'_days" '.$onclick,
						)
					);
	//the hidden form to contain the unixtimestamp
	echo elgg_view('input/hidden',
					array(
						'internalname'=>$internalname,
						'value'=>$value,
						'js' => 'id="'.$internalname.'_hidden"',
					)
				);
	echo '<span>';
?>