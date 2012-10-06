<?php 
	/**
	*
	* Classe para validação de Arquivo Fonte de Dados (AFD) 
	*
	* Especificação do MTE referente a portaria 1.510/2009, especifica um padrão
	* para os arquivos gerados pelos REP - Registrador Eletrônico de Ponto
	* @author 	  Bargão Robalo <bargaorobalo@gmail.com>
	* @version 	  0.1
	* @copyright  CC BY-SA 3.0 <http://creativecommons.org/licenses/by-sa/3.0/>
	* @todo 	  Validar o CPF,CNPJ de acordo com especificação; Validar datas e hora do cabeçalho
	*/
	class Afd{
		
		function __construct(){

		}
		function validaCNPJ($cnpj){
			$cnpj = preg_replace( "@[./-]@", "", $cnpj);
		  	if (strlen($cnpj) <> 14) return false;

		   		$soma1 = ($cnpj[0] * 5) +
					     ($cnpj[1] * 4) +
					     ($cnpj[2] * 3) +
					     ($cnpj[3] * 2) +
					     ($cnpj[4] * 9) +
					     ($cnpj[5] * 8) +
					     ($cnpj[6] * 7) +
					     ($cnpj[7] * 6) +
					     ($cnpj[8] * 5) +
					     ($cnpj[9] * 4) +
					     ($cnpj[10] * 3) +
					     ($cnpj[11] * 2);
		   		$resto = $soma1 % 11;
		   		$digito1 = $resto < 2 ? 0 : 11 - $resto;
		   		$soma2 = ($cnpj[0] * 6) +
					     ($cnpj[1] * 5) +
					     ($cnpj[2] * 4) +
					     ($cnpj[3] * 3) +
					     ($cnpj[4] * 2) +
					     ($cnpj[5] * 9) +
					     ($cnpj[6] * 8) +
					     ($cnpj[7] * 7) +
					     ($cnpj[8] * 6) +
					     ($cnpj[9] * 5) +
					     ($cnpj[10] * 4) +
					     ($cnpj[11] * 3) +
					     ($cnpj[12] * 2);
		   		$resto = $soma2 % 11;
		  		$digito2 = $resto < 2 ? 0 : 11 - $resto;

		   		if($cnpj!= '00000000000000')
					return (($cnpj[12] == $digito1) && ($cnpj[13] == $digito2) ? true : false);
		  		else
		  			return false;
		}
		function validaCPF($cpf){
			$cpf = preg_replace( "@[./-]@", "", $cpf);
		  	$resultado = (preg_match("/0{11}|1{11}|2{11}|3{11}|4{11}|5{11}|6{11}|7{11}|8{11}|9{11}/", $cpf)) ? true : false;
		  	if($resultado === true){
		  		return false;
		  	}
		  	$dv_informado = substr($cpf, 9,2);

		  	for($i=0; $i<=8; $i++) {
   				$digito[$i] = substr($cpf, $i,1);
   			}

   			$posicao = 10;
   			$soma = 0;
  			for($i=0; $i<=8; $i++) {
    			$soma = $soma + $digito[$i] * $posicao;
    			$posicao = $posicao - 1;
   			}

   			$digito[9] = $soma % 11;
   				if($digito[9] < 2)
    				$digito[9] = 0;
   				else
    				$digito[9] = 11 - $digito[9];


   			$posicao = 11;
   			$soma = 0;
   			for ($i=0; $i<=9; $i++) {
    			$soma = $soma + $digito[$i] * $posicao;
    			$posicao = $posicao - 1;
   			}

   			$digito[10] = $soma % 11;
   				if ($digito[10] < 2)
    				$digito[10] = 0;
   				else
    				$digito[10] = 11 - $digito[10];
   				

   			$dv = $digito[9] * 10 + $digito[10];
  			 	if ($dv != $dv_informado)
   					$status = false;
  				else
   					$status = true;
  			

  			return $status;
		}
		function verificarAfd($string){
			$retorno = false;
			if(mb_strlen($string, 'utf8')==232)
				$retorno = true;
			else
				return false;
			$padrao = "/^0{9}.*1.*[1-2].*([0-9]{11}.*([ ]{3}|[0-9]{3}))([ ]{12}|[0-9]{12}).*[a-zA-Zà-úÀ-Ú ]{150}.*[0-9]{45}/";
			
			//print_r(var_dump(preg_match($padrao, $string)));

			if(preg_match($padrao, $string)){
				try {
					$tipoValidacao = substr($string, 10,1);
					switch ($tipoValidacao) {
						case 2:
							$cpf = substr($string, 11,11);
							$retorno = ($this->validaCPF($cpf)) ? true : false;
							
							break;
						
						default:
							$cpnj = substr($string, 11,14);
							$retorno = ($this->validaCNPJ($cpnj)) ? true : false ;
							break;
					}
				} catch (Exception $e) {
					throw new Exception("Cabeçalho AFD inválido.", 1);
					
				}
			}else
				$retorno = false;
			return $retorno;
		}

	}
?>