<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>(mt) API PHP Class Tests</title>
	</head>
	<body>
		
		<h1>(mt) API PHP Class Tests</h1>
		
		<?php
		
		require_once('MtAPI.php');
		
		$mt = new MtAPI('KEY', 00000);
		
		$services = '';
		
		//$services = $mt->get_services_ids();
		//$services = $mt->get_service_details();
		//$services = $mt->get_services_list();
		//$services = $mt->get_os_list();
		//$services = $mt->get_available_services();
		//$services = $mt->reboot_service();
		//$services = $mt->set_plesk_password('XXXXX');
		//$services = $mt->add_temp_disk();
		//$services = $mt->flush_firewall();
		//$services = $mt->set_root_password('XXXXX');
		//$services = $mt->get_current_stats();
		//$services = $mt->get_range_stats(1298017800, 1298019800);
		//$services = $mt->get_predefined_range_stats('1day');
		//$services = $mt->get_warnings();
		//$services = $mt->get_warnings_thresholds();
		
		echo '<pre>';
		print_r($services);
		echo '</pre>';
		
		?>
		
	</body>
</html>