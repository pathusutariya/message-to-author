(function( $ ) {
	'use strict';
	$(document).ready(function () {
		$(".google-captcha-check").change(function() {
			console.log("this");
			if(this.checked) {
				$('.google-captcha-config-box').addClass('active');
			}else if(!this.checked){
				$('.google-captcha-config-box').removeClass('active');
			}
		});
	});
})( jQuery );