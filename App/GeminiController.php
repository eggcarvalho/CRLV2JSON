<?php
/*
 * Copyright (c) 2024 @eggcarvalho
 *
 * Este arquivo é parte do CRLV2JSON
 *
 * O CRLV2JSON é licenciado sob a Licença MIT.
 * Consulte o arquivo LICENSE para obter mais informações.
 */

namespace App;

use Gemini; // Importa a classe Gemini para interagir com a API do Gemini Pro
use Gemini\Data\GenerationConfig; // Importa a classe GenerationConfig para configurar a geração de texto

/**
 * Classe GeminiController responsável por interagir com a API do Gemini Pro para análise de texto e geração de conteúdo.
 */
class GeminiController
{
    // Atributos da classe
    private string $text; // Texto de entrada para análise
    private array $data; // Dados em formato JSON para análise
    private string $apiKey = 'SUA API KEY'; // Chave de API do Gemini Pro

    /**
     * Construtor da classe.
     *
     * @param string $text Texto de entrada para análise.
     * @param array $data Dados em formato JSON para análise.
     */
    public function __construct(string $text, array $data)
    {
        $this->text = $text; // Atribui o texto de entrada ao atributo $text
        $this->data = $data; // Atribui os dados JSON ao atributo $data

        $this->getAnalisisGemini(); // Chama o método privado getAnalisisGemini para realizar a análise
    }

    /**
     * Método privado para realizar a análise de texto e geração de conteúdo usando a API do Gemini Pro.
     */
    private function getAnalisisGemini()
    {
        // Cria um cliente Gemini Pro usando a chave de API
        $client = Gemini::client($this->apiKey);

        // Configura a geração de texto com parâmetros específicos
        $generationConfig = new GenerationConfig(
            temperature: 1, // Temperatura para controlar a criatividade da geração de texto
            topP: 0.5, // Probabilidade de seleção de tokens para a geração de texto
            topK: 64, // Número máximo de tokens a serem considerados para a geração de texto
        );

        // Converte os dados JSON para uma string JSON
        $json = json_encode($this->data);

        // Realiza a chamada à API do Gemini Pro para gerar conteúdo
        $result = $client->geminiPro()
            ->withGenerationConfig($generationConfig) // Define a configuração de geração de texto
            ->generateContent("Analise esse JSON: {$json} \n  Perceba que está faltando algumas informações que deve ser extraído daqui: {$this->text}, dessa forma por eliminação, preencha as informações que faltam em formato JSON"); // Define a instrução para a API

        // Remove as tags ```json e ``` do resultado da geração de texto
        $return = str_replace(['```json', '```'], '', $result->text());

        // Codifica o resultado em base64
        $base64encode = base64_encode($return);

        // Define cookies para armazenar o resultado da análise e o texto de entrada
        setcookie('retorno_crlv', $base64encode, time() + 300); // Armazena o resultado codificado em base64
        setcookie('retorno_texto', $this->text, time() + 300); // Armazena o texto de entrada
    }
}
