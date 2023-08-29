<?php

require_once "../config.php";
require_once "DataBase.php";

$dom = new DOMDocument('1.0', 'UTF-8');
$dom->formatOutput = true; 

$imp = new DOMImplementation();
$documento = $imp->createDocumentType('cursos', '', '../dtd/cursos.dtd');
$dom->appendChild($documento);

$cursosRaiz = $dom->createElement('cursos');
$dom->appendChild($cursosRaiz);

try{
    $banco = new DataBase();
    $conexao = $banco->conexao();

    if ($conexao === null) {
        throw new Exception("Falha ao conectar ao banco de dados.");
    }

    $sql = "SELECT c.nome, c.semestres, p.nome AS nome_coordenador
    FROM curso c
    JOIN professor p ON c.id_coordenador = p.id";

    $stmt = $conexao->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $curso = $dom->createElement('curso');

        $nome = $dom->createElement('nome', $row['nome']);
        $curso->appendChild($nome);

        $coordenador = $dom->createElement('coordenador', $row['nome_coordenador']);
        $curso->appendChild($coordenador);

        $semestre = $dom->createElement('semestre', $row['semestres']);
        $curso->appendChild($semestre);

        $cursosRaiz->appendChild($curso);
    }
    $dom->save('../xml/cursos.xml');
    echo 'XML Salvo';
} catch (PDOException $e) {
    die($e->getMessage());
} finally {
    $conexao = null;
    echo 'Conexão Encerrada';
}
?>
