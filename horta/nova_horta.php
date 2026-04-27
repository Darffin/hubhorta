<?php
$page_title = "Nova Horta";
// layout do cabeçalho
include_once "../layout_header.php";
include_once "../fachada.php";
$tela = 'hortas';
//include "../verifica.php";  ativar de novo quando tiver o login funcionando

$dao = $factory->getGerenciadorDao(); 
$gerenciadores = $dao->buscaTodos();


 ?>
 <section class='container section-forms'>
<form action="insere_horta.php" method="post" enctype="multipart/form-data">
    <table class='table table-hover table-responsive table-bordered'>
         <tr>
            <td>Nome</td>
            <td><input type='text' name='nome' class='form-control' /></td>
        </tr>

        <tr>
            <td>Localização</td>
            <td id="map" style="height: 150px;"></td>
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
            <!-- <form action="enviar.php" method="post" enctype="multipart/form-data"> -->
            <!--    <input type="file" name="Arquivo" id="Arquivo"> -->
            <!--    <input type="reset" value="Apagar"> -->
            <!-- </form> -->
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Inserir</button>
            </td>
        </tr>
    </table>
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

// layout do rodapé
include_once "../layout_footer.php";
?>
<script src="https://unpkg.com/imask"></script>


<script>
    // Inicializa mapa (centro em Porto Alegre)
    var map = L.map('map').setView([-29.1678, -51.1794], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var marker;

    // Função para atualizar inputs
    function atualizarInputs(lat, lng) {
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        document.getElementById('lat_view').value = lat;
        document.getElementById('lng_view').value = lng;
    }

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




