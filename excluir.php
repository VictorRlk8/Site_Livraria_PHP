<?php

include 'conexao.php';  // conexao com banco de dados

$cd=$_GET['id'];  // pegando o id que � enviado pelo bot�o excluir que esta na pagina lista.php


$pasta = "imagens/"; //localizar pasta aonde est�o as imagens

// criando consulta pelo id que foi pego
$consulta = $cn->query("SELECT * FROM tbl_livro WHERE cd_livro='$cd'");

//criando um array para exibir os dados
$exibe = $consulta->fetch(PDO::FETCH_ASSOC);

// comando para excluir o registro pelo cd_livro que foi recebido na variavel.
$excluir = $cn->query("DELETE FROM tbl_livro WHERE cd_livro='$cd'");

$foto1=$exibe['ds_capa'];  //salvando nesta vari�vel a imagem do select

if ($foto1!="") {  // se o conteudo n�o estiver vazio o comando unlink far� a exclus�o, indicando a pasta
	
	unlink($pasta.$foto1);
	
}

//redirecionado usuario para p�gina lista.php
header('location:lista.php');

?>