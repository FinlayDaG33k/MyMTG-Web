<?php
	$url = $_SERVER['REQUEST_URI']; //returns the current URL
	$parts = explode('/',$url);
	$dir = $_SERVER['SERVER_NAME'];
	$server = $_SERVER['SERVER_NAME'];
	for ($i = 0; $i < count($parts) - 1; $i++) {
	 $dir .= $parts[$i] . "/";
	}

	$crumbs = explode("/",$_SERVER["REQUEST_URI"]); // Make the breadcrumbs.
	$void = array_shift($crumbs); // band-aid a little bug

	if(!empty($_COOKIE['Userdata'])){
		$cookieData = json_decode($_COOKIE['Userdata'],1);
		$cookieData = $cookieData['message'];
	}

	require(DIRNAME(__FILE__) . "/inc/php/ezServer.php");
	$ezServer = new ezServer();

	function sendNotification($message,$type){
		return "$.notify({message: '$message'},{type: '$type',animate: {enter: 'animated bounceInRight',exit: 'animated bounceOutRight'}});";
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<?php include(DIRNAME(__FILE__).'/components/header.php'); ?>
	</head>
	<body>
		<?php include(DIRNAME(__FILE__).'/components/navbar.php'); ?>
		<div class="container-fluid">
			<?php include(DIRNAME(__FILE__).'/components/waiting.php'); ?>
			<?php
			$disallowed_paths = array('header', 'footer');
			if (!empty($_GET['page'])) {
				$tmp_page = basename($_GET['page']);
				if (!in_array($tmp_page, $disallowed_paths) && file_exists("pages/{$tmp_page}.php")) {
					$page = $tmp_page;
				} else {
					$page = 'error';
				}
			}else{
			    $page = 'home';
			}
			if($page !== 'error' && $page !== 'home'){
				?>
					<ul class="breadcrumb">
						<?php
							$prevcrumb = "";
							foreach($crumbs as $crumb){
								?>
									<li><a href="<?= $ezServer->getProto() ."://". $server ."/" .$prevcrumb. htmlentities($crumb); ?>"><?= htmlentities(ucfirst($crumb)); ?></a></li>
								<?php
								$prevcrumb .= $crumb . "/";
							}
						?>
					</ul>
				<?php
			}
			include("pages/{$page}.php");
			?>
		</div>
	</body>
</html>
