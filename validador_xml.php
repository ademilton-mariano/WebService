<?php

$arquivos = ['./xml/disciplinas.xml', './xml/cursos.xml', './xml/professores.xml'];

libxml_use_internal_errors(true);

foreach ($arquivos as $arquivo) {

    $dom = new DOMDocument();

    if (!$dom->load($arquivo)) {
        echo "Erro ao carregar o arquivo XML: $arquivo\n";
        continue;
    }

    // Realizar a validação
    if ($dom->validate()) {
        echo "O arquivo XML $arquivo é válido.\n";
    } else {
        echo "O arquivo XML $arquivo não é válido. Erros:\n";
        foreach (libxml_get_errors() as $error) {
            echo $error->message . "\n";
        }
    }

    libxml_clear_errors();
}
?>
