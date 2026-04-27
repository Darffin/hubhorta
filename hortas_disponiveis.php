<?php
//include "verifica.php";

$page_title = "Hortas disponíveis";
include_once "layout_header.php";
include_once "fachada.php";

$dao = $factory->getHortaDao(); 
$hortas = $dao->buscaTodos();   
$hortas_array = [];

foreach ($hortas as $h) {
  $hortas_array[] = [
  "id" => $h->getId(),
  "nome" => $h->getNome(),
  "latitude" => $h->getLatitude(),
  "longitude" => $h->getLongitude()
  ];
}
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

    console.log(hortas);
    var hortas = <?php echo json_encode($hortas_array, JSON_UNESCAPED_UNICODE); ?>;

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(mapa);

    var bounds = [];

    hortas.forEach(function(horta) {

        var lat = parseFloat(horta.latitude);
        var lng = parseFloat(horta.longitude);

        if (!isNaN(lat) && !isNaN(lng)) {

            var marker = L.marker([lat, lng]).addTo(mapa);

            marker.bindPopup(
                "<b>" + (horta.nome || "Sem nome") + "</b><br>ID: " + horta.id
            );

            bounds.push([lat, lng]);
        }
    });

    if (bounds.length > 0) {
        mapa.fitBounds(bounds);
    }
</script>

<?php include_once "layout_footer.php"; ?>
