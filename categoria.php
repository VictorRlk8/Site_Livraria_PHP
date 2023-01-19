<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minha Loja</title>
<meta name= "viewport" content= "width=device-width,inicial-scale=1"> <!-- responsividade -->

<!-- CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery livraria -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- JavaScript compilado-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style type= "text/css">
    .navbar
    {
      margin-bottom:0;
    }
  </style>
</head>
<body>
    <?php 
	 include 'nav.php';
     include 'cabecalho.html';
	 include 'conexao.php';
	 
	 $cat = $_GET {'cat'};
	 
	 // Variavel consulta vai receber variavel $cn que receberá o resultado de uma query
	$consulta = $cn->query(" select nm_livro,vl_preco,ds_capa,qt_estoque from vw_livro where ds_categoria = '$cat'");
	 ?>

    <div class ="container-fluid"> <!--Sistema de grid => Colunas do boostrap -->
      <div class ="row">
	  <?php while($exibe = $consulta->fetch(PDO::FETCH_ASSOC)) { ?>
        <div class = "col-sm-3">
            <img src = "imagens/<?php echo $exibe ['ds_capa']; ?>" class = "img-responsive" style = "width:100%">
            <div><h4><b><?php echo mb_strimwidth ($exibe  ['nm_livro'],0,25,'...'); ?></b></h4></div>
            <div><h5>R$ <?php echo number_format ($exibe ['vl_preco'],2,',','.'); ?> </h5></div>
			
			
			
			<div class="text-center">
				<button class="btn btn-lg btn-block btn-default">
				<a href="detalhes.php?cd=<?php echo $exibe['cd_livro'];?>">
					<span class= "glyphicon glyphicon-info-sign"> Detalhes</span>
				</button>
				</a>
			</div>
			
		
			
			<div class="text-center" style="margin-top:5px; margin-bottom: 5px;">
			<?php if ($exibe['qt_estoque'] > 0) { ?>
			
			<a href="carrinho.php?cd=<?php echo $exibe['cd_livro'];?>">
				<button class="btn btn-lg btn-block btn-primary">
					<span class= "glyphicon glyphicon-usd"> Comprar</span>
				</button> 
			</a>
		<?php } else { ?>
		
			<button class="btn btn-lg btn-block btn-danger" disabled>
					<span class= "glyphicon glyphicon-remove-circle"> Indisponivel</span>
			</button>
		<?php } ?>
			</div>
        </div>
	  <?php } ?>
       
      </div> <!-- fechamneto de class row -->
    </div><!-- fechamneto do container fluid -->

    <?php 
      include 'rodape.html';
    ?>
</body>
</html>