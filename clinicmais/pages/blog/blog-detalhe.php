<?php 

$title_page = "Blog | ";
include dirname(__FILE__). '/../includes/header.php'; ?>


<main class="main mb-0" data-animate="top" data-delay="3">
<aside class="banner_topo bnr-blog"></aside>
	 
<header class="page-header" >
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h1>
					<span>Blog</span>
				</h1>
			</div>
		</div>
	</div>
</header>

<section class=" mb-4">
	<div class="container">
		
		<div class="row">
			
			<article class="col-12">
				 <div class="cabecalho mb-4 pb-2">
					<h2 class="topic5" id="titulo"><!-- conteudo preenchido via requisição --></h2>
					<time style="color:#3056bb" id="data_postagem"><img src="assets/img/icones/calendar.jpg" style="vertical-align: baseline;" alt=""> <!-- conteudo preenchido via requisição --></time>
					<p id="autor">
						<!-- conteudo preenchido via requisição -->
					</p>
					<hr class="">
				 </div>
                

				<p class="text-center">
					<img src="assets/img/foto.jpg" alt="" class="img-fluid mb-3">
				</p>

				<p id="conteudo">
					<!-- conteudo preenchido via requisição -->
				</p>

		        <p>
		          <a href="javascript:history.go(-1);" class="btn btn-1 mt-3"> &laquo; Voltar</a>
		          <a id="apagar" class="btn btn-danger btn-2 mt-3">Apagar</a>
		          <a id="update" class="btn btn-warning btn-2 mt-3">Atualizar</a>
		        </p>
			</article>	


        <div class="col-md-12 mt-4 col-lg-10 col-xl-8">
          <h5 class="topic5">Comentários</h5>
            <div class="comentario mb-3">
              <div class="d-block"> 
                  <h6 class="fw-bold text-primary mb-1">Pedro Paulo</h6>
                  <p class="text-muted small mb-0">
                    Shared publicly - Jan 2020
                  </p>
              </div>

              <p class="mt-3 mb-4 pb-2">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac arcu a lacus posuere facilisis nec a sapien. Proin mattis, diam id pharetra vulputate, lectus sapien tristique justo, nec vehicula enim turpis sit amet sapien. Interdum et malesuada fames ac ante ipsum primis in faucibus. Quisque a nunc erat. Cras ut dui ut mi scelerisque cursus.
              </p>
            </div>
        
            <div class="comentario mb-3">
              <div class="d-block"> 
                  <h6 class="fw-bold text-primary mb-1">José Carol</h6>
                  <p class="text-muted small mb-0">
                    Shared publicly - Jan 2020
                  </p>
              </div>

              <p class="mt-3 mb-4 pb-2">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac arcu a lacus posuere facilisis nec a sapien. Proin mattis, diam id pharetra vulputate, lectus sapien tristique justo, nec vehicula enim turpis sit amet sapien. Interdum et malesuada fames ac ante ipsum primis in faucibus. Quisque a nunc erat. Cras ut dui ut mi scelerisque cursus.
              </p>
            </div>
        

            <form class=" py-3 border-0">
          <h5 class="topic5">Deixe um comentário</h5>
		        <div class="row ">
			        <div class="col-md-12">
			        	<div class="form-group">
			        		<input class="form-control"  type="text" name="" placeholder="Nome"style="border: 1px solid #98a8b1;">
			        	</div>
			        </div>
			        <div class="col-md-12">
			        	<div class="form-group">
                 			<textarea class="form-control" id="" placeholder="Mensagem" rows="4" style="border: 1px solid #98a8b1;"></textarea>
			        	</div>
			        </div>
			        <div class="col-md-12">
			        	<div class="float-right pt-1">
                			<button type="button"  class="btn btn-primary btn-sm" data-mdb-button-initialized="true">PUBLICAR</button>
			        	</div>
			        </div>
			    </div>
            </form>
              
            </div>
        </div>
 		
		</div><!-- row -->

	</div> <!-- container -->
</section>

<script type="module">
    import { fetchData } from '/clinicmais/pages/blog/request.js';
    //Fazendo a requisição POST para a api
    
	document.addEventListener('DOMContentLoaded', function() {

		const url = new URL(window.location.href);

		const postId = +url.searchParams.get('postId');

		const dados = {
            txtPostId: postId
        };

        fetchData('/clinicmais/pages/blog/api/retornarPost.php', 'POST', dados)
        .then(res => {

            if (res.data) {
                document.getElementById('titulo').textContent = res.data.titulo;
                document.getElementById('data_postagem').textContent = res.data.data_postagem; 
				document.getElementById('autor').textContent = res.data.autor;
                document.getElementById('conteudo').textContent = res.data.conteudo;
            }

        })
        .catch(error => {
            console.error('Erro:', error);
        });

		document.getElementById('apagar').addEventListener('click', function() {
			fetchData('/clinicmais/pages/blog/api/excluirPost.php', 'DELETE', dados)
			.then(res => {
				
				if (res.message == 'success'){
					window.location.href = '/clinicmais/pages/blog/blog.php';
				}

			})
			.catch(error => {
				console.error('Erro:', error);
			});
		});

		document.getElementById('update').addEventListener('click', function() {
			window.location.href = '/clinicmais/pages/blog/view/formPost.php?postId='+postId;
		});
    });
</script>

<aside>
<?php
	$banner = rand(1,6);
?>
	<a href="<?=$config['whatsapp'];?>" target="_blank">
		<img src="assets/img/banner/0<?=$banner;?>.png" class="d-none d-md-block w-100">
		<img src="assets/img/banner/mobile0<?=$banner;?>.jpg" class="d-block d-md-none w-100">
	</a>
</aside>
</main>


<?php 

include dirname(__FILE__). '/../includes/footer.php';

?>