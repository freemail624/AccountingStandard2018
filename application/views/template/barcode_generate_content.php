<!DOCTYPE html>
<html>
<head>
	<title></title>
    <?php echo $_def_css_files; ?>
    <?php echo $_def_js_files; ?>

	<script type="text/javascript">
    	$(document).ready(function(){
        	var initializeControls=function(){
				var qty = $('#qty').html();

				for (i = 0; i < qty; i++) {	
					alert();
				}

        	}();
	    });
	</script>
</head>
<body>
	<div>
		<span id="unq_id"><?php echo $unq_id; ?></span>
		<span id="qty"><?php echo $qty; ?></span>
	</div>
</body>
</html>