<?php
	require_once('../simpletest/autorun.php');
	require_once('../classes/lib/afd.php');
	
	class TesteDeAFD extends UnitTestCase{
		//Sempre iniciar com uma lista de testes
		//Sempre iniciar pelo mais fácil
		//Escreva primeiro o teste
		//Escreva primeiro o teste assertivo
		//Mantra: Vermelho -> Verde -> Refatorar
		//Simula até construir(Refatorar³³³)
		//Buscar o verde o mais rápido possível
		//baby steps

		/*
		 * Lista de Testes (Planejatamento da classe):
		 *
		 *  - Deve retornar TRUE se string = 232 caracteres 
		 *  - Deve retornar TRUE se string contiver caracteres com acento
		 *  - Deve retornar TRUE se string NÃO contiver caracteres especiais
		 *  - Deve retornar TRUE se posicao 11 da string = '1' ou '2')
		 *  - Deve retornar TRUE se posição 11 = 1 e posicao 12 a 25 CNPJ válido
		 *  - Deve retornar TRUE se posição 11 = 2 e posicao 12 a 25 CPF válido
		 *
		 */

		

		function testeEntrada232Caracteres(){
		 	$afd = new Afd();
			$this->assertTrue($afd->verificarAfd("0000000001194663275000159            Nome do empregador ou razao social                                                                                                                   Z000000000012345670000000000000000000000000000"));
		}
		function testeCaracteresComAcento(){
			$afd = new Afd();
			$this->assertTrue($afd->verificarAfd("0000000001194663275000159            Nome dó empregador ou razao social                                                                                                                   Z000000000012345670000000000000000000000000000"));	
		}
		function testeCaracteresEspeciais(){
			$afd = new Afd();
			$this->assertFalse($afd->verificarAfd("0000000001194663275000159            Nome d* empregador ou razao social                                                                                                                   Z000000000012345670000000000000000000000000000"));	
		}
		function testePosicaoOnze(){
			$afd = new Afd();
			$this->assertTrue($afd->verificarAfd("0000000001271809392187               Nome do empregador ou razao social                                                                                                                   Z000000000012345670000000000000000000000000000"));	
		}
		function testePosicaoOnzeValidaCPNJ(){
			$afd = new Afd();
			$this->assertTrue($afd->verificarAfd("0000000001194663275000159            Nome do empregador ou razao social                                                                                                                   Z000000000012345670000000000000000000000000000"));	
		}
		function testePosicaoOnzeValidaCPF(){
			$afd = new Afd();
			$this->assertTrue($afd->verificarAfd("0000000001271809392187               Nome do empregador ou razao social                                                                                                                   Z000000000012345670000000000000000000000000000"));	
		}

	}


?>