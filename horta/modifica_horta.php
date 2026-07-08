<?php
$page_title = "Alterar horta";

include_once "../fachada.php";
$tela = 'hortas';
include "../verifica.php";

$id = @$_GET["id"];

$dao = $factory->getHortaDao();
$horta = $dao->buscaPorId($id);

$dao = $factory->getGerenciadorDao();
$gerenciadores = $dao->buscaTodos();

include_once "../layout_header.php";
 ?>
 <section class='container section-forms'>

    <form action="altera_horta.php" method="post" enctype="multipart/form-data" class="form-horta">

        <div class="campo-form">
            <label for="nome">Nome da horta</label>
            <input type='text' name='nome' value='<?php echo $horta->getNome();?>'/>
        </div>

        <div class="campo-form">
            <label for="descricao">Descrição da horta</label>
            <textarea
            name="descricao"
            id="descricao"
            class="form-control"
            rows="5"><?php echo $horta->getDescricao(); ?></textarea>
        </div>

        <input type="hidden" name="id" value="<?php echo $horta->getId(); ?>">
        <input type="hidden" name="id_gerenciador" value="<?php echo $horta->getGerenciador()->getId(); ?>">

        <div class="campo-form">
            <label>Escolha a localização</label>
            <div id="map"></div>

        <input type="hidden" name="latitude" id="latitude" value="<?php echo $horta->getLatitude(); ?>">
        <input type="hidden" name="longitude" id="longitude" value="<?php echo $horta->getLongitude(); ?>">
        </div>

        <div class="campo-form">
            <label for="Arquivo">Imagem da horta</label>
            <p>Imagem atual: <?php echo $horta->getImagem();?><p>
            <input type="file" name="Arquivo" id="Arquivo" class="form-control-file" value="<?php echo $horta->getImagem();?>">
        </div>

        <div class="acoes-form">
            <input type="reset" value="Limpar" class="btn btn-secondary">
            <button type="submit" class="btn btn-primary">Inserir</button>
            <a href='hortas.php' class='btn btn-primary left-margin'>Cancela</a>
        </div>

    </form>
</section>

<?php
if (isset($_GET['erro']) && $_GET['erro'] === 'nao-preenchimento') {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Erro ao adicionar horta',
            text: 'Você precisa preencher todos os campos para adicionar uma horta!',
            customClass: {
            popup: 'pop-up',
			confirmButton: 'btn-vermelho'
        }
        });
    </script>";
}

if (isset($_GET['erro']) && $_GET['erro'] === 'nao-selecionou-arquivo') {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Erro ao adicionar horta',
            text: 'Você precisa adicionar uma foto à sua horta!',
            customClass: {
            popup: 'pop-up',
			confirmButton: 'btn-vermelho'
        }
        });
    </script>";
}
?>

<?php
include_once "../layout_footer.php";
?>

<script src="https://unpkg.com/imask"></script>

<script>

    var map = L.map('map').setView([-29.1678, -51.1794], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var marker;



    // Função para criar ou mover marcador
    function setMarker(latlng) {
        if (marker) {
            marker.setLatLng(latlng);
        } else {
            marker = L.marker(latlng, { draggable: true }).addTo(map);

            marker.on('dragend', function(e) {
                var pos = e.target.getLatLng();
                atualizarInputs(pos.lat, pos.lng);
            });
        }

        marker.bindPopup("Local da horta").openPopup();
        atualizarInputs(latlng.lat, latlng.lng);
    }

    // Clique no mapa
    map.on('click', function(e) {
        setMarker(e.latlng);
    });

    // Geolocalização do usuário
    function usarLocalizacao() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;

                    var latlng = L.latLng(lat, lng);

                    map.setView(latlng, 16);
                    setMarker(latlng);
                },
                function(error) {
                    alert("Não foi possível obter sua localização.");
                }
            );
        } else {
            alert("Geolocalização não suportada pelo navegador.");
        }
    }
</script>


