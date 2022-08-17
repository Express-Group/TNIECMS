<!DOCTYPE html>
<html lang="en">
<head>
  <title>ck Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script  src="https://images.newindianexpress.com/includes/ckeditor5-master/ckeditor5-build-classic/ckeditor.js"></script>
  <script src="https://cdn.ckeditor.com/ckeditor5/22.0.0/classic/ckeditor.js"></script>
</head>
<body>

  
<div class="container">
  <div class="row">
    <div class="col-sm-12">
    <div id="editor">
	</div>
    </div>
 
  </div>
  <script type="module">
  import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
  </script>
   <script>
  ClassicEditor
    .create( document.querySelector( '#editor' ) ,{
	
	}
	
	)
    .then( editor => {
        console.log( editor );
    } )
    .catch( error => {
        console.error( error );
    } );
	console.log(ClassicEditor.builtinPlugins.map( plugin => plugin.pluginName ));
  </script>
</div>

</body>
</html>
 