<?php

require_once "../config.php";
require_once "DataBase.php";

$dom = new DOMDocument('1.0', 'UTF-8');
$dom->formatOutput = true;

$imp = new DOMImplementation();
$documento = $imp->createDocumentType('disciplinas', '', '../dtd/disciplinas.dtd');
$dom->appendChild($documento);

$disciplinasRaiz = $dom->createElement('disciplinas');
$dom->appendChild($disciplinasRaiz);

try {
    $banco = new DataBase();
    $conexao = $banco->conexao();

    $sql = "SELECT c.nome AS nomeCurso, d.* FROM disciplina d 
            INNER JOIN curso c ON d.id_curso = c.id";

    $stmt = $conexao->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $disciplina = $dom->createElement('disciplina');

        $disciplina->setAttribute('codigo', $row['codigo']);

        $nome = $dom->createElement('nome', $row['nome']);
        $disciplina->appendChild($nome);

        if (isset($row['carga'])) {
            $cargaElement = $dom->createElement('carga', $row['carga']);
            $disciplina->appendChild($cargaElement);
        }

        if (isset($row['ementa'])) {
            $ementa = $dom->createElement('ementa', $row['ementa']);
            $disciplina->appendChild($ementa);
        }

        $semestre = $dom->createElement('semestre', $row['semestre']);
        $disciplina->appendChild($semestre);
        
        $nomeCursoElement = $dom->createElement('nomeCurso', $row['nomeCurso']);
        $disciplina->appendChild($nomeCursoElement);

        $disciplinasRaiz->appendChild($disciplina);
    }
    
    $dom->appendChild($disciplinasRaiz);
    $dom->save('../xml/disciplinas.xml');
    echo 'XML Salvo,';
} catch (PDOException $e) {
    die($e->getMessage());
} finally {
    $conexao = null;
    echo ' Conexão Encerrada';
}

?>
