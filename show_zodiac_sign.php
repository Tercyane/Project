<?php include('./layouts/header.php'); ?>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Consulta de Signo Zodiacal</h5>
                        <p class="card-text">
                            <?php
                            $dataNascimento = $_POST['birthdate'];
                            $signos = simplexml_load_file('signos.xml');

                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                if (!empty($dataNascimento)) {
                                    $signo = getSigno($dataNascimento);
                                    if ($signo) {
                                        echo "<div class='result'><strong>Seu signo é: {$signo['signoNome']}</strong></div>";
                                        echo "<div class='description'>{$signo['descricao']}</div>";
                                    } else {
                                        echo "<div class='result'>Não foi possível encontrar seu signo.</div>";
                                    }
                                }
                            }

                            function getSigno($dataNascimento)
                            {
                                // Carrega o arquivo XML
                                $xml = simplexml_load_file('signos.xml') or die("Erro: Não foi possível carregar o arquivo XML.");
                                $dataNascimento = DateTime::createFromFormat('Y-m-d', $dataNascimento);
                                $diaMes = $dataNascimento->format('d-m');
                                $anoNascimento = $dataNascimento->format('Y');

                                // Itera sobre os signos no arquivo XML
                                foreach ($xml->signo as $signo) {
                                    $dataInicioArray = explode('-', $signo->dataInicio);
                                    $dataFimArray = explode('-', $signo->dataFim);

                                    // Cria datas no ano da data de nascimento
                                    $dataInicio = DateTime::createFromFormat('Y-m-d', $anoNascimento . '-' . $dataInicioArray[1] . '-' . $dataInicioArray[0]);
                                    $dataFim = DateTime::createFromFormat('Y-m-d', $anoNascimento . '-' . $dataFimArray[1] . '-' . $dataFimArray[0]);

                                    // Se a data de fim do signo for anterior à data de início, significa que cruza o ano (como Capricórnio)
                                    if ($dataFim < $dataInicio) {
                                        // Se a data de nascimento for antes de 21/01, estamos lidando com o ano novo
                                        if ($dataNascimento >= $dataInicio) {
                                            // Se a data de nascimento for entre 22/12 e 31/12
                                            if ($dataNascimento >= $dataInicio && $dataNascimento <= $dataFim->modify('+1 year')) {
                                                return [
                                                    'signoNome' => (string)$signo->signoNome,
                                                    'descricao' => (string)$signo->descricao
                                                ];
                                            }
                                        } else {
                                            // Se a data de nascimento for entre 01/01 e 20/01 (ajusta ano para o anterior)
                                            $dataInicio->modify('-1 year');
                                            if ($dataNascimento >= $dataInicio && $dataNascimento <= $dataFim) {
                                                return [
                                                    'signoNome' => (string)$signo->signoNome,
                                                    'descricao' => (string)$signo->descricao
                                                ];
                                            }
                                        }
                                    } else {
                                        // Para os outros signos, que não cruzam o ano
                                        if ($dataNascimento >= $dataInicio && $dataNascimento <= $dataFim) {
                                            return [
                                                'signoNome' => (string)$signo->signoNome,
                                                'descricao' => (string)$signo->descricao
                                            ];
                                        }
                                    }
                                }
                                return null;
                            }
                            ?>
                        </p>
                    </div>
                </div>
               
                <a href="index.php" class="btn btn-warning mt-3" >Realizar Nova Consulta</a>
            </div>
        </div>
    </div>

</body>

</html>