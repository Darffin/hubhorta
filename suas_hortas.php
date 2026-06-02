<?php
include "verifica.php";

$page_title = "Hortas disponíveis";
include_once "layout_header.php";
include_once "fachada.php";

$dao = $factory->getUsuarioDao(); 
$hortas = $dao->buscaHortasDeUmUsuario($_SESSION['id_usuario']);

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
            `<h2>${horta.nome || "Sem nome"}</h2><br>
            ID: ${horta.id}<br><br>
            <a href="dashboard_horta.php?id=${horta.id}" 
               class="btn btn-primary">
               Acessar
            </a>
            <a href="#" onclick="desvoluntariar(${horta.id});"  
               class="btn btn-vermelho">
               Desvoluntariar
            </a>
            `
            
            );

            bounds.push([lat, lng]);
        }
    });

    if (bounds.length > 0) {
        mapa.fitBounds(bounds);
    }

    function desvoluntariar(id_horta) {
    $.ajax({
        url: "usuario/desvoluntariar.php",
        method: "POST",
        data: { id_horta: id_horta},
        success: function(response) {
            if(response.trim() === "sucesso") {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Você se desvoluntariou dessa horta!',
                    showConfirmButton: false,
                    timer: 1500,
                    backdrop: `rgba(255, 255, 255, 0)`,
                    customClass: { popup: 'pop-up' }
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Erro ao se desvoluntariar!',
                    showConfirmButton: false,
                    timer: 1500,
                    backdrop: `rgba(255, 255, 255, 0)`,
                    customClass: { popup: 'pop-up' }
                });
            }
        }
    });
}
</script>

<?php include_once "layout_footer.php"; ?>
