<?php
    require_once "../../includes/header.php";
?>
<hr>
<br>
<div id="alertSuccess" class="alert alert-success" role="alert" style="display: none;">Post Salvo com Sucesso</div>
<div id="alertDanger" class="alert alert-danger" role="alert" style="display: none;">Nãp foi Possivel salvar este Post</div>
<h2>Formulario para adicionar Posts</h2>
<form id="postForm">
    <div class="form-group">
        <label for="codigo">Titulo:</label>
        <input type="text" class="form-control" id="txtTitulo" name="txtTitulo" required>
    </div>
    <div class="form-group">
        <label for="descricao">Conteudo do Post:</label>
        <textarea type="text" class="form-control" id="txtConteudo" name="txtConteudo" required></textarea>
    </div>
    <div class="form-group">
        <label for="status">Autor:</label>
        <input type="text" class="form-control" id="txtAutor" name="txtAutor" required>
    </div>
    <div class="form-group">
        <label for="garantia">Data Postagem:</label>
        <input type="text" class="form-control" id="txtDataPostagem" name="txtDataPostagem" required>
    </div>
    <br>
    <button type="submit" class="btn btn-primary" name="btnSalvarPost">Salvar</button>
    <button type="button" onclick="window.location.href = '/clinicmais/pages/blog/blog.php'" class="btn btn-danger">Voltar</button>
</form>
<br>
<hr>
<script type="module">
    import { fetchData } from '/clinicmais/pages/blog/request.js';
    
    function getValores() {
        const titulo = document.getElementById('txtTitulo').value;
        const conteudo = document.getElementById('txtConteudo').value;
        const autor = document.getElementById('txtAutor').value;
        const dataPostagem = document.getElementById('txtDataPostagem').value;

        const dados = {
            txtTitulo: titulo,
            txtConteudo: conteudo,
            txtAutor: autor,
            txtDataPostagem: dataPostagem
        };
        return dados;
    }
    
    document.addEventListener('DOMContentLoaded', function() {

        const url = new URL(window.location.href);

		const postId = +url.searchParams.get('postId');

        document.getElementById('postForm').addEventListener('submit', function(event) {
            event.preventDefault(); 
            
            
            if(!postId){    
                
                const dados = getValores();
                fetchData('/clinicmais/pages/blog/api/addPost.php', 'POST', dados)
                .then(res => {

                    document.getElementById('alertSuccess').style.display = 'block';
                    setTimeout(()=>{
                        document.getElementById('alertSuccess').style.display = 'none';
                    },5000);

                    document.getElementById('postForm').reset();
                })
                .catch(error => {
                    console.error('Erro:', error);
                    
                    document.getElementById('alertSuccess').style.display = 'block';
                    setTimeout(()=>{
                        document.getElementById('alertSuccess').style.display = 'none';
                    },5000);
                });
            }else{
                let dados = getValores();
                dados = {...dados, txtPostId : postId }
                console.log(dados)

                fetchData('/clinicmais/pages/blog/api/updatePost.php', 'PUT', dados)
                .then(res => {
                    console.log(res)
                    document.getElementById('alertSuccess').style.display = 'block';
                    setTimeout(()=>{
                        document.getElementById('alertSuccess').style.display = 'none';
                    },5000);

                })
                .catch(error => {
                    console.error('Erro:', error);
                    document.getElementById('alertSuccess').style.display = 'block';
                    setTimeout(()=>{
                        document.getElementById('alertSuccess').style.display = 'none';
                    },5000);
                });
            }
        });

        const dados = {
            txtPostId : postId
        }

        fetchData('/clinicmais/pages/blog/api/retornarPost.php', 'POST', dados)
        .then(res => {

            if (res.data) {
                document.getElementById('txtTitulo').value = res.data.titulo;
                document.getElementById('txtDataPostagem').value = res.data.data_postagem; 
                document.getElementById('txtAutor').value = res.data.autor;
                document.getElementById('txtConteudo').value = res.data.conteudo;
            }

        })
        .catch(error => {
            console.error('Erro:', error);
        });
    });
</script>

<?php
    require_once "../../includes/footer.php";
?>