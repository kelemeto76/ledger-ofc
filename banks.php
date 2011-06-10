<html>
<head>
 
<script type="text/javascript" src="../js/swfobject.js"></script>

<?php
$bankslist = Array();
$bankslist[] = "FirstTech";
foreach($bankslist as $bank){?>

<script type="text/javascript">swfobject.embedSWF("open-flash-chart.swf", "<?php echo $bank ?>", "900", "450", "9.0.0", "expressInstall.swf", {"data-file":"bank_data.php?bank=<?php echo $bank ?>"} );</script>

<?php } ?>
</head>
<body>
 
 
<?php foreach($bankslist as $bank){?>
<div id="<?php echo $bank ?>"></div>
<?php } ?>
 
</body>
</html>

