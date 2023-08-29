<?php

require_once "../config.php";
require_once "DataBase.php";

$dom = new DOMDocument('1.0', 'UTF-8');
$dom->formatOutput = true;

$imp = new DOMImplementation();
$documento = $imp->createDocumentType('professores', '', '../dtd/professores.dtd');
$dom->appendChild($documento);

$professoresRaiz = $dom->createElement('professores');
$dom->appendChild($professoresRaiz);

try {
    $banco = new DataBase();
    $conexao = $banco->conexao();

    $sql = "SELECT * FROM professor";

    $stmt = $conexao->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $professor = $dom->createElement('professor');

        $professor->setAttribute('id', $row['id']);

        $nome = $dom->createElement('nome', $row['nome']);
        $professor->appendChild($nome);

        $email = $dom->createElement('email', $row['email']);
        $professor->appendChild($email);

        $professoresRaiz->appendChild($professor);
    }

    $dom->save('../xml/professores.xml');
    echo 'XML Salvo, ';
} catch (PDOException $e) {
    die($e->getMessage());
} finally {
    $conexao = null;
    echo 'Conexão Encerrada';
}

?>
