<?php   

date_default_timezone_set("America/Sao_Paulo");

$param = ($_GET) ? $_GET['data_inicial'] : '';
$xml = simplexml_load_file("horoscopo.xml");
$paramEx = explode("/", $param);
$paramFormat = $paramEx[2]."-".$paramEx[1]."-".$paramEx[0];
$dataInicial = strtotime($paramFormat);
$dataFinal = strtotime($paramFormat."+30 days");

foreach($xml->signos as $signo){
	for ($i = 0; $i < 12; $i++){
		$nome_signo = $signo->signo[$i]->attributes()->nome."<br/>";
		$cont_datas = count($signo->signo[$i]->dias->dia);
		for ($j = 0; $j < $cont_datas; $j++){	
			$dataSigno = explode("/", $signo->signo[$i]->dias->dia[$j]['data']);
			$dataSigno = strtotime($dataSigno[2]."-".$dataSigno[1]."-".$dataSigno[0]);
			if($dataSigno >= $dataInicial && $dataSigno <= $dataFinal){
				$arrPrev['previsoes'][] = array("signo" => $nome_signo
												 , "previsao" => (string) $signo->signo[$i]->dias->dia[$j]
												 , "data" => (string) $signo->signo[$i]->dias->dia[$j]['data']);
			}									 
		}
	}
}

//echo "<pre>".print_r($arrPrev, true)."</pre>";
echo json_encode($arrPrev);

?>