<?php

include 'include.php';

$budget = ' -w -F "%-A\t%t\n" -M -p "next month" --forecast "d<=[next month]" reg ^exp  -discretionary ';

exec("$ledger $budget", $output);

foreach ($output as $line){
    //make into key-value pairs
    $tmp = explode("\t", $line);
    $labellist[] = $tmp[0];
    $datalist[] = $tmp[1] * 1;
}

foreach($labellist as $label){
    $tmp = substr(strrchr($label, ":"), 1);
    $pos = strpos($tmp, " ");
    if($pos > 0){
        $parameter .= substr($tmp, 0, $pos) . " ";
    }else{
        $parameter .= $tmp . " ";
    }
}

$averages = "for i in $parameter; do $ledger -w -F '%T\\n' -E -MA -c -d 'd>=[this month]' reg \$i | sed -e 's/USD//g'; done ";
unset($output);
exec("$averages", $output);

foreach ($output as $line){
    //make into key-value pairs
    $averagelist[] = $line * 1;
}



$title = new title( "Budget vs Running Average" );

$bar1 = new bar_glass();
$bar1->set_values( $datalist );
$bar1->colour( '#BF3B69');
$bar1->key('Budget', 12);
$bar1->set_tooltip( '$#val#' );

$bar2 = new bar_glass();
$bar2->set_values( $averagelist );
$bar2->colour( '#5E0722' );
$bar2->key('Averages', 12);
$bar2->set_tooltip( '$#val#' );


$x_labels = new x_axis_labels();
$x_labels->rotate(45);
$x_labels->set_labels( $labellist );

$x = new x_axis();
$x->set_labels( $x_labels );

$y = new y_axis(); 
$y->set_range( 0, round(max(max($datalist), max($averagelist)) * 1.1));
$y->set_label_text( "$#val#" );


$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $bar1 );
$chart->add_element( $bar2 );
$chart->set_x_axis( $x );
$chart->set_y_axis( $y );
$chart->set_bg_colour( '#FFFFFF' );

echo $chart->toPrettyString();


?>

