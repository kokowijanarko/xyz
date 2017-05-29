
<link rel="stylesheet" type="text/css" href="./assets/plugins/validetta/validetta.min.css">
<script type="text/javascript" src="./assets/plugins/validetta/validetta.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.validetta').validetta({
			showErrorMessages : true,
			display : 'inline', // bubble or inline
			errorTemplateClass : 'validetta-inline',
		});
	} );
</script>
