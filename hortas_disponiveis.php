<?php
//include "verifica.php";

$page_title = "Hortas disponíveis";
include_once "layout_header.php";
?>

<section class='container pagina-hortas'>
  <input name='nome' type='text' class='filtrar form-control' id='palavra' autocomplete='off' placeholder='Filtrar por nome...'>

  <div class='horta-grid' id='hortas_fetch'></div>

  <div class='paginacao-container' id='paginacao'></div>
</section>

<script>
$(document).ready(function(){
  load_data(1,'',12);

  function load_data(page, query = '', limit) {
    $.ajax({
      url: "fetch_dao.php",
      method: "POST",
      data: { page: page, query: query , limit: limit},
      success: function(data) {
        var tempDiv = $('<div>').html(data);
        $('#hortas_fetch').html(tempDiv.find('.horta-card'));
        $('#paginacao').html(tempDiv.find('#paginacao-separada').html());
      }
    });
  }

  $(document).on('click', '.page-link', function(){
    var page = $(this).data('page_number');
    var query = $('#palavra').val();
    load_data(page, query, 12);
  });

  $('#palavra').keyup(function(){
    var query = $(this).val();
    load_data(1, query, 12);
  });
});


</script>

<?php include_once "layout_footer.php"; ?>
