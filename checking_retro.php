<?php

include 'include.php';

$acct_cmd = 'balance checking';
exec("$ledger $acct_cmd", $acctlist);


$i = 0;

foreach ($acctlist as $acct){
    $explosion = explode(' ', $acct);
    $acct = $explosion[count($explosion) - 1];
    if(!stristr($acct, "checking")) continue; //ignore extraneous output

    $i++; //count the accounts

    //In the first mode, a list of the accounts is printed
    if($_REQUEST['listaccts'] == 'true'){
        print($acct . " ");

    //In the second mode, an integer is used to determine which of the list of accounts is being charted
    } else if (isset($_REQUEST['acct']) && ($_REQUEST['acct'] == $i)) {


        $bal_cmd = '-w -J -d "d<=[today] & d>=[today]-365" --weekly --sort d reg "' . $acct . '"'; 
        exec("$ledger $bal_cmd", $output);

        foreach ($output as $line){
            $tmp = explode(" ", $line);
            $datalist[] = 1*$tmp[1];
            $labellist[] = $tmp[0];
        }

        $title = new title( $acct . " Retrospective" );

        $default_dot = new dot();
        $default_dot->tooltip( '$#val#' );

        $line = new line();
        $line->set_values( $datalist );
        $line->set_default_dot_style($default_dot);

        $x_labels = new x_axis_labels();
        $x_labels->rotate(45);
        $x_labels->set_labels( $labellist );
        $x_labels->set_steps(3);

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
    }
}


?>

