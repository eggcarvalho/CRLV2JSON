<?php

use App\GeminiController;
use Smalot\PdfParser\Parser;



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (file_exists($_FILES['doc']['tmp_name'])) {
        require '../vendor/autoload.php';
        // $_FILES['doc']['tmp_name']

        $parser = new Parser();


        $pdf = $parser->parseFile($_FILES['doc']['tmp_name']);

        echo '<pre>';

        $text = $pdf->getText();

        preg_match_all('/\b\d{11}\b/', $text, $matches);
        $dados['veiculo']['renavam'] = $matches[0][0];
        $cla = $matches[0][1];

        preg_match_all('/\b[A-Z]{3}[0-9][A-Z][0-9]{2}\b/', $text, $matches);
        $dados['veiculo']['placa'] = $matches[0][0];

        preg_match_all('/20\d{2}/', $text, $matches);
        $ano                            = $matches;
        $dados['veiculo']['exercicio']  = $ano[0][0];
        $dados['veiculo']['anofab']     = $ano[0][1];
        $dados['veiculo']['anomod']     = $ano[0][2];



        preg_match_all('/\b\d{12}\b/', $text, $matches);
        $dados['veiculo']['numero_crv'] = $matches[0][0];

        $dados['veiculo']['cla'] = $cla;

        preg_match_all('/([A-Z]+\/[A-Z0-9 ]+)/', $text, $matches);
        $dados['veiculo']['marca_modelo_versao'] = $matches[0][1];

        $dados['veiculo']['especie_tipo'] = '';

        preg_match_all('/\b[A-Z]{3}\d{4}\/[A-Z]{2}\b/', $text, $matches);
        $dados['veiculo']['placa_anterior']  = str_contains($text, '*******/**') ? '*******/**' : $matches[0][0];



        preg_match_all('/[A-HJ-NPR-Z0-9]{17}/', $text, $matches);
        $dados['veiculo']['chassi'] = $matches[0][0];

        preg_match_all('/\b(AZUL|BRANCA|PRETA|PRATA|CINZA|BEGE|MARROM|VERMELHA|AMARELA|VERDE|ROSA|LARANJA|DOURADA)\b/', $text, $matches);
        $dados['veiculo']['cor'] = $matches[0][0];

        $dados['veiculo']['combustivel'] = str_contains($text, 'DIESEL') ? 'DIESEL' : 'NÃO INFORMADO/NÃO EXISTE';

        $dados['veiculo']['observacoes'] = '';

        $dados['veiculo']['categoria'] = str_contains($text, 'ALUGUEL') ? 'ALUGUEL' : 'PARTICULAR';

        $dados['veiculo']['capacidade'] = '';

        preg_match_all('/(\d+CV\/\*{4}|\d+CV\/\d{3})/', $text, $matches);
        $dados['veiculo']['potencia_cilindrada'] = $matches[0][0];

        preg_match_all('/\b\d+\.\d+\b/', $text, $matches);

        $dados['veiculo']['peso_bruto'] = str_contains($text, '*.*') ? '*.*' : $matches[0][0];


        $dados['veiculo']['cmt'] = '';


        $dados['veiculo']['eixos'] = '';

        preg_match_all('/\b\d{2}P\b/', $text, $matches);
        $dados['veiculo']['lotacao'] = $matches[0][0];


        $dados['veiculo']['carroceria'] = '';

        $dados['proprietario']['nome'] = '';


        preg_match_all('/\b(?:\d{3}\.\d{3}\.\d{3}-\d{2}|\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2})\b/', $text, $matches);
        $dados['proprietario']['cpf_cnpj'] = $matches[0][0];
        $dados['proprietario']['local'] = '';


        preg_match_all('#\b(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[0-2])/\d{4}\b#', $text, $matches);
        $dados['proprietario']['emissao'] = $matches[0][0];

        // print_r($matches);
        print_r($dados);


        $gemini = new GeminiController($text, $dados);
    }
}
header('Location: index.php');
