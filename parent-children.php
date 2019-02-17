<?php
	/* Configuration */
	/*************************************/

		$pcConfig = array(
			'invoices' => array(   
				'client' => array(   
					'parent-table' => 'clients',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Invoices',
					'auto-close' => true,
					'table-icon' => 'resources/table_icons/attributes_display.png',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => array(1 => 'Code', 2 => 'Status', 3 => 'Date due', 4 => 'Client', 5 => 'Client contact', 7 => 'Client phone', 14 => 'Total'),
					'display-field-names' => array(1 => 'code', 2 => 'status', 3 => 'date_due', 4 => 'client', 5 => 'client_contact', 7 => 'client_phone', 14 => 'total'),
					'sortable-fields' => array(0 => '`invoices`.`id`', 1 => 2, 2 => 3, 3 => '`invoices`.`date_due`', 4 => '`clients1`.`name`', 5 => '`clients1`.`contact`', 6 => '`clients1`.`address`', 7 => '`clients1`.`phone`', 8 => '`clients1`.`email`', 9 => '`clients1`.`website`', 10 => '`clients1`.`comments`', 11 => '`invoices`.`subtotal`', 12 => '`invoices`.`discount`', 13 => '`invoices`.`tax`', 14 => '`invoices`.`total`', 15 => 16, 16 => 17, 17 => 18, 18 => 19),
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-invoices',
					'template-printable' => 'children-invoices-printable',
					'query' => "SELECT `invoices`.`id` as 'id', `invoices`.`code` as 'code', `invoices`.`status` as 'status', if(`invoices`.`date_due`,date_format(`invoices`.`date_due`,'%d/%m/%Y'),'') as 'date_due', IF(    CHAR_LENGTH(`clients1`.`name`), CONCAT_WS('',   `clients1`.`name`), '') as 'client', IF(    CHAR_LENGTH(`clients1`.`contact`), CONCAT_WS('',   `clients1`.`contact`), '') as 'client_contact', IF(    CHAR_LENGTH(`clients1`.`address`), CONCAT_WS('',   `clients1`.`address`), '') as 'client_address', IF(    CHAR_LENGTH(`clients1`.`phone`), CONCAT_WS('',   `clients1`.`phone`), '') as 'client_phone', IF(    CHAR_LENGTH(`clients1`.`email`), CONCAT_WS('',   `clients1`.`email`), '') as 'client_email', IF(    CHAR_LENGTH(`clients1`.`website`), CONCAT_WS('',   `clients1`.`website`), '') as 'client_website', IF(    CHAR_LENGTH(`clients1`.`comments`), CONCAT_WS('',   `clients1`.`comments`), '') as 'client_comments', FORMAT(`invoices`.`subtotal`, 2) as 'subtotal', `invoices`.`discount` as 'discount', FORMAT(`invoices`.`tax`, 2) as 'tax', FORMAT(`invoices`.`total`, 2) as 'total', `invoices`.`comments` as 'comments', `invoices`.`invoice_template` as 'invoice_template', `invoices`.`created` as 'created', `invoices`.`last_updated` as 'last_updated' FROM `invoices` LEFT JOIN `clients` as clients1 ON `clients1`.`id`=`invoices`.`client` "
				)
			),
			'clients' => array(   
			),
			'item_prices' => array(   
				'item' => array(   
					'parent-table' => 'items',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Price history',
					'auto-close' => true,
					'table-icon' => 'resources/table_icons/card_money.png',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => array(1 => 'Item', 2 => 'Price', 3 => 'Date'),
					'display-field-names' => array(1 => 'item', 2 => 'price', 3 => 'date'),
					'sortable-fields' => array(0 => '`item_prices`.`id`', 1 => '`items1`.`item_description`', 2 => '`item_prices`.`price`', 3 => '`item_prices`.`date`'),
					'records-per-page' => 10,
					'default-sort-by' => 3,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-item_prices',
					'template-printable' => 'children-item_prices-printable',
					'query' => "SELECT `item_prices`.`id` as 'id', IF(    CHAR_LENGTH(`items1`.`item_description`), CONCAT_WS('',   `items1`.`item_description`), '') as 'item', `item_prices`.`price` as 'price', if(`item_prices`.`date`,date_format(`item_prices`.`date`,'%d/%m/%Y'),'') as 'date' FROM `item_prices` LEFT JOIN `items` as items1 ON `items1`.`id`=`item_prices`.`item` "
				)
			),
			'invoice_items' => array(   
				'invoice' => array(   
					'parent-table' => 'invoices',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Invoice items',
					'auto-close' => true,
					'table-icon' => 'resources/table_icons/barcode.png',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => array(2 => 'Item', 3 => 'Unit price', 4 => 'Qty', 5 => 'Price'),
					'display-field-names' => array(2 => 'item', 3 => 'unit_price', 4 => 'qty', 5 => 'price'),
					'sortable-fields' => array(0 => '`invoice_items`.`id`', 1 => '`invoices1`.`code`', 2 => '`items1`.`item_description`', 3 => '`invoice_items`.`unit_price`', 4 => '`invoice_items`.`qty`', 5 => '`invoice_items`.`price`'),
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'asc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-invoice_items',
					'template-printable' => 'children-invoice_items-printable',
					'query' => "SELECT `invoice_items`.`id` as 'id', IF(    CHAR_LENGTH(`invoices1`.`code`), CONCAT_WS('',   `invoices1`.`code`), '') as 'invoice', IF(    CHAR_LENGTH(`items1`.`item_description`), CONCAT_WS('',   `items1`.`item_description`), '') as 'item', FORMAT(`invoice_items`.`unit_price`, 2) as 'unit_price', FORMAT(`invoice_items`.`qty`, 3) as 'qty', FORMAT(`invoice_items`.`price`, 2) as 'price' FROM `invoice_items` LEFT JOIN `invoices` as invoices1 ON `invoices1`.`id`=`invoice_items`.`invoice` LEFT JOIN `items` as items1 ON `items1`.`id`=`invoice_items`.`item` "
				),
				'item' => array(   
					'parent-table' => 'items',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Invoice items',
					'auto-close' => true,
					'table-icon' => 'resources/table_icons/barcode.png',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => array(2 => 'Item', 3 => 'Unit price', 4 => 'Qty', 5 => 'Price'),
					'display-field-names' => array(2 => 'item', 3 => 'unit_price', 4 => 'qty', 5 => 'price'),
					'sortable-fields' => array(0 => '`invoice_items`.`id`', 1 => '`invoices1`.`code`', 2 => '`items1`.`item_description`', 3 => '`invoice_items`.`unit_price`', 4 => '`invoice_items`.`qty`', 5 => '`invoice_items`.`price`'),
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'asc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-invoice_items',
					'template-printable' => 'children-invoice_items-printable',
					'query' => "SELECT `invoice_items`.`id` as 'id', IF(    CHAR_LENGTH(`invoices1`.`code`), CONCAT_WS('',   `invoices1`.`code`), '') as 'invoice', IF(    CHAR_LENGTH(`items1`.`item_description`), CONCAT_WS('',   `items1`.`item_description`), '') as 'item', FORMAT(`invoice_items`.`unit_price`, 2) as 'unit_price', FORMAT(`invoice_items`.`qty`, 3) as 'qty', FORMAT(`invoice_items`.`price`, 2) as 'price' FROM `invoice_items` LEFT JOIN `invoices` as invoices1 ON `invoices1`.`id`=`invoice_items`.`invoice` LEFT JOIN `items` as items1 ON `items1`.`id`=`invoice_items`.`item` "
				)
			),
			'items' => array(   
			)
		);

	/*************************************/
	/* End of configuration */


	$currDir = dirname(__FILE__);
	include("{$currDir}/defaultLang.php");
	include("{$currDir}/language.php");
	include("{$currDir}/lib.php");
	@header('Content-Type: text/html; charset=' . datalist_db_encoding);

	handle_maintenance();

	/**
	* dynamic configuration based on current user's permissions
	* $userPCConfig array is populated only with parent tables where the user has access to
	* at least one child table
	*/
	$userPCConfig = array();
	foreach($pcConfig as $pcChildTable => $ChildrenLookups){
		$permChild = getTablePermissions($pcChildTable);
		if($permChild[2]){ // user can view records of the child table, so proceed to check children lookups
			foreach($ChildrenLookups as $ChildLookupField => $ChildConfig){
				$permParent = getTablePermissions($ChildConfig['parent-table']);
				if($permParent[2]){ // user can view records of parent table
					$userPCConfig[$pcChildTable][$ChildLookupField] = $pcConfig[$pcChildTable][$ChildLookupField];
					// show add new only if configured above AND the user has insert permission
					if($permChild[1] && $pcConfig[$pcChildTable][$ChildLookupField]['display-add-new']){
						$userPCConfig[$pcChildTable][$ChildLookupField]['display-add-new'] = true;
					}else{
						$userPCConfig[$pcChildTable][$ChildLookupField]['display-add-new'] = false;
					}
				}
			}
		}
	}

	/* Receive, UTF-convert, and validate parameters */
	$ParentTable = $_REQUEST['ParentTable']; // needed only with operation=show-children, will be validated in the processing code
	$ChildTable = $_REQUEST['ChildTable'];
		if(!in_array($ChildTable, array_keys($userPCConfig))){
			/* defaults to first child table in config array if not provided */
			$ChildTable = current(array_keys($userPCConfig));
		}
		if(!$ChildTable){ die('<!-- No tables accessible to current user -->'); }
	$SelectedID = strip_tags($_REQUEST['SelectedID']);
	$ChildLookupField = $_REQUEST['ChildLookupField'];
		if(!in_array($ChildLookupField, array_keys($userPCConfig[$ChildTable]))){
			/* defaults to first lookup in current child config array if not provided */
			$ChildLookupField = current(array_keys($userPCConfig[$ChildTable]));
		}
	$Page = intval($_REQUEST['Page']);
		if($Page < 1){
			$Page = 1;
		}
	$SortBy = ($_REQUEST['SortBy'] != '' ? abs(intval($_REQUEST['SortBy'])) : false);
		if(!in_array($SortBy, array_keys($userPCConfig[$ChildTable][$ChildLookupField]['sortable-fields']), true)){
			$SortBy = $userPCConfig[$ChildTable][$ChildLookupField]['default-sort-by'];
		}
	$SortDirection = strtolower($_REQUEST['SortDirection']);
		if(!in_array($SortDirection, array('asc', 'desc'))){
			$SortDirection = $userPCConfig[$ChildTable][$ChildLookupField]['default-sort-direction'];
		}
	$Operation = strtolower($_REQUEST['Operation']);
		if(!in_array($Operation, array('get-records', 'show-children', 'get-records-printable', 'show-children-printable'))){
			$Operation = 'get-records';
		}

	/* process requested operation */
	switch($Operation){
		/************************************************/
		case 'show-children':
			/* populate HTML and JS content with children tabs */
			$tabLabels = $tabPanels = $tabLoaders = '';
			foreach($userPCConfig as $ChildTable => $childLookups){
				foreach($childLookups as $ChildLookupField => $childConfig){
					if($childConfig['parent-table'] == $ParentTable){
						$TableIcon = ($childConfig['table-icon'] ? "<img src=\"{$childConfig['table-icon']}\" border=\"0\" />" : '');
						$tabLabels .= sprintf('<li%s><a href="#panel_%s-%s" id="tab_%s-%s" data-toggle="tab">%s%s</a></li>' . "\n\t\t\t\t\t",($tabLabels ? '' : ' class="active"'), $ChildTable, $ChildLookupField, $ChildTable, $ChildLookupField, $TableIcon, $childConfig['tab-label']);
						$tabPanels .= sprintf('<div id="panel_%s-%s" class="tab-pane%s"><img src="loading.gif" align="top" />%s</div>' . "\n\t\t\t\t", $ChildTable, $ChildLookupField, ($tabPanels ? '' : ' active'), $Translation['Loading ...']);
						$tabLoaders .= sprintf('post("parent-children.php", { ChildTable: "%s", ChildLookupField: "%s", SelectedID: "%s", Page: 1, SortBy: "", SortDirection: "", Operation: "get-records" }, "panel_%s-%s");' . "\n\t\t\t\t", $ChildTable, $ChildLookupField, addslashes($SelectedID), $ChildTable, $ChildLookupField);
					}
				}
			}

			if(!$tabLabels){ die('<!-- no children of current parent table are accessible to current user -->'); }
			?>
			<div id="children-tabs">
				<ul class="nav nav-tabs">
					<?php echo $tabLabels; ?>
				</ul>
				<span id="pc-loading"></span>
			</div>
			<div class="tab-content"><?php echo $tabPanels; ?></div>

			<script>
				$j(function(){
					/* for iOS, avoid loading child tabs in modals */
					var iOS = /(iPad|iPhone|iPod)/g.test(navigator.userAgent);
					var embedded = ($j('.navbar').length == 0);
					if(iOS && embedded){
						$j('#children-tabs').next('.tab-content').remove();
						$j('#children-tabs').remove();
						return;
					}

					/* ajax loading of each tab's contents */
					<?php echo $tabLoaders; ?>
				})
			</script>
			<?php
			break;

		/************************************************/
		case 'show-children-printable':
			/* populate HTML and JS content with children buttons */
			$tabLabels = $tabPanels = $tabLoaders = '';
			foreach($userPCConfig as $ChildTable => $childLookups){
				foreach($childLookups as $ChildLookupField => $childConfig){
					if($childConfig['parent-table'] == $ParentTable){
						$TableIcon = ($childConfig['table-icon'] ? "<img src=\"{$childConfig['table-icon']}\" border=\"0\" />" : '');
						$tabLabels .= sprintf('<button type="button" class="btn btn-default" data-target="#panel_%s-%s" id="tab_%s-%s" data-toggle="collapse">%s %s</button>' . "\n\t\t\t\t\t", $ChildTable, $ChildLookupField, $ChildTable, $ChildLookupField, $TableIcon, $childConfig['tab-label']);
						$tabPanels .= sprintf('<div id="panel_%s-%s" class="collapse"><img src="loading.gif" align="top" />%s</div>' . "\n\t\t\t\t", $ChildTable, $ChildLookupField, $Translation['Loading ...']);
						$tabLoaders .= sprintf('post("parent-children.php", { ChildTable: "%s", ChildLookupField: "%s", SelectedID: "%s", Page: 1, SortBy: "", SortDirection: "", Operation: "get-records-printable" }, "panel_%s-%s");' . "\n\t\t\t\t", $ChildTable, $ChildLookupField, addslashes($SelectedID), $ChildTable, $ChildLookupField);
					}
				}
			}

			if(!$tabLabels){ die('<!-- no children of current parent table are accessible to current user -->'); }
			?>
			<div id="children-tabs" class="hidden-print">
				<div class="btn-group btn-group-lg">
					<?php echo $tabLabels; ?>
				</div>
				<span id="pc-loading"></span>
			</div>
			<div class="vspacer-lg"><?php echo $tabPanels; ?></div>

			<script>
				$j(function(){
					/* for iOS, avoid loading child tabs in modals */
					var iOS = /(iPad|iPhone|iPod)/g.test(navigator.userAgent);
					var embedded = ($j('.navbar').length == 0);
					if(iOS && embedded){
						$j('#children-tabs').next('.tab-content').remove();
						$j('#children-tabs').remove();
						return;
					}

					/* ajax loading of each tab's contents */
					<?php echo $tabLoaders; ?>
				})
			</script>
			<?php
			break;

		/************************************************/
		case 'get-records-printable':
		default: /* default is 'get-records' */

			if($Operation == 'get-records-printable'){
				$userPCConfig[$ChildTable][$ChildLookupField]['records-per-page'] = 2000;
			}

			// build the user permissions limiter
			$permissionsWhere = $permissionsJoin = '';
			$permChild = getTablePermissions($ChildTable);
			if($permChild[2] == 1){ // user can view only his own records
				$permissionsWhere = "`$ChildTable`.`{$userPCConfig[$ChildTable][$ChildLookupField]['child-primary-key']}`=`membership_userrecords`.`pkValue` AND `membership_userrecords`.`tableName`='$ChildTable' AND LCASE(`membership_userrecords`.`memberID`)='".getLoggedMemberID()."'";
			}elseif($permChild[2] == 2){ // user can view only his group's records
				$permissionsWhere = "`$ChildTable`.`{$userPCConfig[$ChildTable][$ChildLookupField]['child-primary-key']}`=`membership_userrecords`.`pkValue` AND `membership_userrecords`.`tableName`='$ChildTable' AND `membership_userrecords`.`groupID`='".getLoggedGroupID()."'";
			}elseif($permChild[2] == 3){ // user can view all records
				/* that's the only case remaining ... no need to modify the query in this case */
			}
			$permissionsJoin = ($permissionsWhere ? ", `membership_userrecords`" : '');

			// build the count query
			$forcedWhere = $userPCConfig[$ChildTable][$ChildLookupField]['forced-where'];
			$query = 
				preg_replace('/^select .* from /i', 'SELECT count(1) FROM ', $userPCConfig[$ChildTable][$ChildLookupField]['query']) .
				$permissionsJoin . " WHERE " .
				($permissionsWhere ? "( $permissionsWhere )" : "( 1=1 )") . " AND " .
				($forcedWhere ? "( $forcedWhere )" : "( 2=2 )") . " AND " .
				"`$ChildTable`.`$ChildLookupField`='" . makeSafe($SelectedID) . "'";
			$totalMatches = sqlValue($query);

			// make sure $Page is <= max pages
			$maxPage = ceil($totalMatches / $userPCConfig[$ChildTable][$ChildLookupField]['records-per-page']);
			if($Page > $maxPage){ $Page = $maxPage; }

			// initiate output data array
			$data = array(
				'config' => $userPCConfig[$ChildTable][$ChildLookupField],
				'parameters' => array(
					'ChildTable' => $ChildTable,
					'ChildLookupField' => $ChildLookupField,
					'SelectedID' => $SelectedID,
					'Page' => $Page,
					'SortBy' => $SortBy,
					'SortDirection' => $SortDirection,
					'Operation' => $Operation
				),
				'records' => array(),
				'totalMatches' => $totalMatches
			);

			// build the data query
			if($totalMatches){ // if we have at least one record, proceed with fetching data
				$startRecord = $userPCConfig[$ChildTable][$ChildLookupField]['records-per-page'] * ($Page - 1);
				$data['query'] = 
					$userPCConfig[$ChildTable][$ChildLookupField]['query'] .
					$permissionsJoin . " WHERE " .
					($permissionsWhere ? "( $permissionsWhere )" : "( 1=1 )") . " AND " .
					($forcedWhere ? "( $forcedWhere )" : "( 2=2 )") . " AND " .
					"`$ChildTable`.`$ChildLookupField`='" . makeSafe($SelectedID) . "'" . 
					($SortBy !== false && $userPCConfig[$ChildTable][$ChildLookupField]['sortable-fields'][$SortBy] ? " ORDER BY {$userPCConfig[$ChildTable][$ChildLookupField]['sortable-fields'][$SortBy]} $SortDirection" : '') .
					" LIMIT $startRecord, {$userPCConfig[$ChildTable][$ChildLookupField]['records-per-page']}";
				$res = sql($data['query'], $eo);
				while($row = db_fetch_row($res)){
					$data['records'][$row[$userPCConfig[$ChildTable][$ChildLookupField]['child-primary-key-index']]] = $row;
				}
			}else{ // if no matching records
				$startRecord = 0;
			}

			if($Operation == 'get-records-printable'){
				$response = loadView($userPCConfig[$ChildTable][$ChildLookupField]['template-printable'], $data);
			}else{
				$response = loadView($userPCConfig[$ChildTable][$ChildLookupField]['template'], $data);
			}

			// change name space to ensure uniqueness
			$uniqueNameSpace = $ChildTable.ucfirst($ChildLookupField).'GetRecords';
			echo str_replace("{$ChildTable}GetChildrenRecordsList", $uniqueNameSpace, $response);
		/************************************************/
	}
