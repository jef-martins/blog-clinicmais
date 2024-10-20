<style>
	.cursor-pointer {
		cursor: pointer;
	}
</style>

<?php 

$title_page = "Blog | ";
include '../../pages/includes/header.php'; ?>

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

<section class=" mb-0">
	<div class="container">

		<div class="row">
			<div class="col-12 mb-4">
				<form class="row">
					<div class="col-lg-9 col-8">
						<input id="searchInput" class="form-control form-control-lg" style="border: 1px solid #98a8b1;padding: 11px;" type="text" placeholder="Buscar">
					</div>
					<div class="col-lg-3 col-4">
						<button id="btnBuscar" type="button" class="btn btn-primary w-100">BUSCAR</button>
					</div>
				</form>
			</div>
			<hr>
			<div class="col-12 mb-4">
				<form class="row">
					<div class="col-lg-3 col-4">
						<button type="button" onclick="window.location.href = '/clinicmais/pages/blog/view/formPost.php'" class="btn btn-primary w-100">Adicionar POST</button>
					</div>
				</form>
			</div>
		</div>
		
		<div class="row" id="postsContainer">

			
		
		</div><!-- row -->

	</div> <!-- container -->
</section>

<script type="module">
    import { fetchData } from '/clinicmais/pages/blog/request.js';

	function listarPosts(titulo = null, pagina = 1){
		
		const dados = {
            txtTitulo: titulo,
			txtPagina: pagina,
        };

		fetchData('/clinicmais/pages/blog/api/listPost.php', 'POST',dados)
        .then(res => {
            const postContainer = document.getElementById('postsContainer'); 
			postContainer.innerHTML = ''; 

            res.data.posts.forEach(post => {
                const colDiv = document.createElement('div');
                colDiv.className = 'col-lg-4 mb-5';

                const postDiv = document.createElement('div');
                postDiv.className = 'blog_content box-shadow mb-3';

                const link = document.createElement('a');
                link.href = 'blog/detalhe?postId='+post.id; 
                link.className = 'zoom_image mb-3';

                const img = document.createElement('img');
                img.src = 'assets/img/blog.jpg'; 
                img.alt = '';

                link.appendChild(img);
                
                const chamadaBlog = document.createElement('div');
                chamadaBlog.className = 'chamada_blog';

                const titulo = document.createElement('h3');
                titulo.textContent = post.titulo; 

                const conteudo = document.createElement('p');
                conteudo.textContent = post.conteudo.substring(0, 27) + (post.conteudo.length > 27 ? '...' : '');

                chamadaBlog.appendChild(titulo);
                chamadaBlog.appendChild(conteudo);

                postDiv.appendChild(link);
                postDiv.appendChild(chamadaBlog);

                colDiv.appendChild(postDiv);

                postContainer.appendChild(colDiv);
            });

            const paginationDiv = document.createElement('div');
            paginationDiv.className = 'col-12 my-3';

			paginationDiv.innerHTML = `
                <nav aria-label="Paginação">
                    <ul class="pagination justify-content-center">
                        <li class="page-item ${res.data.pagina === 1 ? 'disabled' : ''}">
                            <a class="page-link cursor-pointer" tabindex="-1" id="btnAnterior">Anterior</a>
                        </li>
                        ${Array.from({ length: res.data.totalPaginas }, (_, i) => `
                            <li class="page-item ${res.data.pagina === i + 1 ? 'active' : ''}">
                                <a class="page-link cursor-pointer pagination-btn"  data-page="${i + 1}">${i + 1}</a>
                            </li>
                        `).join('')}
                        <li class="page-item ${res.data.pagina === res.data.totalPaginas ? 'disabled' : ''}">
                            <a class="page-link cursor-pointer" id="btnProximo">Próximo</a>
                        </li>
                    </ul>
                </nav>
            `;

            postContainer.appendChild(paginationDiv); 

			document.getElementById('btnAnterior')?.addEventListener('click', function () {
                if (res.data.pagina > 1) {
                    listarPosts(null, +res.data.pagina - 1);
                }
            });

            document.getElementById('btnProximo')?.addEventListener('click', function () {
                if (res.data.pagina < res.data.totalPaginas) {
                    listarPosts(null, +res.data.pagina + 1);
                }
            });

            document.querySelectorAll('.pagination-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const pagina = this.getAttribute('data-page');
                    listarPosts(null, +pagina);
                });
            });
			
        })
        .catch(error => {
            console.error('Erro:', error);
        });
	}
    
    document.addEventListener('DOMContentLoaded', function() {
		listarPosts();

		document.getElementById('searchInput').addEventListener('input', function() {
			const titulo = this.value;
			listarPosts(titulo);
		});

		document.getElementById('btnBuscar').addEventListener('click', function() {
			const titulo = document.getElementById('searchInput').value;
			listarPosts(titulo);
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