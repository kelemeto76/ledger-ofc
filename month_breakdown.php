<?php

include 'include.php';

$this_month = ' -w -c -F "%(account)\t%(total)\n" -p "this month" bal ^exp | sed -e \'s/\$//g\' | sed -e \'s/,//g\' ';
exec("$ledger $this_month", $output);

foreach ($output as $line){
    //make into key-value pairs
    $tmp = explode("\t", $line);
    $datalist[] = new pie_value(1*$tmp[1], $tmp[0]);
}

$title = new title( "This month spending breakdown" );

$pie = new pie();
$pie->set_alpha(0.6);
$pie->set_start_angle( 35 );
$pie->add_animation( new pie_fade() );
$pie->set_tooltip( '#label#<br>$#val# (#percent#)' );
$pie->set_no_labels();
$pie->set_colours( array('#1C9E05','#FF368D', '#FF33C9', '#FF653F') );
$pie->set_values( $datalist );


$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $pie );
$chart->set_bg_colour( '#FFFFFF' );

echo $chart->toPrettyString();


?>

