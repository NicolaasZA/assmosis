<?php
	$rootpath = "http://".$_SERVER['HTTP_HOST']."/assmosis/";
?>
<html>
	<head>
		<title>Error</title>		
		<link rel="stylesheet" type="text/css" href="<?php echo $rootpath; ?>errorpages/error.css">	
	</head>
	<body>
		<h1>Access Denied</h1>		
		<p>You do not have permission to access that resource.</p>
		<?php echo '<a href="'.$rootpath.'">Fly away, you fool!</a>'; ?>
	</body>
</html>