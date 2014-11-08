<!DOCTYPE>
<html>
<head>
<meta charset="UTF-8">
<title>Buscador</title>

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="css/screen.css">

  <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400|Rajdhani:300,400|Lato:300,400|Roboto+Condensed:400,300|Raleway:400,300' rel='stylesheet' type='text/css'>
</head>
<body>
  <div id="loading" style="display: none;">
    <img src="img/loading.gif" alt="">
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <h1 class="title center">Buscador</h1>
        
        <div class="wrapper">
          <h4 class="header-text">Digite o que procura</h4>
          <form class="search" action="search.php" method="post">
            <input class="form-control consulta" type="text" name="query">
            <input class="btn btn-success buscar" type="submit" value="Buscar">
          </form>
        </div>
      </div>
    </div>

    <div class="row resultado">

      <div class="col-md-8 col-md-offset-2">

      </div>
    </div>

  </div>
</body>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>

<script>
  $(function () {
    
    $('.search').on('submit', function(e){
      e.preventDefault();
      var query = $('.consulta').val();

      $.ajax({
          url: 'search.php',
          type: 'post',
          dataType: 'json',
          data: {
            query: query
          },
          success: function (data) {
            $('.resultado .col-md-8').html("");
            $('.resultado .col-md-8').append("<div class=\"total\">Resultados Encontrados: " + data.total + "</div>");
            
            $('.resultado .col-md-8').append(data.html);
            
          }
        });
    });

    $(document).on({
      ajaxStart: function() { $('#loading').show(); },
      ajaxStop: function() { $('#loading').hide(); }    
    });

  });
</script>

</html>