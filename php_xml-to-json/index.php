<?php   

$param = ($_GET) ? $_GET['data_inicial'] : '';
$xml = simplexml_load_file("horoscopo.xml");
foreach($xml->signos as $signo){
	foreach ($signo as $dados_signo){
		$i = 0;
		$nome_signo = (string) $dados_signo->attributes()->nome;
		foreach ($dados_signo->dias->dia as $info_previsao){	
			$arrPrevisoes['previsoes'][$i] = array();
			$arrPrevisoes['previsoes'][$i]['signo'] = $nome_signo;
			$arrPrevisoes['previsoes'][$i]['previsao'] = (string) $info_previsao;
			$arrPrevisoes['previsoes'][$i]['data'] = (string) $info_previsao['data'];
			$i++;
		}
	}
}
foreach($xml->signos as $signo){
	for ($i = 0; $i < 12; $i++){
		$nome_signo = $signo->signo[$i]->attributes()->nome."<br/>";
		$cont_datas = count($signo->signo[$i]->dias->dia);
		for ($j = 0; $j < $cont_datas; $j++){
			if ($signo->signo[$i]->dias->dia[$j]['data'] == $param){
				echo "SIGNO: ".$nome_signo;
				echo "PREVISAO: ".$signo->signo[$i]->dias->dia[$j]."<br/>";
				echo "DATA: ".$signo->signo[$i]->dias->dia[$j]['data']."<br/><br/>";
				$arrPrev['previsoes'][$i] = array("signo" => $nome_signo
												 , "previsao" => (string) $signo->signo[$i]->dias->dia[$j]
												 , "data" => (string) $signo->signo[$i]->dias->dia[$j]['data']);
			}
		}
	}
}
echo json_encode($arrPrevisoes);

?>