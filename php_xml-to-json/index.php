<?php   
$param = ($_GET) ? $_GET['data_inicial'] : '';
/*$xml = simplexml_load_file("horoscopo.xml");
echo "<pre>".print_r ($xml->signos->signo->attributes()->nome, true)."</pre>";
foreach($xml->signos as $horoscopo){
	$nomeSigno = (string)$horoscopo->signo->attributes()->nome;
	echo "<pre>".print_r ($horoscopo, true)."</pre>";
	foreach($horoscopo->dias as $data){
		$arrayPrev["previsoes"][] = array("signo"=>(string)$nomeSigno, "previsao"=>$data, "data"=>$data->dia['data']);
	}
}
echo "<pre>".print_r ($arrayPrev, true)."</pre>";
echo json_encode($xml);
*/
 
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
	//print_r($signo);
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
	/*foreach($signo->signo->dias->dia as $data){
		echo $data['data']."<br/>";
		echo $data."<br/>";
			
	}*/
}
echo "<pre>".print_r($arrPrev,true)."</pre>";
//echo "<pre>".print_r(json_encode($arrPrevisoes),true)."</pre>";


?>