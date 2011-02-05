<html>
<head>
 
<script type="text/javascript" src="../js/swfobject.js"></script>
<script type="text/javascript">swfobject.embedSWF("open-flash-chart.swf", "month_surplus", "900", "350", "9.0.0", "expressInstall.swf", {"data-file":"month_surplus.php"} );</script>
<script type="text/javascript">swfobject.embedSWF("open-flash-chart.swf", "year_overview", "900", "350", "9.0.0", "expressInstall.swf", {"data-file":"year_overview.php"} );</script>
<script type="text/javascript">swfobject.embedSWF("open-flash-chart.swf", "daily_balance", "900", "350", "9.0.0", "expressInstall.swf", {"data-file":"daily_balance.php"} );</script>
<script type="text/javascript">swfobject.embedSWF("open-flash-chart.swf", "month_breakdown", "600", "600", "9.0.0", "expressInstall.swf", {"data-file":"month_breakdown.php"} );</script>
<script type="text/javascript">swfobject.embedSWF("open-flash-chart.swf", "bva_line", "900", "450", "9.0.0", "expressInstall.swf", {"data-file":"bva_line.php"} );</script>
<?php
$i = 1;

if (ini_get('allow_url_fopen') == '1') {
    $script_directory = substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['SCRIPT_FILENAME'], '/'));
    $server = "http://" . $_SERVER['HTTP_HOST'];
    $acctslist = explode(' ', trim(file_get_contents($server . $script_directory . '/checking_retro.php?listaccts=true')));
} else {
    $acctslist = Array();
}

if($acctslist == false){ $acctslist = Array();}
print_r($acctslist);

foreach($acctslist as $acct){
?>

<script type="text/javascript">swfobject.embedSWF("open-flash-chart.swf", "<?php echo $acct?>_retrospective", "900", "450", "9.0.0", "expressInstall.swf", {"data-file":"checking_retro.php?acct=<?php echo $i++?>"} );</script>

<?php
}
?>

</head>
<body>
 
 
<div id="month_surplus"></div>
<div id="month_breakdown"></div>
<div id="daily_balance"></div>
<div id="year_overview"></div>
<div id="bva_line"></div>
<?php
foreach($acctslist as $acct){
?>
<div id="<?php echo $acct?>_retrospective"></div>

<?php
}
?>

 
</body>
</html>
