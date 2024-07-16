<!doctype html>
<html lang="pt-BR">

<head>
    <title>DOC para JSON</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col h-100 d-flex align-items-center">
                <div class="card text-start w-100 mt-5">
                    <form action="executor.php" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <h4 class="card-title">Envie um Documento</h4>
                            <p class="card-text">
                            <div class="mb-3">
                                <label for="document" class="form-label">Documento</label>
                                <input type="file" class="form-control" name="document" id="document" accept="image/*, application/pdf" aria-describedby="helpId" placeholder="" />
                            </div>
                            </p>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary w-100">
                                Enviar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <?php
            session_start();

            if (isset($_SESSION['result'])) {
            ?>
                <div class="col-6 mt-5">
                    <div class="card">
                        <div class="card-header">
                            <h6>Resultado</h6>
                        </div>
                        <div class="card-body h-50" style="overflow-y: auto;">
                            <pre>
                            <?php

                            print_r($_SESSION['result']);
                            ?>
                            </pre>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>

    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>