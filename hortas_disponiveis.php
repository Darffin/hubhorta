<?php
//include "verifica.php";

$page_title = "Hortas disponíveis";
include_once "layout_header.php";
?>

<section class='container pagina-hortas'>
  <input name='nome' type='text' class='filtrar form-control' id='palavra' autocomplete='off' placeholder='Filtrar por nome...'>

  <div class='horta-grid' id='hortas_fetch'></div>

  <div class="card-mapa">
    <div id="mapa" style="height: 500px;"></div>
  </div>

  <div class='paginacao-container' id='paginacao'></div>
</section>



<script>
    // Inicializa o mapa
    var mapa = L.map('mapa').setView([-29.1678, -51.1794], 13); // Coordenadas de São Paulo

    // Adiciona a camada de mapa (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(mapa);

    // Exemplo de marcador para uma horta
    var marker = L.marker([-29.1678, -51.1794]).addTo(mapa);
    marker.bindPopup("<b>Horta Exemplo</b><br>Endereço da Horta").openPopup();
</script>

<?php include_once "layout_footer.php"; ?>
