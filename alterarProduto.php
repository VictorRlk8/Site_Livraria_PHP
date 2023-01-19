<?php

include 'conexao.php';  // incluindo a conexao
include 'resize-class.php'; // classe para redimensionar imagem

$cd_livro = $_GET['cd_altera'];  // variavel recebe o c�digo do livro que acabamos de receber do formul�rio

// abaixo criando a consulta pelo codigo do livro que recebemos acima
$consulta = $cn->query("SELECT ds_capa FROM tbl_livro WHERE cd_livro='$cd_livro'"); 

//criando uma array 
$exibe = $consulta->fetch(PDO::FETCH_ASSOC);


// todas as latera��es feitas nos campos ser�o salvas nas variaveis abaixo

$isbn = $_POST['txtisbn'];  // armazenando o valor do txtisbn na variavel $isbn 
$categoria = $_POST['sltcat'];  // armazenando o valor de sltcat na variavel $categoria
$livro = $_POST['txtlivro'];
$autor = $_POST['sltautor'];
$npag = $_POST['txtpag'];
$preco = $_POST['txtpreco'];
$resumo = $_POST['txtresumo'];
$qtde = $_POST['txtqtde'];
$lanc = $_POST['sltlanc'];


$remover1='.';  // vari�vel que vai receber o ponto
$preco = str_replace($remover1, '', $preco); // substituindo . por vazio
$remover2=','; // vari�vel que vai receber a virgula
$preco = str_replace($remover2, '.', $preco); // substituindo , por .

$recebe_foto1 = $_FILES['txtfoto1'];  // recebendo conteudo do campo file


$destino = "imagens/";  //pasta aonde ser� feito upload da imagem


if (!empty($recebe_foto1['name'])) { // se a propriedade name[propriedade que pega o nome da imagem ] n�o estiver vazia fa�a

	preg_match("/\.(jpg|jpeg|png|gif){1}$/i",$recebe_foto1['name'],$extencao1); // pegar extens�o
	$img_nome1 = md5(uniqid(time())).".".$extencao1[1]; //gerar nome unico para img, enviar esta vari�vel

	$upload_foto1=1; // se variavel criada for 1 precisar� trocar imagem

}

else {  // caso n�o haja altera��o na imagem, pegar o nome da imagem que est� no banco
	
	$img_nome1=$exibe['ds_capa'];
	$upload_foto1=0;  // zero pq n�o far� atualiza��o de fotos
	
}
	

try {
	// comando update para realizar as trocas
	$alterar = $cn->query("UPDATE tbl_livro SET  
	
	no_isbn = '$isbn',
	cd_categoria = '$categoria',
	nm_livro = '$livro',
	cd_autor = '$autor',
	no_pag= '$npag',
	vl_preco = '$preco',
	qt_estoque = '$qtde',
	ds_resumo_obra = '$resumo',
	ds_capa = '$img_nome1',
	sg_lancamento = '$lanc'	
	
	WHERE cd_livro = '$cd_livro' 	
	"); // as altera��es ser�o feitas baseadas pelo codigo que recebemos
	
	
	if ($upload_foto1==1) {  // se a foto1 for igual a 1 � pq foi feito altera��o ser� feita
		
		
		move_uploaded_file($recebe_foto1['tmp_name'], $destino.$img_nome1);             
		$resizeObj = new resize($destino.$img_nome1);
		$resizeObj -> resizeImage(340, 480, 'crop');
		$resizeObj -> saveImage($destino.$img_nome1, 100);
		
	}
	
	header('location:adm.php');  // redirecionando para a pagina menu principal (se tudo der certo)
	
} catch(PDOException $e) {  // se exsitir algum problema, ser� gerado uma mensagem de erro
	
	
	echo $e->getMessage();  
	
}



?>