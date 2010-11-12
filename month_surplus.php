<?php

include 'include.php';

$this_month = ' -w -F "%(account)\t%(amount)\n" -E -p "this month" --budget -M reg ^exp | sed -e \'s/\$//g\' | sed -e \'s/,//g\'';
exec("$ledger $this_month", $output);

$max = 0;
$min = 0;

foreach ($output as $line){
    //make into key-value pairs
    $tmp = explode("\t", $line);
    $labellist[] = $tmp[0];

    if($tmp[1] *-1 > $max){
        $max = $tmp[1] *-1;
    }
    if($tmp[1] *-1 < $min){
        $min = $tmp[1] *-1;
    }
    
    $bar = new bar_value($tmp[1] *-1);
    if($tmp[1]*-1 == 0){
        $bar->set_colour( '#FFFFFF' );
    }else if($tmp[1]*-1 > 0){
        $bar->set_colour( '#000000' );
    }else if($tmp[1]*-1 < 0){
        $bar->set_colour( '#900000' );
    }
    $datalist[] = $bar;
}

$title = new title( "This month budget over/under" );

$bar = new bar_3d();
$bar->set_values( $datalist );
$bar->set_tooltip( '$#val#' );

$y = new y_axis(); 
$y->set_range(round($min *1.2) , round($max *1.2));

$y->set_steps(count($datalist)*2);
$y->set_label_text( "$#val#" );

$x_labels = new x_axis_labels();
$x_labels->rotate(45);
$x_labels->set_labels( $labellist );

$x = new x_axis();
$x->set_labels( $x_labels );

$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $bar );
$chart->set_x_axis( $x );
$chart->set_y_axis( $y );
$chart->set_bg_colour( '#FFFFFF' );

echo $chart->toPrettyString();


?>

