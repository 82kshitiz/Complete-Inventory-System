<?php

// Data functions (insert, update, delete, form) for table item_prices


function item_prices_insert(){
	global $Translation;

	// mm: can member insert record?
	$arrPerm=getTablePermissions('item_prices');
	if(!$arrPerm[1]){
		return false;
	}

	$data['item'] = makeSafe($_REQUEST['item']);
		if($data['item'] == empty_lookup_value){ $data['item'] = ''; }
	$data['price'] = makeSafe($_REQUEST['price']);
		if($data['price'] == empty_lookup_value){ $data['price'] = ''; }
	$data['date'] = intval($_REQUEST['dateYear']) . '-' . intval($_REQUEST['dateMonth']) . '-' . intval($_REQUEST['dateDay']);
	$data['date'] = parseMySQLDate($data['date'], '1');
	if($data['price'] == '') $data['price'] = "0.00";

	// hook: item_prices_before_insert
	if(function_exists('item_prices_before_insert')){
		$args=array();
		if(!item_prices_before_insert($data, getMemberInfo(), $args)){ return false; }
	}

	$o = array('silentErrors' => true);
	sql('insert into `item_prices` set       `item`=' . (($data['item'] !== '' && $data['item'] !== NULL) ? "'{$data['item']}'" : 'NULL') . ', `price`=' . (($data['price'] !== '' && $data['price'] !== NULL) ? "'{$data['price']}'" : 'NULL') . ', `date`=' . (($data['date'] !== '' && $data['date'] !== NULL) ? "'{$data['date']}'" : 'NULL'), $o);
	if($o['error']!=''){
		echo $o['error'];
		echo "<a href=\"item_prices_view.php?addNew_x=1\">{$Translation['< back']}</a>";
		exit;
	}

	$recID = db_insert_id(db_link());

	// hook: item_prices_after_insert
	if(function_exists('item_prices_after_insert')){
		$res = sql("select * from `item_prices` where `id`='" . makeSafe($recID, false) . "' limit 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = makeSafe($recID, false);
		$args=array();
		if(!item_prices_after_insert($data, getMemberInfo(), $args)){ return $recID; }
	}

	// mm: save ownership data
	set_record_owner('item_prices', $recID, getLoggedMemberID());

	return $recID;
}

function item_prices_delete($selected_id, $AllowDeleteOfParents=false, $skipChecks=false){
	// insure referential integrity ...
	global $Translation;
	$selected_id=makeSafe($selected_id);

	// mm: can member delete record?
	$arrPerm=getTablePermissions('item_prices');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='item_prices' and pkValue='$selected_id'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='item_prices' and pkValue='$selected_id'");
	if(($arrPerm[4]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[4]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[4]==3){ // allow delete?
		// delete allowed, so continue ...
	}else{
		return $Translation['You don\'t have enough permissions to delete this record'];
	}

	// hook: item_prices_before_delete
	if(function_exists('item_prices_before_delete')){
		$args=array();
		if(!item_prices_before_delete($selected_id, $skipChecks, getMemberInfo(), $args))
			return $Translation['Couldn\'t delete this record'];
	}

	sql("delete from `item_prices` where `id`='$selected_id'", $eo);

	// hook: item_prices_after_delete
	if(function_exists('item_prices_after_delete')){
		$args=array();
		item_prices_after_delete($selected_id, getMemberInfo(), $args);
	}

	// mm: delete ownership data
	sql("delete from membership_userrecords where tableName='item_prices' and pkValue='$selected_id'", $eo);
}

function item_prices_update($selected_id){
	global $Translation;

	// mm: can member edit record?
	$arrPerm=getTablePermissions('item_prices');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='item_prices' and pkValue='".makeSafe($selected_id)."'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='item_prices' and pkValue='".makeSafe($selected_id)."'");
	if(($arrPerm[3]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[3]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[3]==3){ // allow update?
		// update allowed, so continue ...
	}else{
		return false;
	}

	$data['item'] = makeSafe($_REQUEST['item']);
		if($data['item'] == empty_lookup_value){ $data['item'] = ''; }
	$data['price'] = makeSafe($_REQUEST['price']);
		if($data['price'] == empty_lookup_value){ $data['price'] = ''; }
	$data['date'] = intval($_REQUEST['dateYear']) . '-' . intval($_REQUEST['dateMonth']) . '-' . intval($_REQUEST['dateDay']);
	$data['date'] = parseMySQLDate($data['date'], '1');
	$data['selectedID']=makeSafe($selected_id);

	// hook: item_prices_before_update
	if(function_exists('item_prices_before_update')){
		$args=array();
		if(!item_prices_before_update($data, getMemberInfo(), $args)){ return false; }
	}

	$o=array('silentErrors' => true);
	sql('update `item_prices` set       `item`=' . (($data['item'] !== '' && $data['item'] !== NULL) ? "'{$data['item']}'" : 'NULL') . ', `price`=' . (($data['price'] !== '' && $data['price'] !== NULL) ? "'{$data['price']}'" : 'NULL') . ', `date`=' . (($data['date'] !== '' && $data['date'] !== NULL) ? "'{$data['date']}'" : 'NULL') . " where `id`='".makeSafe($selected_id)."'", $o);
	if($o['error']!=''){
		echo $o['error'];
		echo '<a href="item_prices_view.php?SelectedID='.urlencode($selected_id)."\">{$Translation['< back']}</a>";
		exit;
	}


	// hook: item_prices_after_update
	if(function_exists('item_prices_after_update')){
		$res = sql("SELECT * FROM `item_prices` WHERE `id`='{$data['selectedID']}' LIMIT 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = $data['id'];
		$args = array();
		if(!item_prices_after_update($data, getMemberInfo(), $args)){ return; }
	}

	// mm: update ownership data
	sql("update membership_userrecords set dateUpdated='".time()."' where tableName='item_prices' and pkValue='".makeSafe($selected_id)."'", $eo);

}

function item_prices_form($selected_id = '', $AllowUpdate = 1, $AllowInsert = 1, $AllowDelete = 1, $ShowCancel = 0, $TemplateDV = '', $TemplateDVP = ''){
	// function to return an editable form for a table records
	// and fill it with data of record whose ID is $selected_id. If $selected_id
	// is empty, an empty form is shown, with only an 'Add New'
	// button displayed.

	global $Translation;

	// mm: get table permissions
	$arrPerm=getTablePermissions('item_prices');
	if(!$arrPerm[1] && $selected_id==''){ return ''; }
	$AllowInsert = ($arrPerm[1] ? true : false);
	// print preview?
	$dvprint = false;
	if($selected_id && $_REQUEST['dvprint_x'] != ''){
		$dvprint = true;
	}

	$filterer_item = thisOr(undo_magic_quotes($_REQUEST['filterer_item']), '');

	// populate filterers, starting from children to grand-parents

	// unique random identifier
	$rnd1 = ($dvprint ? rand(1000000, 9999999) : '');
	// combobox: item
	$combo_item = new DataCombo;
	// combobox: date
	$combo_date = new DateCombo;
	$combo_date->DateFormat = "dmy";
	$combo_date->MinYear = 1900;
	$combo_date->MaxYear = 2100;
	$combo_date->DefaultDate = parseMySQLDate('1', '1');
	$combo_date->MonthNames = $Translation['month names'];
	$combo_date->NamePrefix = 'date';

	if($selected_id){
		// mm: check member permissions
		if(!$arrPerm[2]){
			return "";
		}
		// mm: who is the owner?
		$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='item_prices' and pkValue='".makeSafe($selected_id)."'");
		$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='item_prices' and pkValue='".makeSafe($selected_id)."'");
		if($arrPerm[2]==1 && getLoggedMemberID()!=$ownerMemberID){
			return "";
		}
		if($arrPerm[2]==2 && getLoggedGroupID()!=$ownerGroupID){
			return "";
		}

		// can edit?
		if(($arrPerm[3]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[3]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[3]==3){
			$AllowUpdate=1;
		}else{
			$AllowUpdate=0;
		}

		$res = sql("select * from `item_prices` where `id`='".makeSafe($selected_id)."'", $eo);
		if(!($row = db_fetch_array($res))){
			return error_message($Translation['No records found'], 'item_prices_view.php', false);
		}
		$urow = $row; /* unsanitized data */
		$hc = new CI_Input();
		$row = $hc->xss_clean($row); /* sanitize data */
		$combo_item->SelectedData = $row['item'];
		$combo_date->DefaultDate = $row['date'];
	}else{
		$combo_item->SelectedData = $filterer_item;
	}
	$combo_item->HTML = '<span id="item-container' . $rnd1 . '"></span><input type="hidden" name="item" id="item' . $rnd1 . '" value="' . html_attr($combo_item->SelectedData) . '">';
	$combo_item->MatchText = '<span id="item-container-readonly' . $rnd1 . '"></span><input type="hidden" name="item" id="item' . $rnd1 . '" value="' . html_attr($combo_item->SelectedData) . '">';

	ob_start();
	?>

	<script>
		// initial lookup values
		AppGini.current_item__RAND__ = { text: "", value: "<?php echo addslashes($selected_id ? $urow['item'] : $filterer_item); ?>"};

		jQuery(function() {
			setTimeout(function(){
				if(typeof(item_reload__RAND__) == 'function') item_reload__RAND__();
			}, 10); /* we need to slightly delay client-side execution of the above code to allow AppGini.ajaxCache to work */
		});
		function item_reload__RAND__(){
		<?php if(($AllowUpdate || $AllowInsert) && !$dvprint){ ?>

			$j("#item-container__RAND__").select2({
				/* initial default value */
				initSelection: function(e, c){
					$j.ajax({
						url: 'ajax_combo.php',
						dataType: 'json',
						data: { id: AppGini.current_item__RAND__.value, t: 'item_prices', f: 'item' },
						success: function(resp){
							c({
								id: resp.results[0].id,
								text: resp.results[0].text
							});
							$j('[name="item"]').val(resp.results[0].id);
							$j('[id=item-container-readonly__RAND__]').html('<span id="item-match-text">' + resp.results[0].text + '</span>');
							if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=items_view_parent]').hide(); }else{ $j('.btn[id=items_view_parent]').show(); }


							if(typeof(item_update_autofills__RAND__) == 'function') item_update_autofills__RAND__();
						}
					});
				},
				width: '100%',
				formatNoMatches: function(term){ /* */ return '<?php echo addslashes($Translation['No matches found!']); ?>'; },
				minimumResultsForSearch: 10,
				loadMorePadding: 200,
				ajax: {
					url: 'ajax_combo.php',
					dataType: 'json',
					cache: true,
					data: function(term, page){ /* */ return { s: term, p: page, t: 'item_prices', f: 'item' }; },
					results: function(resp, page){ /* */ return resp; }
				},
				escapeMarkup: function(str){ /* */ return str; }
			}).on('change', function(e){
				AppGini.current_item__RAND__.value = e.added.id;
				AppGini.current_item__RAND__.text = e.added.text;
				$j('[name="item"]').val(e.added.id);
				if(e.added.id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=items_view_parent]').hide(); }else{ $j('.btn[id=items_view_parent]').show(); }


				if(typeof(item_update_autofills__RAND__) == 'function') item_update_autofills__RAND__();
			});

			if(!$j("#item-container__RAND__").length){
				$j.ajax({
					url: 'ajax_combo.php',
					dataType: 'json',
					data: { id: AppGini.current_item__RAND__.value, t: 'item_prices', f: 'item' },
					success: function(resp){
						$j('[name="item"]').val(resp.results[0].id);
						$j('[id=item-container-readonly__RAND__]').html('<span id="item-match-text">' + resp.results[0].text + '</span>');
						if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=items_view_parent]').hide(); }else{ $j('.btn[id=items_view_parent]').show(); }

						if(typeof(item_update_autofills__RAND__) == 'function') item_update_autofills__RAND__();
					}
				});
			}

		<?php }else{ ?>

			$j.ajax({
				url: 'ajax_combo.php',
				dataType: 'json',
				data: { id: AppGini.current_item__RAND__.value, t: 'item_prices', f: 'item' },
				success: function(resp){
					$j('[id=item-container__RAND__], [id=item-container-readonly__RAND__]').html('<span id="item-match-text">' + resp.results[0].text + '</span>');
					if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=items_view_parent]').hide(); }else{ $j('.btn[id=items_view_parent]').show(); }

					if(typeof(item_update_autofills__RAND__) == 'function') item_update_autofills__RAND__();
				}
			});
		<?php } ?>

		}
	</script>
	<?php

	$lookups = str_replace('__RAND__', $rnd1, ob_get_contents());
	ob_end_clean();


	// code for template based detail view forms

	// open the detail view template
	if($dvprint){
		$template_file = is_file("./{$TemplateDVP}") ? "./{$TemplateDVP}" : './templates/item_prices_templateDVP.html';
		$templateCode = @file_get_contents($template_file);
	}else{
		$template_file = is_file("./{$TemplateDV}") ? "./{$TemplateDV}" : './templates/item_prices_templateDV.html';
		$templateCode = @file_get_contents($template_file);
	}

	// process form title
	$templateCode = str_replace('<%%DETAIL_VIEW_TITLE%%>', 'Item price details', $templateCode);
	$templateCode = str_replace('<%%RND1%%>', $rnd1, $templateCode);
	$templateCode = str_replace('<%%EMBEDDED%%>', ($_REQUEST['Embedded'] ? 'Embedded=1' : ''), $templateCode);
	// process buttons
	if($arrPerm[1] && !$selected_id){ // allow insert and no record selected?
		if(!$selected_id) $templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-success" id="insert" name="insert_x" value="1" onclick="return item_prices_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save New'] . '</button>', $templateCode);
		$templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="insert" name="insert_x" value="1" onclick="return item_prices_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save As Copy'] . '</button>', $templateCode);
	}else{
		$templateCode = str_replace('<%%INSERT_BUTTON%%>', '', $templateCode);
	}

	// 'Back' button action
	if($_REQUEST['Embedded']){
		$backAction = 'AppGini.closeParentModal(); return false;';
	}else{
		$backAction = '$j(\'form\').eq(0).attr(\'novalidate\', \'novalidate\'); document.myform.reset(); return true;';
	}

	if($selected_id){
		if(!$_REQUEST['Embedded']) $templateCode = str_replace('<%%DVPRINT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="dvprint" name="dvprint_x" value="1" onclick="$$(\'form\')[0].writeAttribute(\'novalidate\', \'novalidate\'); document.myform.reset(); return true;" title="' . html_attr($Translation['Print Preview']) . '"><i class="glyphicon glyphicon-print"></i> ' . $Translation['Print Preview'] . '</button>', $templateCode);
		if($AllowUpdate){
			$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '<button type="submit" class="btn btn-success btn-lg" id="update" name="update_x" value="1" onclick="return item_prices_validateData();" title="' . html_attr($Translation['Save Changes']) . '"><i class="glyphicon glyphicon-ok"></i> ' . $Translation['Save Changes'] . '</button>', $templateCode);
		}else{
			$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '', $templateCode);
		}
		if(($arrPerm[4]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[4]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[4]==3){ // allow delete?
			$templateCode = str_replace('<%%DELETE_BUTTON%%>', '<button type="submit" class="btn btn-danger" id="delete" name="delete_x" value="1" onclick="return confirm(\'' . $Translation['are you sure?'] . '\');" title="' . html_attr($Translation['Delete']) . '"><i class="glyphicon glyphicon-trash"></i> ' . $Translation['Delete'] . '</button>', $templateCode);
		}else{
			$templateCode = str_replace('<%%DELETE_BUTTON%%>', '', $templateCode);
		}
		$templateCode = str_replace('<%%DESELECT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="deselect" name="deselect_x" value="1" onclick="' . $backAction . '" title="' . html_attr($Translation['Back']) . '"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['Back'] . '</button>', $templateCode);
	}else{
		$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '', $templateCode);
		$templateCode = str_replace('<%%DELETE_BUTTON%%>', '', $templateCode);
		$templateCode = str_replace('<%%DESELECT_BUTTON%%>', ($ShowCancel ? '<button type="submit" class="btn btn-default" id="deselect" name="deselect_x" value="1" onclick="' . $backAction . '" title="' . html_attr($Translation['Back']) . '"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['Back'] . '</button>' : ''), $templateCode);
	}

	// set records to read only if user can't insert new records and can't edit current record
	if(($selected_id && !$AllowUpdate) || (!$selected_id && !$AllowInsert)){
		$jsReadOnly .= "\tjQuery('#item').prop('disabled', true).css({ color: '#555', backgroundColor: '#fff' });\n";
		$jsReadOnly .= "\tjQuery('#item_caption').prop('disabled', true).css({ color: '#555', backgroundColor: 'white' });\n";
		$jsReadOnly .= "\tjQuery('#price').replaceWith('<div class=\"form-control-static\" id=\"price\">' + (jQuery('#price').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#date').prop('readonly', true);\n";
		$jsReadOnly .= "\tjQuery('#dateDay, #dateMonth, #dateYear').prop('disabled', true).css({ color: '#555', backgroundColor: '#fff' });\n";
		$jsReadOnly .= "\tjQuery('.select2-container').hide();\n";

		$noUploads = true;
	}elseif(($AllowInsert && !$selected_id) || ($AllowUpdate && $selected_id)){
		$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', true);"; // temporarily disable form change handler
			$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', false);"; // re-enable form change handler
	}

	// process combos
	$templateCode = str_replace('<%%COMBO(item)%%>', $combo_item->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(item)%%>', $combo_item->MatchText, $templateCode);
	$templateCode = str_replace('<%%URLCOMBOTEXT(item)%%>', urlencode($combo_item->MatchText), $templateCode);
	$templateCode = str_replace('<%%COMBO(date)%%>', ($selected_id && !$arrPerm[3] ? '<div class="form-control-static">' . $combo_date->GetHTML(true) . '</div>' : $combo_date->GetHTML()), $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(date)%%>', $combo_date->GetHTML(true), $templateCode);

	/* lookup fields array: 'lookup field name' => array('parent table name', 'lookup field caption') */
	$lookup_fields = array(  'item' => array('items', 'Item'));
	foreach($lookup_fields as $luf => $ptfc){
		$pt_perm = getTablePermissions($ptfc[0]);

		// process foreign key links
		if($pt_perm['view'] || $pt_perm['edit']){
			$templateCode = str_replace("<%%PLINK({$luf})%%>", '<button type="button" class="btn btn-default view_parent hspacer-md" id="' . $ptfc[0] . '_view_parent" title="' . html_attr($Translation['View'] . ' ' . $ptfc[1]) . '"><i class="glyphicon glyphicon-eye-open"></i></button>', $templateCode);
		}

		// if user has insert permission to parent table of a lookup field, put an add new button
		if($pt_perm['insert'] && !$_REQUEST['Embedded']){
			$templateCode = str_replace("<%%ADDNEW({$ptfc[0]})%%>", '<button type="button" class="btn btn-success add_new_parent hspacer-md" id="' . $ptfc[0] . '_add_new" title="' . html_attr($Translation['Add New'] . ' ' . $ptfc[1]) . '"><i class="glyphicon glyphicon-plus-sign"></i></button>', $templateCode);
		}
	}

	// process images
	$templateCode = str_replace('<%%UPLOADFILE(id)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(item)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(price)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(date)%%>', '', $templateCode);

	// process values
	if($selected_id){
		if( $dvprint) $templateCode = str_replace('<%%VALUE(id)%%>', safe_html($urow['id']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(id)%%>', html_attr($row['id']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(id)%%>', urlencode($urow['id']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(item)%%>', safe_html($urow['item']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(item)%%>', html_attr($row['item']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(item)%%>', urlencode($urow['item']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(price)%%>', safe_html($urow['price']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(price)%%>', html_attr($row['price']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(price)%%>', urlencode($urow['price']), $templateCode);
		$templateCode = str_replace('<%%VALUE(date)%%>', @date('d/m/Y', @strtotime(html_attr($row['date']))), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(date)%%>', urlencode(@date('d/m/Y', @strtotime(html_attr($urow['date'])))), $templateCode);
	}else{
		$templateCode = str_replace('<%%VALUE(id)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(id)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(item)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(item)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(price)%%>', '0.00', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(price)%%>', urlencode('0.00'), $templateCode);
		$templateCode = str_replace('<%%VALUE(date)%%>', '1', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(date)%%>', urlencode('1'), $templateCode);
	}

	// process translations
	foreach($Translation as $symbol=>$trans){
		$templateCode = str_replace("<%%TRANSLATION($symbol)%%>", $trans, $templateCode);
	}

	// clear scrap
	$templateCode = str_replace('<%%', '<!-- ', $templateCode);
	$templateCode = str_replace('%%>', ' -->', $templateCode);

	// hide links to inaccessible tables
	if($_REQUEST['dvprint_x'] == ''){
		$templateCode .= "\n\n<script>\$j(function(){\n";
		$arrTables = getTableList();
		foreach($arrTables as $name => $caption){
			$templateCode .= "\t\$j('#{$name}_link').removeClass('hidden');\n";
			$templateCode .= "\t\$j('#xs_{$name}_link').removeClass('hidden');\n";
		}

		$templateCode .= $jsReadOnly;
		$templateCode .= $jsEditable;

		if(!$selected_id){
		}

		$templateCode.="\n});</script>\n";
	}

	// ajaxed auto-fill fields
	$templateCode .= '<script>';
	$templateCode .= '$j(function() {';


	$templateCode.="});";
	$templateCode.="</script>";
	$templateCode .= $lookups;

	// handle enforced parent values for read-only lookup fields

	// don't include blank images in lightbox gallery
	$templateCode = preg_replace('/blank.gif" data-lightbox=".*?"/', 'blank.gif"', $templateCode);

	// don't display empty email links
	$templateCode=preg_replace('/<a .*?href="mailto:".*?<\/a>/', '', $templateCode);

	/* default field values */
	$rdata = $jdata = get_defaults('item_prices');
	if($selected_id){
		$jdata = get_joined_record('item_prices', $selected_id);
		if($jdata === false) $jdata = get_defaults('item_prices');
		$rdata = $row;
	}
	$templateCode .= loadView('item_prices-ajax-cache', array('rdata' => $rdata, 'jdata' => $jdata));

	// hook: item_prices_dv
	if(function_exists('item_prices_dv')){
		$args=array();
		item_prices_dv(($selected_id ? $selected_id : FALSE), getMemberInfo(), $templateCode, $args);
	}

	return $templateCode;
}
?>
