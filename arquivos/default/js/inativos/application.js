(function(){

	'use strict';

	if(!('placeholder' in document.createElement('input'))) {

		$('[placeholder]').each(function() {

			var

				target = $(this);

			if(target.attr('value') == '') target.attr('value', target.attr('placeholder'));

			if(target.attr('value') == '') {

				if(target.attr('type') == 'password') target.attr('type', 'text').data('initial-type', 'password');

				target.attr('value', target.attr('placeholder'));

			}

		}).on({
			focus : function() {

				var

					target = $(this);

				if(target.val() == target.attr('placeholder')) {

					target.val('');

					if(target.data('initial-type') == 'password') target.attr('type', 'password');

				}

			},
			blur : function() {

				var

					target = $(this);

				if(target.val() == '') {

					if(target.attr('type') == 'password') target.attr('type', 'text');

					target.val(target.attr('placeholder'));

				}

			}
		});

	}

	$('[title]').tooltip({
		container : 'body'
	});

	$('#search .btn-search').on('click', function(event) {

		event.preventDefault();

		$('#search .control-group').fadeToggle();

	});

	$('#page-header .collapse').on('show', function() {

		$('#search .control-group').fadeOut();

	});

	$(window).on('load resize orientationchange', function() {

		if($(this).width() >= 480) {

			$('#search .control-group').fadeIn();

		} else $('#search .control-group').fadeOut();

	});

	$('[name="dia"],[name="mes"]').on('keyup', function() {

		if($(this).val().length == $(this).attr('maxlength')) $(this).nextAll('[name="dia"],[name="mes"],[name="ano"]').filter(':first').trigger('focus');

	});

	$('#prehome-page .slide').cycle();

	if(document.getElementById('editor')) {

		CKEDITOR.replace('editor', {
			toolbar : 'basic',
			uiColor: '#f1f1f1'
		});

	}

})();