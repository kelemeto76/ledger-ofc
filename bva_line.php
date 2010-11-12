<?php

include 'include.php';

$budget = ' -w -F "%(account)\t%(amount)\n" -M -p "next month" --forecast "d<=[next month]" reg ^exp | sed -e \'s/\$//g\' | sed -e \'s/,//g\' ';


exec("$ledger $budget", $output);

foreach ($output as $line){
    //make into key-value pairs
    $tmp = explode("\t", $line);
    if($tmp[0] != "Expenses:Discretionary"){
        $categorylist[] = $tmp[0];
        $budgetlist[$tmp[0]] = $tmp[1] * 1;
    }
}

$labellist = Array();
$max = 0;
$min = 0;


foreach($categorylist as $key){

    $tmp = substr(strrchr($key, ":"), 1);
    $pos = strpos($tmp, " ");
    if($pos > 0){
        $parameter= substr($tmp, 0, $pos) . " ";
    }else{
        $parameter= $tmp . " ";
    }
   
    $averages = ' -w -F "%(date)\t%(amount)\n" -E -MA -c reg ' . $key . ' | sed -e \'s/\$//g\' | sed -e \'s/,//g\'';
    
    unset($output);
    exec("$ledger $averages", $output);

    foreach ($output as $line){
        //make into key-value pairs
        $tmp = explode("\t", $line);
        $diff = ($tmp[1]*1) - ($budgetlist[$key]*1); 
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

//print_r($datalist);


$title = new title( "Running Average - Budget" );


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
    $l = new line();
    $l->set_values($datalist[$category]);
    $l->set_key($category, 12);
    $l->set_tooltip('<br>$#val#');
    $color = "#" . substr(md5($category), 0, 6); 
    $l->set_colour( $color );
    $chart->add_element($l);
}

echo $chart->toPrettyString();


?>

