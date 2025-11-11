<?php
// Inclui a aplicação e obtém o resultado
ob_start();
include 'App/index.php';
$output = ob_get_clean();

// Tenta decodificar JSON
$data = json_decode($output, true);

// Se for JSON válido, adiciona o nome do pod
if (is_array($data)) {
    $pod_name = getenv('HOSTNAME') ?: gethostname();
    $data['served_by_pod'] = $pod_name;
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} else {
    // Se não for JSON, só exibe o conteúdo normal
    echo $output;
}
