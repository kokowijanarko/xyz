<link rel="stylesheet" type="text/css" href="./assets/plugins/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<script type="text/javascript" src="./assets/plugins/fancybox/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript">
	$(document).ready(function() {
		/*
		 *  Simple image gallery. Uses default settings
		 */

		$('.fancybox').fancybox({
			wrapCSS    : 'fancybox-custom',
			closeClick : true,

			openEffect : 'none',

			helpers : {
				title : {
					type : 'inside'
				}
			}
		});
	});
</script>
