<?php

namespace App;

use Gemini;
use Gemini\Data\GenerationConfig;


class GeminiController
{
    private string $text;
    private array $data;
    private string $apiKey = 'AIzaSyD4HpfLmixO1zD0QoVM1R_F_LPFgOAnMYs';


    public function __construct(string $text, array $data)
    {
        $this->text = $text;
        $this->data = $data;

        $this->getAnalisisGemini();
    }



    private function getAnalisisGemini()
    {
        $client = Gemini::client($this->apiKey);


        $generationConfig = new GenerationConfig(
            temperature: 1,
            topP: 0.5,
            topK: 64,
        );

        $json = json_encode($this->data);


        $result = $client->geminiPro()
            ->withGenerationConfig($generationConfig)
            ->generateContent("Analise esse JSON: {$json} \n  Perceba que está faltando algumas informações que deve ser extraído daqui: {$this->text}, dessa forma por eliminação, preencha as informações que faltam em formato JSON");

        $return = str_replace(['```json', '```'], '', $result->text());






        $base64encode = base64_encode($return);

        setcookie('retorno_crlv', $base64encode, time() + 300);
        setcookie('retorno_texto', $this->text, time() + 300);
    }
}
