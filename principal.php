<!DOCTYPE html>
<html>
    <head>
	<title>Pidelo por Maps</title>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxwbFVqKVoA8WR6wmqsoBsuUEc45OvP5g&sensor=false" ></script>
        <script src="lib/js/jquery.min.js"></script>
        <script type="text/javascript" src="lib/js/principal.js" ></script>
        <link rel="stylesheet" href="lib/css/principal.css" type="text/css" />
        <link rel="stylesheet" href="lib/css/bootstrap.min.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="lib/css/bootstrap-theme.min.css" type="text/css" />
        <script src="lib/js/bootstrap.min.js"></script>

        <script type="text/javascript">
            google.maps.event.addDomListener(window, 'load', initialize);
        </script>
    </head>
    <body>
	<div class="container-fluid">
	    <div class="row">
		<div class="col-md-10">
		    <h1>PIDELO CON MAPS</h1>
		</div>
		<div class="col-md-2 pull-right">
		    <h1><button class="btn btn-lg btn-primary">Facebook</button></h1>
		</div>
	    </div>
	    <div class="row">
		<div class="col-md-9">
		    <div id="map-canvas">
			
		    </div>
		</div>
		<div class="col-md-3">
		    <div class="panel panel-default">
		      <div class="panel-heading"><h4>USUARIOS</h4></div>
		      <div class="panel-body">
			...
		      </div>
		    </div>
		</div>
	    </div>
	</div>
    </body>
</html>



<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Ingrese sus Observaciones</h4>
            </div>
            <div class="modal-body">
                <textarea id="observaciones" class="form-control" rows="3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="save" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>