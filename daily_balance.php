<?php

include 'include.php';

$this_month = ' -w -J -c -p "daily" -d "d>=[this month] & d < [next month]"  --sort d reg "OSUFed:Checking" ';
exec("$ledger $this_month", $output);

foreach ($output as $line){
    //make into key-value pairs
    $tmp = explode(" ", $line);
    $datalist[] = 1*$tmp[1];
    $labellist[] = $tmp[0];
}

$title = new title( "Daily checking account balance" );

$default_dot = new dot();
$default_dot->tooltip( '$#val#' );

$line = new line();
$line->set_values( $datalist );
$line->set_default_dot_style($default_dot);

$x_labels = new x_axis_labels();
$x_labels->rotate(45);
$x_labels->set_labels( $labellist );
$x_labels->set_steps(2);

$x = new x_axis();
$x->set_labels( $x_labels );

$y = new y_axis(); 
$y->set_range(0, round(max($datalist) * 1.1));
$y->set_label_text( "$#val#" );


$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $line );
$chart->set_x_axis( $x );
$chart->set_y_axis( $y );
$chart->set_bg_colour( '#FFFFFF' );

echo $chart->toPrettyString();


?>

