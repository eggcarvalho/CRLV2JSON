<?php
include "../vendor/autoload.php";


use Aws\Textract\TextractClient;
use Aws\Exception\AwsException;



if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['document']) && $_FILES['document']['error'] == UPLOAD_ERR_OK) {
    $document = $_FILES['document']['tmp_name'];

    $client = new TextractClient([
        'version' => 'latest',
        'region'  => 'us-west-2',
        'credentials' => [
            'key'    => 'AKIA3FLDZCW4Y2AE3OMP',
            'secret' => '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',
        ]
    ]);

    try {
        $result = $client->analyzeDocument([
            'Document' => [
                'Bytes' => file_get_contents($document), // ou use S3Object
            ],
            'FeatureTypes' => ['TABLES', 'FORMS'],
        ]);

        echo '<pre>';
        // print_r($result['Blocks']);


        $fields = array();
        foreach ($result['Blocks'] as $block) {
            if (!isset($block['Text'])) {
                continue;
            }
            $fields[] = $block['Text'];
        }


        print_r($fields);
        die();
        // session_start();
        // $_SESSION['result'] = $result;
    } catch (AwsException $e) {
        // Exibir mensagem de erro
        echo $e->getMessage();
        echo "\n";
    }
}
header("Location: index.php");
