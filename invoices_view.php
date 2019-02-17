<?php


$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/invoices.php");
	include("$currDir/invoices_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('invoices');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "invoices";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`invoices`.`id`" => "id",
		"`invoices`.`code`" => "code",
		"`invoices`.`status`" => "status",
		"if(`invoices`.`date_due`,date_format(`invoices`.`date_due`,'%d/%m/%Y'),'')" => "date_due",
		"IF(    CHAR_LENGTH(`clients1`.`name`), CONCAT_WS('',   `clients1`.`name`), '') /* Client */" => "client",
		"IF(    CHAR_LENGTH(`clients1`.`contact`), CONCAT_WS('',   `clients1`.`contact`), '') /* Client contact */" => "client_contact",
		"IF(    CHAR_LENGTH(`clients1`.`address`), CONCAT_WS('',   `clients1`.`address`), '') /* Client address */" => "client_address",
		"IF(    CHAR_LENGTH(`clients1`.`phone`), CONCAT_WS('',   `clients1`.`phone`), '') /* Client phone */" => "client_phone",
		"IF(    CHAR_LENGTH(`clients1`.`email`), CONCAT_WS('',   `clients1`.`email`), '') /* Client email */" => "client_email",
		"IF(    CHAR_LENGTH(`clients1`.`website`), CONCAT_WS('',   `clients1`.`website`), '') /* Client website */" => "client_website",
		"IF(    CHAR_LENGTH(`clients1`.`comments`), CONCAT_WS('',   `clients1`.`comments`), '') /* Client comments */" => "client_comments",
		"FORMAT(`invoices`.`subtotal`, 2)" => "subtotal",
		"`invoices`.`discount`" => "discount",
		"FORMAT(`invoices`.`tax`, 2)" => "tax",
		"FORMAT(`invoices`.`total`, 2)" => "total",
		"`invoices`.`comments`" => "comments",
		"`invoices`.`invoice_template`" => "invoice_template",
		"`invoices`.`created`" => "created",
		"`invoices`.`last_updated`" => "last_updated"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`invoices`.`id`',
		2 => 2,
		3 => 3,
		4 => '`invoices`.`date_due`',
		5 => '`clients1`.`name`',
		6 => '`clients1`.`contact`',
		7 => '`clients1`.`address`',
		8 => '`clients1`.`phone`',
		9 => '`clients1`.`email`',
		10 => '`clients1`.`website`',
		11 => '`clients1`.`comments`',
		12 => '`invoices`.`subtotal`',
		13 => '`invoices`.`discount`',
		14 => '`invoices`.`tax`',
		15 => '`invoices`.`total`',
		16 => 16,
		17 => 17,
		18 => 18,
		19 => 19
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`invoices`.`id`" => "id",
		"`invoices`.`code`" => "code",
		"`invoices`.`status`" => "status",
		"if(`invoices`.`date_due`,date_format(`invoices`.`date_due`,'%d/%m/%Y'),'')" => "date_due",
		"IF(    CHAR_LENGTH(`clients1`.`name`), CONCAT_WS('',   `clients1`.`name`), '') /* Client */" => "client",
		"IF(    CHAR_LENGTH(`clients1`.`contact`), CONCAT_WS('',   `clients1`.`contact`), '') /* Client contact */" => "client_contact",
		"IF(    CHAR_LENGTH(`clients1`.`address`), CONCAT_WS('',   `clients1`.`address`), '') /* Client address */" => "client_address",
		"IF(    CHAR_LENGTH(`clients1`.`phone`), CONCAT_WS('',   `clients1`.`phone`), '') /* Client phone */" => "client_phone",
		"IF(    CHAR_LENGTH(`clients1`.`email`), CONCAT_WS('',   `clients1`.`email`), '') /* Client email */" => "client_email",
		"IF(    CHAR_LENGTH(`clients1`.`website`), CONCAT_WS('',   `clients1`.`website`), '') /* Client website */" => "client_website",
		"IF(    CHAR_LENGTH(`clients1`.`comments`), CONCAT_WS('',   `clients1`.`comments`), '') /* Client comments */" => "client_comments",
		"FORMAT(`invoices`.`subtotal`, 2)" => "subtotal",
		"`invoices`.`discount`" => "discount",
		"FORMAT(`invoices`.`tax`, 2)" => "tax",
		"FORMAT(`invoices`.`total`, 2)" => "total",
		"`invoices`.`comments`" => "comments",
		"`invoices`.`invoice_template`" => "invoice_template",
		"`invoices`.`created`" => "created",
		"`invoices`.`last_updated`" => "last_updated"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`invoices`.`id`" => "ID",
		"`invoices`.`code`" => "Code",
		"`invoices`.`status`" => "Status",
		"`invoices`.`date_due`" => "Date due",
		"IF(    CHAR_LENGTH(`clients1`.`name`), CONCAT_WS('',   `clients1`.`name`), '') /* Client */" => "Client",
		"IF(    CHAR_LENGTH(`clients1`.`contact`), CONCAT_WS('',   `clients1`.`contact`), '') /* Client contact */" => "Client contact",
		"IF(    CHAR_LENGTH(`clients1`.`address`), CONCAT_WS('',   `clients1`.`address`), '') /* Client address */" => "Client address",
		"IF(    CHAR_LENGTH(`clients1`.`phone`), CONCAT_WS('',   `clients1`.`phone`), '') /* Client phone */" => "Client phone",
		"IF(    CHAR_LENGTH(`clients1`.`email`), CONCAT_WS('',   `clients1`.`email`), '') /* Client email */" => "Client email",
		"IF(    CHAR_LENGTH(`clients1`.`website`), CONCAT_WS('',   `clients1`.`website`), '') /* Client website */" => "Client website",
		"IF(    CHAR_LENGTH(`clients1`.`comments`), CONCAT_WS('',   `clients1`.`comments`), '') /* Client comments */" => "Client comments",
		"`invoices`.`subtotal`" => "Subtotal",
		"`invoices`.`discount`" => "Discount %",
		"`invoices`.`tax`" => "Tax %",
		"`invoices`.`total`" => "Total",
		"`invoices`.`comments`" => "Comments",
		"`invoices`.`invoice_template`" => "Invoice template",
		"`invoices`.`created`" => "Created",
		"`invoices`.`last_updated`" => "Last updated"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`invoices`.`id`" => "id",
		"`invoices`.`code`" => "code",
		"`invoices`.`status`" => "status",
		"if(`invoices`.`date_due`,date_format(`invoices`.`date_due`,'%d/%m/%Y'),'')" => "date_due",
		"IF(    CHAR_LENGTH(`clients1`.`name`), CONCAT_WS('',   `clients1`.`name`), '') /* Client */" => "client",
		"IF(    CHAR_LENGTH(`clients1`.`contact`), CONCAT_WS('',   `clients1`.`contact`), '') /* Client contact */" => "client_contact",
		"IF(    CHAR_LENGTH(`clients1`.`address`), CONCAT_WS('',   `clients1`.`address`), '') /* Client address */" => "client_address",
		"IF(    CHAR_LENGTH(`clients1`.`phone`), CONCAT_WS('',   `clients1`.`phone`), '') /* Client phone */" => "client_phone",
		"IF(    CHAR_LENGTH(`clients1`.`email`), CONCAT_WS('',   `clients1`.`email`), '') /* Client email */" => "client_email",
		"IF(    CHAR_LENGTH(`clients1`.`website`), CONCAT_WS('',   `clients1`.`website`), '') /* Client website */" => "client_website",
		"IF(    CHAR_LENGTH(`clients1`.`comments`), CONCAT_WS('',   `clients1`.`comments`), '') /* Client comments */" => "client_comments",
		"FORMAT(`invoices`.`subtotal`, 2)" => "subtotal",
		"`invoices`.`discount`" => "discount",
		"FORMAT(`invoices`.`tax`, 2)" => "tax",
		"FORMAT(`invoices`.`total`, 2)" => "total",
		"`invoices`.`comments`" => "comments",
		"`invoices`.`invoice_template`" => "invoice_template",
		"`invoices`.`created`" => "created",
		"`invoices`.`last_updated`" => "last_updated"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array(  'client' => 'Client');

	$x->QueryFrom = "`invoices` LEFT JOIN `clients` as clients1 ON `clients1`.`id`=`invoices`.`client` ";
	$x->QueryWhere = '';
	$x->QueryOrder = '';

	$x->AllowSelection = 1;
	$x->HideTableView = ($perm[2]==0 ? 1 : 0);
	$x->AllowDelete = $perm[4];
	$x->AllowMassDelete = true;
	$x->AllowInsert = $perm[1];
	$x->AllowUpdate = $perm[3];
	$x->SeparateDV = 1;
	$x->AllowDeleteOfParents = 0;
	$x->AllowFilters = 1;
	$x->AllowSavingFilters = 1;
	$x->AllowSorting = 1;
	$x->AllowNavigation = 1;
	$x->AllowPrinting = 1;
	$x->AllowCSV = 1;
	$x->RecordsPerPage = 10;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation["quick search"];
	$x->ScriptFileName = "invoices_view.php";
	$x->RedirectAfterInsert = "invoices_view.php?SelectedID=#ID#";
	$x->TableTitle = "Invoices";
	$x->TableIcon = "resources/table_icons/attributes_display.png";
	$x->PrimaryKey = "`invoices`.`id`";
	$x->DefaultSortField = '1';
	$x->DefaultSortDirection = 'desc';

	$x->ColWidth   = array(  60, 70, 100, 250, 200, 100, 70);
	$x->ColCaption = array("Code", "Status", "Date due", "Client", "Client contact", "Client phone", "Total");
	$x->ColFieldName = array('code', 'status', 'date_due', 'client', 'client_contact', 'client_phone', 'total');
	$x->ColNumber  = array(2, 3, 4, 5, 6, 8, 15);

	// template paths below are based on the app main directory
	$x->Template = 'templates/invoices_templateTV.html';
	$x->SelectedTemplate = 'templates/invoices_templateTVS.html';
	$x->TemplateDV = 'templates/invoices_templateDV.html';
	$x->TemplateDVP = 'templates/invoices_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `invoices`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='invoices' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `invoices`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='invoices' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`invoices`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: invoices_init
	$render=TRUE;
	if(function_exists('invoices_init')){
		$args=array();
		$render=invoices_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// column sums
	if(strpos($x->HTML, '<!-- tv data below -->')){
		// if printing multi-selection TV, calculate the sum only for the selected records
		if(isset($_REQUEST['Print_x']) && is_array($_REQUEST['record_selector'])){
			$QueryWhere = '';
			foreach($_REQUEST['record_selector'] as $id){   // get selected records
				if($id != '') $QueryWhere .= "'" . makeSafe($id) . "',";
			}
			if($QueryWhere != ''){
				$QueryWhere = 'where `invoices`.`id` in ('.substr($QueryWhere, 0, -1).')';
			}else{ // if no selected records, write the where clause to return an empty result
				$QueryWhere = 'where 1=0';
			}
		}else{
			$QueryWhere = $x->QueryWhere;
		}

		$sumQuery = "select FORMAT(sum(`invoices`.`total`), 2) from {$x->QueryFrom} {$QueryWhere}";
		$res = sql($sumQuery, $eo);
		if($row = db_fetch_row($res)){
			$sumRow = '<tr class="success">';
			if(!isset($_REQUEST['Print_x'])) $sumRow .= '<td class="text-center"><strong>&sum;</strong></td>';
			$sumRow .= '<td class="invoices-code"></td>';
			$sumRow .= '<td class="invoices-status"></td>';
			$sumRow .= '<td class="invoices-date_due"></td>';
			$sumRow .= '<td class="invoices-client"></td>';
			$sumRow .= '<td class="invoices-client_contact"></td>';
			$sumRow .= '<td class="invoices-client_phone"></td>';
			$sumRow .= "<td class=\"invoices-total text-right\">{$row[0]}</td>";
			$sumRow .= '</tr>';

			$x->HTML = str_replace('<!-- tv data below -->', '', $x->HTML);
			$x->HTML = str_replace('<!-- tv data above -->', $sumRow, $x->HTML);
		}
	}

	// hook: invoices_header
	$headerCode='';
	if(function_exists('invoices_header')){
		$args=array();
		$headerCode=invoices_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: invoices_footer
	$footerCode='';
	if(function_exists('invoices_footer')){
		$args=array();
		$footerCode=invoices_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>
