<?php
	$rootpath = "http://".$_SERVER['HTTP_HOST']."/";
?>
<html>
	<head>
		<title>Error</title>
		<link rel="stylesheet" type="text/css" href="<?php echo $rootpath; ?>errorpages/error.css">			
	</head>
	<body>
		<h1>Server Error</h1>		
		<p>Whoops, not sure what happened there, but we're on it.</p>
		<?php echo '<a href="'.$rootpath.'">Head back to relative sanity!</a>'; ?>
	</body>
</html>