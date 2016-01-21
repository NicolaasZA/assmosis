<?php
	$rootpath = "http://".$_SERVER['HTTP_HOST']."/assmosis/";
?>
<html>
	<head>
		<title>Error</title>
		<link rel="stylesheet" type="text/css" href="<?php echo $rootpath; ?>errorpages/error.css">		
	</head>
	<body>
		<h1>Unauthorized</h1>		
		<p>You need to authenticate to access that resource.</p>
		<?php echo '<a href="'.$rootpath.'">Go back whence you came!</a>'; ?>
	</body>
</html>