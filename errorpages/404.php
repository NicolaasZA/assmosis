<?php
	$rootpath = "http://".$_SERVER['HTTP_HOST']."/";
?>
<html>
	<head>
		<title>Error</title>
		<link rel="stylesheet" type="text/css" href="<?php echo $rootpath; ?>errorpages/error.css">			
	</head>
	<body>
		<h1>Resource Not Found</h1>		
		<p>Nothing to see here.</p>
		<?php echo '<a href="'.$rootpath.'">Beam me up, Scotty!</a>'; ?>
	</body>
</html>