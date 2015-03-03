<?php
require_once '../../../../wp-load.php';

$members = findMembers();
$cities = $members['cities'];
$companies = $members['companies'];
$lastnames = $members['lastnames'];
$ids = $members['ids'];

//--SEARCH BY ID
if (isset($_POST['id'])) {		
	$id = $_POST['id'];
	$member = $ids[$id][0];
	if ($member) {
		$result = array();
		$result[]=$member;	
	}
}
//--SEARCH BY CITY, COMPANY, AND LAST NAME
else{	
	$city = $_POST['city'];
	$company = $_POST['company'];	
	$lastname = $_POST['lastname'];	
	if ($city != '' && $company != '' && $lastname != '') {
		$result = array();
		foreach ($cities as $cityName => $cit) {
			if (stristr($cityName, $city)) {
				foreach ($cit as $c) {
					foreach ($ids[$c] as $member) {
						if ( (stristr($member->CITY, $city)) && (stristr($member->COMPANY, $company)) && (stristr($member->LAST_NAME, $lastname)) ) {
							$result[]=$member;
						}
					}
				}
			}
		}
	}
//--SEARCH BY CITY
	elseif ($city != '' && $company == '' && $lastname == '') {
		$result = array();
		foreach ($cities as $cityName => $cit) {
			if (stristr($cityName, $city)) {
				foreach ($cit as $c) {
					foreach ($ids[$c] as $member) {
						if (stristr($member->CITY, $city)) {
							$result[]=$member;
						}
					}
				}
			}
		}
	}
//--SEARCH BY COMPANY
	elseif ($city == '' && $company != '' && $lastname == ''){
		$result = array();
		foreach ($companies as $companyName => $comp) {
			if (stristr($companyName, $company)) {
				foreach ($comp as $c) {
					foreach ($ids[$c] as $member) {
						if (stristr($member->COMPANY, $company)) {
							$result[]=$member;
						}
					}
				}
			}
		}
	}
//--SEARCH BY LAST NAME
	elseif ($city == '' && $company == '' && $lastname != ''){
		$result = array();
		foreach ($lastnames as $lastKey => $lname) {
			if (stristr($lastKey, $lastname)) {
				foreach ($lname as $l) {
					foreach ($ids[$l] as $member) {
						if (stristr($member->LAST_NAME, $lastname)) {
							$result[]=$member;
						}
					}
				}
			}
		}
	}
//--SEARCH BY CITY AND COMPANY
	elseif ($city != '' && $company != '' && $lastname == '') {
		$result = array();
		foreach ($cities as $cityName => $cit) {
			if (stristr($cityName, $city)) {
				foreach ($cit as $c) {
					foreach ($ids[$c] as $member) {
						if ( (stristr($member->CITY, $city)) && (stristr($member->COMPANY, $company)) ) {
							$result[]=$member;
						}
					}
				}
			}
		}
	}
//--SEARCH BY CITY AND LAST NAME
	elseif ($city != '' && $company == '' && $lastname != '') {
		$result = array();
		foreach ($cities as $cityName => $cit) {
			if (stristr($cityName, $city)) {
				foreach ($cit as $c) {
					foreach ($ids[$c] as $member) {
						if ( (stristr($member->CITY, $city)) && (stristr($member->LAST_NAME, $lastname)) ) {
							$result[]=$member;
						}
					}
				}
			}
		}
	}
//--SEARCH BY COMPANY AND LAST NAME
	elseif ($city == '' && $company != '' && $lastname != '') {
		$result = array();
		foreach ($companies as $companyName => $comp) {
			if (stristr($companyName, $company)) {
				foreach ($comp as $c) {
					foreach ($ids[$c] as $member) {
						if ( (stristr($member->COMPANY, $company)) && (stristr($member->LAST_NAME, $lastname)) ) {
							$result[]=$member;
						}
					}
				}
			}
		}
	}
}

//--RESULTS TABLE	

//--SHOW NUMBER OF RESULTS
$qtyToShow = 20;

if(!$result){
	echo "There are no results that match the filter you used";
}
else{
	$qty = count($result);
	$i = 0;
	$show = '';
	?>
	<table border="0">

	<?php
	foreach ($result as $member) {
		$i++;
		if ($i > $qtyToShow) {
			$show = 'style=display:none; class="hidden-tr"';
		} ?>			 
		<tr <?php echo $show; ?>>					
			<td>&nbsp;&nbsp;<strong><?php echo $member->FULL_NAME; ?></strong><?php if ($member->TITLE != '') {echo '  |  '.ucwords(strtolower($member->TITLE));} ?><?php if ($member->COMPANY != '') {echo '  |  '.$member->COMPANY;} ?><br>
			&nbsp;&nbsp; <img src="<?php bloginfo('template_directory'); ?>/images/w.png" alt="<?php echo $member->CITY; ?>" height="22" width="23"> <?php echo $member->ADDRESS_1; ?><?php if ($member->ADDRESS_2 != '') {echo '  |  '.$member->ADDRESS_2;} ?>  |  <?php echo $member->CITY; ?>,  <?php echo $member->STATE_PROVINCE; ?>  <?php echo $member->ZIP; ?><br>
			&nbsp;&nbsp; <img src="<?php bloginfo('template_directory'); ?>/images/m.png" alt="<?php echo $member->EMAIL; ?>" height="22" width="23"> <?php echo $member->EMAIL; ?><br>
			&nbsp;&nbsp; <img src="<?php bloginfo('template_directory'); ?>/images/p.png" alt="<?php echo $member->WORK_PHONE; ?> " height="22" width="23"> <?php echo $member->WORK_PHONE; ?> <?php if($member->FAX != '') {echo '  |  <img src=http://naifa-texas.org/wp-content/themes/dante/images/f.png height=22 width=23>  '.$member->FAX;} ?></td>
		</tr>

		<?php }	?>
	</table>
	<br>
	&nbsp;&nbsp;Total Count: <?php echo $qty ?>
	<?php
	if ($qty > $qtyToShow) {
		?><input id="more" type="button" value="More"><?php 
	}
	}



	