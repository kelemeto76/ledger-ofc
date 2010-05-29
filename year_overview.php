<?php

include 'php-ofc-library/open-flash-chart.php';

$this_month = ' -w --forecast \'d<[next year]\' -d \'d>[next month]\' -M reg ^inc ^exp | grep " - " | awk \'{print $1 ,$7}\' ';
exec("/opt/local/bin/ledger -f /Users/bettse/Documents/osufed.lgr $this_month", $output);

foreach ($output as $line){
    $tmp = explode(" ", $line);
    $datalist[] = -1*$tmp[1];
    $labellist[] = $tmp[0];
}

$title = new title( "Checking account forecast until end of year" );

$default_dot = new dot();
$default_dot->tooltip( '$#val#' );

$line = new line();
$line->set_values( $datalist );
$line->set_default_dot_style($default_dot);

$x_labels = new x_axis_labels();
$x_labels->rotate(45);
$x_labels->set_labels( $labellist );
$x_labels->set_steps(1);

$x = new x_axis();
$x->set_labels( $x_labels );

$y = new y_axis(); 
$y->set_range( min(min($datalist)-10, 0) , round(max($datalist) * 1.1));
$y->set_label_text( "$#val#" );


$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $line );
$chart->set_x_axis( $x );
$chart->set_y_axis( $y );
$chart->set_bg_colour( '#FFFFFF' );

echo $chart->toPrettyString();


?>

