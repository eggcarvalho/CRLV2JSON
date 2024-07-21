<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRLV para JSON</title>
    <link rel="stylesheet" href="assets/css/materialize.min.css">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <!-- Material Symbols - Outlined Set -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <!-- Material Symbols - Rounded Set -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet" />
    <!-- Material Symbols - Sharp Set -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp" rel="stylesheet" />
</head>

<body class="darken">
    <div class="container">
        <div class="row valign-wrapper" style="height: 90vh;">
            <div class="col s6 <?= !isset($_COOKIE['retorno_crlv']) ? 'offset-s3' : '' ?>">
                <form action="registrar.php" method="POST" enctype="multipart/form-data">
                    <div class="card white grey-text">
                        <div class="card-content">
                            <span class="card-title">Transformar CRLV para JSON</span>
                            <p>
                            <div class="file-field input-field">
                                <div class="btn black">
                                    <span>Arquivo</span>
                                    <input type="file" id="fileinput1" name="doc" accept="application/pdf">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate white black-text" type="text" placeholder="Enviar arquivo">
                                </div>
                            </div>
                            </p>
                        </div>
                        <div class="card-action">
                            <button class="btn icon-right waves-effect waves-light m-4" type="submit" name="action">
                                Converter <i class="material-icons right">send</i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <?php
            if (isset($_COOKIE['retorno_crlv'])) {
            ?>
                <div class="col s1"></div>
                <div class="col s5">
                    <div class="card white grey-text">
                        <div class="card-content">
                            <span class="card-title">Resultado em <span class="green-text" style="font-weight: bold">JSON</span> <a href="javascript:void(0);" onclick="copyToClipboard('result_div');" class="waves-effect waves-light btn"><span class="material-symbols-outlined">content_copy </span></a></span>
                            <pre id="result_div">
                                <?= base64_decode($_COOKIE['retorno_crlv']) ?>
                            </pre>
                        </div>
                    </div>
                </div>
            <?php
            }
            if (isset($_COOKIE['retorno_texto'])) {
            ?>
                <div class="col s12">
                    <div class="card white grey-text" style="max-height: 300px; margin-bottom: 300px; overflow-y: auto;">
                        <div class="card-content">
                            <span class="card-title">Texto Original do <span class="green-text" style="font-weight: bold">PDF</span> <a href="javascript:void(0);" onclick="copyToClipboard('retorno_div');" class="waves-effect waves-light btn"><span class="material-symbols-outlined">content_copy </span></a></span>
                            <hr>
                            <pre id="retorno_div">
                                <?= $_COOKIE['retorno_texto'] ?>
                            </pre>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <footer class="page-footer black" style="position: fixed; bottom: 0; width: 100%;">
        <div class="container">
            <div class="row">
                <div class="l6 s12">
                    <h5>CRLV para JSON</h5>
                    <p>Converta CRLV para o formato JSON</p>
                </div>
                <div class="l4 offset-l8 s12">

                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                © <?php $datetime = new DateTime();
                    echo $datetime->format('Y'); ?> Copyright Text
            </div>
        </div>
    </footer>
</body>
<script src="assets/js/materialize.min.js"></script>
<script>
    function copyToClipboard(text) {
        // Get the text field
        var copyText = document.getElementById(text);

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.innerHTML);

        // Alert the copied text
        alert("Copiado para a Area de Transferencia");
    }
    M.Forms.InitFileInputPath(document.querySelector('#fileinput1'));
</script>


</html>