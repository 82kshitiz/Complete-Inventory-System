<?php
$script_name = basename($_SERVER['PHP_SELF']);
if($_SERVER['PHP_SELF'] == 'index.php' && isset($_GET['signIn'])){
	?>
	
	<style>
	body{
		background:url("images/logo_mcsi.png") no-repeat fixed center center / cover;
	}
	</style>
    <div class="alert alert-default" id="benifits">
    Benifits of becoming a member
    <?php
}
?>

<div class="navbar-fixed-bottom hidden-print alert-info">
<?php echo date('D, j M Y h:m:S a T'); ?>
</div>