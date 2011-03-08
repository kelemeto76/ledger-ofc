<html>
<head>
 
<script type="text/javascript" src="../js/swfobject.js"></script>

<script type="text/javascript">swfobject.embedSWF("open-flash-chart.swf", "month_surplus", "900", "350", "9.0.0", "expressInstall.swf", {"data-file":"month_surplus.php"} );</script>
<script type="text/javascript">swfobject.embedSWF("open-flash-chart.swf", "year_overview", "900", "350", "9.0.0", "expressInstall.swf", {"data-file":"year_overview.php"} );</script>
<script type="text/javascript">swfobject.embedSWF("open-flash-chart.swf", "daily_balance", "900", "350", "9.0.0", "expressInstall.swf", {"data-file":"daily_balance.php"} );</script>
<script type="text/javascript">swfobject.embedSWF("open-flash-chart.swf", "month_breakdown", "600", "600", "9.0.0", "expressInstall.swf", {"data-file":"month_breakdown.php"} );</script>
<script type="text/javascript">swfobject.embedSWF("open-flash-chart.swf", "budget_line", "900", "450", "9.0.0", "expressInstall.swf", {"data-file":"budget_line.php"} );</script>
<?php
$acctslist = Array();
$acctslist[] = "FirstTech:Checking";
$acctslist[] = "FirstTech:Savings";
$acctslist[] = "AmericanFunds:Money Market";
foreach($acctslist as $acct){
$acct = str_replace(':', '_', $acct); 
?>

<script type="text/javascript">swfobject.embedSWF("open-flash-chart.swf", "<?php echo $acct ?>_retrospective", "900", "450", "9.0.0", "expressInstall.swf", {"data-file":"account_retrospective.php?acct=<?php echo $acct ?>"} );</script>

<?php } ?>
</head>
<body>
 
 
<div id="month_surplus"></div>
<div id="month_breakdown"></div>
<div id="daily_balance"></div>
<div id="year_overview"></div>
<div id="budget_line"></div>
<?php foreach($acctslist as $acct){ 
$acct = str_replace(':', '_', $acct); 
?>
<div id="<?php echo $acct ?>_retrospective"></div>
<?php } ?>
 
</body>
</html>

