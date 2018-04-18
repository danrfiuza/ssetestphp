<?php

function send_message($id, $message, $progress) {
    header('Content-Type: text/event-stream',false);
    header('Cache-Control: no-cache',false); 
    $d = array('message' => $message , 'progress' => $progress,'qtd' => $progress); //prepare json

    echo "id: $id" . PHP_EOL;
    echo "data: " . json_encode($d) . PHP_EOL;
    echo PHP_EOL;

   ob_flush();
   flush();
}

$fileName      = "yourfile.txt";
$linhaCarga    = array();
$arrValuesDoc  = array();
$documentos    = array();
$linhas = explode("\n", file_get_contents($fileName));
$arrDados = array();
$countDados = count($linhas);
$i = 0;
$progress = 0;
$limit = 100;
foreach($linhas as $linha){
	$arrDados[$i][] = explode('#%#',$linha);
	if(($i % $limit) == 0 || $i == $countDados){
		send_message($i,number_format($i/$countDados, 1, '.', '')*100, $i); 
		//ob_flush();
		//flush();
		unset($arrDados);
		//sleep(1);
	}
	$i++;
}

//LONG RUNNING TASK
 //for($i = 1; $i <= 100; $i++) {
  //  send_message($i,$i, $i*100); 
   // sleep(0.00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000001);
 //}

send_message('CLOSE', 'Carga de Objetivos completa!');
?>
