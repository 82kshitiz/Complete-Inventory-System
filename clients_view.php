<?php

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/clients.php");
	include("$currDir/clients_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('clients');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "clients";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`clients`.`id`" => "id",
		"`clients`.`name`" => "name",
		"`clients`.`contact`" => "contact",
		"`clients`.`title`" => "title",
		"`clients`.`address`" => "address",
		"`clients`.`city`" => "city",
		"`clients`.`country`" => "country",
		"CONCAT_WS('-', LEFT(`clients`.`phone`,3), MID(`clients`.`phone`,4,3), RIGHT(`clients`.`phone`,4))" => "phone",
		"`clients`.`email`" => "email",
		"`clients`.`website`" => "website",
		"`clients`.`comments`" => "comments"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`clients`.`id`',
		2 => 2,
		3 => 3,
		4 => 4,
		5 => 5,
		6 => 6,
		7 => 7,
		8 => 8,
		9 => 9,
		10 => 10,
		11 => 11
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`clients`.`id`" => "id",
		"`clients`.`name`" => "name",
		"`clients`.`contact`" => "contact",
		"`clients`.`title`" => "title",
		"`clients`.`address`" => "address",
		"`clients`.`city`" => "city",
		"`clients`.`country`" => "country",
		"CONCAT_WS('-', LEFT(`clients`.`phone`,3), MID(`clients`.`phone`,4,3), RIGHT(`clients`.`phone`,4))" => "phone",
		"`clients`.`email`" => "email",
		"`clients`.`website`" => "website",
		"`clients`.`comments`" => "comments"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`clients`.`id`" => "ID",
		"`clients`.`name`" => "Name",
		"`clients`.`contact`" => "Contact",
		"`clients`.`title`" => "Title",
		"`clients`.`address`" => "Address",
		"`clients`.`city`" => "City",
		"`clients`.`country`" => "Country",
		"`clients`.`phone`" => "Phone",
		"`clients`.`email`" => "Email",
		"`clients`.`website`" => "Website",
		"`clients`.`comments`" => "Comments"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`clients`.`id`" => "id",
		"`clients`.`name`" => "name",
		"`clients`.`contact`" => "contact",
		"`clients`.`title`" => "title",
		"`clients`.`address`" => "address",
		"`clients`.`city`" => "city",
		"`clients`.`country`" => "country",
		"CONCAT_WS('-', LEFT(`clients`.`phone`,3), MID(`clients`.`phone`,4,3), RIGHT(`clients`.`phone`,4))" => "phone",
		"`clients`.`email`" => "email",
		"`clients`.`website`" => "website",
		"`clients`.`comments`" => "comments"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array();

	$x->QueryFrom = "`clients` ";
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
	$x->ScriptFileName = "clients_view.php";
	$x->RedirectAfterInsert = "clients_view.php?SelectedID=#ID#";
	$x->TableTitle = "Clients";
	$x->TableIcon = "resources/table_icons/administrator.png";
	$x->PrimaryKey = "`clients`.`id`";
	$x->DefaultSortField = '2';
	$x->DefaultSortDirection = 'asc';

	$x->ColWidth   = array(  250, 200, 150, 150, 150, 150, 150, 50, 50);
	$x->ColCaption = array("Name", "Contact", "Title", "Address", "City", "Country", "Phone", "Email", "Website");
	$x->ColFieldName = array('name', 'contact', 'title', 'address', 'city', 'country', 'phone', 'email', 'website');
	$x->ColNumber  = array(2, 3, 4, 5, 6, 7, 8, 9, 10);

	// template paths below are based on the app main directory
	$x->Template = 'templates/clients_templateTV.html';
	$x->SelectedTemplate = 'templates/clients_templateTVS.html';
	$x->TemplateDV = 'templates/clients_templateDV.html';
	$x->TemplateDVP = 'templates/clients_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `clients`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='clients' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `clients`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='clients' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`clients`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: clients_init
	$render=TRUE;
	if(function_exists('clients_init')){
		$args=array();
		$render=clients_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: clients_header
	$headerCode='';
	if(function_exists('clients_header')){
		$args=array();
		$headerCode=clients_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: clients_footer
	$footerCode='';
	if(function_exists('clients_footer')){
		$args=array();
		$footerCode=clients_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>
