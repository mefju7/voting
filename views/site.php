<?php require_once 'inc/display.php'; ?>
<html><head>
<link rel="stylesheet" href="styles.css" type="text/css"/>
<title><?php e($pollTitle);?></title>
<?php printScripts(); ?>
</head>
<body>
<div id="site">
<?php
if(isset($sections) && is_array($sections)){
 foreach($sections as $sec)
  include $sec;
}
?>
</div>

