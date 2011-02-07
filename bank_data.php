<?php

include 'include.php';

if (isset($_REQUEST['bank'])) {
    $bank = filter_var($_REQUEST['bank'], FILTER_SANITIZE_MAGIC_QUOTES);

    $labellist = Array();
    $max = 0;
    $min = 0;

    $checking_cmd = '-E -w -J -c --weekly --sort d reg "' . $bank . ':Checking"'; 
    exec("$ledger $checking_cmd", $output);

    foreach ($output as $line){
        $tmp = explode(" ", $line);
        $cdatalist[] = 1*$tmp[1];
        
        if(!in_array($tmp[0], $labellist)){
            $labellist[] = $tmp[0];    
        }
        if($tmp[1] > $max){
            $max = $tmp[1];
        }
        if($tmp[1] < $min){
            $min = $tmp[1];
        }
    }

    unset($output);

    $savings_cmd = '-E -w -J -c --weekly --sort d reg "' . $bank . ':Savings"'; 
    exec("$ledger $savings_cmd", $output);

    foreach ($output as $line){
        $tmp = explode(" ", $line);
        $sdatalist[] = 1*$tmp[1];
        if(!in_array($tmp[0], $labellist)){
            $labellist[] = $tmp[0];    
        }
        if($tmp[1] > $max){
            $max = $tmp[1];
        }
        if($tmp[1] < $min){
            $min = $tmp[1];
        }
    }

    sort($labellist);


    $title = new title( $bank . " Retrospective" );

    $cdot = new dot();
    $cdot->size(3)->colour("#0000FF")->tooltip( '$#val#' );

    $cline = new line();
    $cline->set_values( $cdatalist );
    $cline->set_colour( "#0000FF" );
    $cline->set_default_dot_style($cdot);
    $cline->set_key("Checking", 12);

    $sdot = new dot();
    $sdot->size(3)->colour("#FF0000")->tooltip( '$#val#' );
    $sline = new line();
    $sline->set_values( $sdatalist );
    $sline->set_colour( "#FF0000" );
    $sline->set_default_dot_style($sdot);
    $sline->set_key("Savings", 12);

    $x_labels = new x_axis_labels();
    $x_labels->rotate(45);
    $x_labels->set_labels( $labellist );
    $x_labels->set_steps(3);

    $x = new x_axis();
    $x->set_labels( $x_labels );

    $y = new y_axis(); 
    $y->set_range( round($min) * 1.1, round($max) * 1.1);
    $y->set_label_text( "$#val#" );

    $chart = new open_flash_chart();
    $chart->set_title( $title );
    $chart->add_element( $cline );
    $chart->add_element( $sline );
    $chart->set_x_axis( $x );
    $chart->set_y_axis( $y );
    $chart->set_bg_colour( '#FFFFFF' );

    echo $chart->toPrettyString();

}


?>

