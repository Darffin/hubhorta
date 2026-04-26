<?php
//include "verifica.php";

$page_title = "Hortas disponíveis";
include_once "layout_header.php";
?>

<section class='container pagina-hortas'>
  <div style='display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;'>
    <input name='nome' type='text' class='filtrar form-control' id='palavra' autocomplete='off' placeholder='Filtrar por nome...'>
    <a href='horta/nova_horta.php' class='btn btn-primary' style='white-space: nowrap;'>Nova Horta</a>
  </div>
  <div class='horta-grid' id='hortas_fetch'></div>

  <div class="card-mapa">
    <div id="mapa" style="height: 500px;"></div>
  </div>

  <div class='paginacao-container' id='paginacao'></div>
</section>



<script>
    
    var mapa = L.map('mapa').setView([-29.1678, -51.1794], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(mapa);

    var marker = L.marker([-29.159945, -51.177010]).addTo(mapa);
    marker.bindPopup("<b>Horta Exemplo</b><br>Endereço da Horta").openPopup();

</script>

<?php include_once "layout_footer.php"; ?>
