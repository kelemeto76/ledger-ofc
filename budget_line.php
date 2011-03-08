<?php

include 'include.php';


//Get the list of budget items
$budget = ' -w --budget accounts ^exp';


exec("$ledger $budget", $categorylist);

$labellist = Array();
$max = 0;
$min = 0;

foreach($categorylist as $key){

    $tmp = substr(strrchr($key, ":"), 1);
     
    $averages = ' -c -w -MA -E --budget -d "d<[this month]" -F "%(date)\t%(amount)\n" reg ' . $key . ' | sed -e \'s/\$//g\' | sed -e \'s/,//g\'';
    
    unset($output);
    exec("$ledger $averages", $output);

    foreach ($output as $line){
        //make into key-value pairs
        $tmp = explode("\t", $line);
        $diff = $tmp[1]*1; 
        $datalist[$key][] = $diff;
        
        if(!in_array($tmp[0], $labellist)){
            $labellist[] = $tmp[0];    
        }
        if($diff > $max){
            $max = $diff;
        }
        if($diff < $min){
            $min = $diff;
        }
    }

}

$title = new title( "How far from the budget I was each month" );
sort($labellist);

$x_labels = new x_axis_labels();
$x_labels->rotate(45);
$x_labels->set_labels( $labellist );

$x = new x_axis();
$x->set_labels( $x_labels );

$y = new y_axis(); 
$y->set_range( round($min) * 1.1, round($max) * 1.1);
$y->set_label_text( "$#val#" );


$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->set_x_axis( $x );
$chart->set_y_axis( $y );
$chart->set_bg_colour( '#FFFFFF' );

foreach($categorylist as $category){
    $color = "#" . substr(md5($category), 0, 6); 
    $default_dot = new dot();
    $default_dot->size(3)->colour($color)->tooltip( '#key#:<br>$#val#' );
    $l = new line();
    $l->set_default_dot_style($default_dot);
    $l->set_values($datalist[$category]);
    $l->set_key($category, 12);
    $l->set_colour( $color );
    $chart->add_element($l);
}

echo $chart->toPrettyString();


?>

