<?php
// This script and data application were generated by AppGini 5.72
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir = dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");

	handle_maintenance();

	header('Content-type: text/javascript; charset=' . datalist_db_encoding);

	$table_perms = getTablePermissions('invoices');
	if(!$table_perms[0]){ die('// Access denied!'); }

	$mfk = $_GET['mfk'];
	$id = makeSafe($_GET['id']);
	$rnd1 = intval($_GET['rnd1']); if(!$rnd1) $rnd1 = '';

	if(!$mfk){
		die('// No js code available!');
	}

	switch($mfk){

		case 'client':
			if(!$id){
				?>
				$j('#client_contact<?php echo $rnd1; ?>').html('&nbsp;');
				$j('#client_address<?php echo $rnd1; ?>').html('&nbsp;');
				$j('#client_phone<?php echo $rnd1; ?>').html('&nbsp;');
				$j('#client_email<?php echo $rnd1; ?>').html('&nbsp;');
				$j('#client_website<?php echo $rnd1; ?>').html('&nbsp;');
				$j('#client_comments<?php echo $rnd1; ?>').html('&nbsp;');
				<?php
				break;
			}
			$res = sql("SELECT `clients`.`id` as 'id', `clients`.`name` as 'name', `clients`.`contact` as 'contact', `clients`.`title` as 'title', `clients`.`address` as 'address', `clients`.`city` as 'city', `clients`.`country` as 'country', CONCAT_WS('-', LEFT(`clients`.`phone`,3), MID(`clients`.`phone`,4,3), RIGHT(`clients`.`phone`,4)) as 'phone', `clients`.`email` as 'email', `clients`.`website` as 'website', `clients`.`comments` as 'comments' FROM `clients`  WHERE `clients`.`id`='{$id}' limit 1", $eo);
			$row = db_fetch_assoc($res);
			?>
			$j('#client_contact<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(array("\r", "\n"), '', nl2br($row['contact']))); ?>&nbsp;');
			$j('#client_address<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(array("\r", "\n"), '', nl2br($row['address']))); ?>&nbsp;');
			$j('#client_phone<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(array("\r", "\n"), '', nl2br($row['phone']))); ?>&nbsp;');
			$j('#client_email<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(array("\r", "\n"), '', nl2br($row['email']))); ?>&nbsp;');
			$j('#client_website<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(array("\r", "\n"), '', nl2br($row['website']))); ?>&nbsp;');
			$j('#client_comments<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(array("\r", "\n"), '', nl2br($row['comments']))); ?>&nbsp;');
			<?php
			break;


	}

?>