
<link rel="stylesheet" type="text/css" href="./assets/plugins/chosen/chosen.min.css">
<script type="text/javascript" src="./assets/plugins/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript">
	var config = {
        '.chosen-select'           : {width: '100%'}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>
