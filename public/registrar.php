<?php
/*
 * Copyright (c) 2024 @eggcarvalho
 *
 * Este arquivo é parte do CRLV2JSON
 *
 * O CRLV2JSON é licenciado sob a Licença MIT.
 * Consulte o arquivo LICENSE para obter mais informações.
 */


use App\GeminiController;
use Smalot\PdfParser\Parser;

// Verifica se o método de requisição é POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se o arquivo foi enviado
    if (file_exists($_FILES['doc']['tmp_name'])) {
        // Inclui o arquivo de autoload do Composer
        require '../vendor/autoload.php';

        // Cria um objeto Parser para analisar o arquivo PDF
        $parser = new Parser();

        // Analisa o arquivo PDF
        $pdf = $parser->parseFile($_FILES['doc']['tmp_name']);

        // Imprime o conteúdo do PDF em formato de pré-formatação
        echo '<pre>';

        // Obtém o texto do PDF
        $text = $pdf->getText();

        // Cria um array para armazenar os dados extraídos do PDF
        $dados = [];

        // Extrai o RENAVAM do texto
        preg_match_all('/\b\d{11}\b/', $text, $matches);
        $dados['veiculo']['renavam'] = $matches[0][0];
        $cla = $matches[0][1]; // Armazena o segundo número de 11 dígitos para uso posterior

        // Extrai a placa do texto
        preg_match_all('/\b[A-Z]{3}[0-9][A-Z][0-9]{2}\b/', $text, $matches);
        $dados['veiculo']['placa'] = $matches[0][0];

        // Extrai o ano do exercício, ano de fabricação e ano do modelo do texto
        preg_match_all('/20\d{2}/', $text, $matches);
        $ano = $matches;
        $dados['veiculo']['exercicio'] = $ano[0][0];
        $dados['veiculo']['anofab'] = $ano[0][1];
        $dados['veiculo']['anomod'] = $ano[0][2];

        // Extrai o número do CRLV do texto
        preg_match_all('/\b\d{12}\b/', $text, $matches);
        $dados['veiculo']['numero_crv'] = $matches[0][0];

        // Atribui o valor de $cla ao campo 'cla' do array $dados
        $dados['veiculo']['cla'] = $cla;

        // Extrai a marca, modelo e versão do texto
        preg_match_all('/([A-Z]+\/[A-Z0-9 ]+)/', $text, $matches);
        $dados['veiculo']['marca_modelo_versao'] = $matches[0][1];

        // Define o campo 'especie_tipo' como vazio
        $dados['veiculo']['especie_tipo'] = '';

        // Extrai a placa anterior do texto
        preg_match_all('/\b[A-Z]{3}\d{4}\/[A-Z]{2}\b/', $text, $matches);
        $dados['veiculo']['placa_anterior'] = str_contains($text, '*******/**') ? '*******/**' : $matches[0][0];

        // Extrai o chassi do texto
        preg_match_all('/[A-HJ-NPR-Z0-9]{17}/', $text, $matches);
        $dados['veiculo']['chassi'] = $matches[0][0];

        // Extrai a cor do texto
        preg_match_all('/\b(AZUL|BRANCA|PRETA|PRATA|CINZA|BEGE|MARROM|VERMELHA|AMARELA|VERDE|ROSA|LARANJA|DOURADA)\b/', $text, $matches);
        $dados['veiculo']['cor'] = $matches[0][0];

        // Define o combustível do veículo
        $dados['veiculo']['combustivel'] = str_contains($text, 'DIESEL') ? 'DIESEL' : 'NÃO INFORMADO/NÃO EXISTE';

        // Define o campo 'observacoes' como vazio
        $dados['veiculo']['observacoes'] = '';

        // Define a categoria do veículo
        $dados['veiculo']['categoria'] = str_contains($text, 'ALUGUEL') ? 'ALUGUEL' : 'PARTICULAR';

        // Define o campo 'capacidade' como vazio
        $dados['veiculo']['capacidade'] = '';

        // Extrai a potência e cilindrada do texto
        preg_match_all('/(\d+CV\/\*{4}|\d+CV\/\d{3})/', $text, $matches);
        $dados['veiculo']['potencia_cilindrada'] = $matches[0][0];

        // Extrai o peso bruto do texto
        preg_match_all('/\b\d+\.\d+\b/', $text, $matches);
        $dados['veiculo']['peso_bruto'] = str_contains($text, '*.*') ? '*.*' : $matches[0][0];

        // Define o campo 'cmt' como vazio
        $dados['veiculo']['cmt'] = '';

        // Define o campo 'eixos' como vazio
        $dados['veiculo']['eixos'] = '';

        // Extrai a lotação do texto
        preg_match_all('/\b\d{2}P\b/', $text, $matches);
        $dados['veiculo']['lotacao'] = $matches[0][0];

        // Define o campo 'carroceria' como vazio
        $dados['veiculo']['carroceria'] = '';

        // Define o campo 'nome' do proprietário como vazio
        $dados['proprietario']['nome'] = '';

        // Extrai o CPF/CNPJ do proprietário do texto
        preg_match_all('/\b(?:\d{3}\.\d{3}\.\d{3}-\d{2}|\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2})\b/', $text, $matches);
        $dados['proprietario']['cpf_cnpj'] = $matches[0][0];

        // Define o campo 'local' do proprietário como vazio
        $dados['proprietario']['local'] = '';

        // Extrai a data de emissão do CRLV do texto
        preg_match_all('#\b(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[0-2])/\d{4}\b#', $text, $matches);
        $dados['proprietario']['emissao'] = $matches[0][0];

        // Imprime o array $dados em formato de pré-formatação
        print_r($dados);

        // Cria um novo objeto GeminiController com o texto extraído do PDF e os dados extraídos
        $gemini = new GeminiController($text, $dados);
    }
}

// Redireciona para a página index.php
header('Location: index.php');
