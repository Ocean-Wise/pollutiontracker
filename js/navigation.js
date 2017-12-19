/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */


function safeRead() {
	var current, formatProperty, obj, prop, props, val, _i, _len;

	obj = arguments[0], props = 2 <= arguments.length ? [].slice.call(arguments, 1) : [];

	read = function(obj, prop) {
		if ((obj != null ? obj[prop] : void 0) == null) {
			return;
		}
		return obj[prop];
	};

	current = obj;
	for (_i = 0, _len = props.length; _i < _len; _i++) {
		prop = props[_i];

		if (typeof (val = read(current, prop)) !== 'undefined') {
			current = val;
		} else {
			return null;
		}
	}
	return current;
};

(function($) {
	jQuery(document).ready(function () {

        if ($('.et_builder_inner_content .et_pb_section:first-of-type').hasClass('et_pb_fullwidth_section')) $('body').addClass('fullwidth-header');

        var container, button, menu, links, i, len;
		$(document).on('click', '.burger', function () {
			$('body').toggleClass('show-main-nav');
		});

        // Hello bar
        $(document).ready(function() {
            $('.hello-bar-btn').click(function(){
                $('#hello-bar-toggle').toggleClass( "hello-bar-btn-open hello-bar-btn-closed" );
                $('.hello-bar-menu').toggleClass( "hello-bar-menu-closed hello-bar-menu-open" );
            });
        });

        $(document).on('scroll', function(e){
            $('body').toggleClass('scrolled', ($(this).scrollTop() > 50));
        });
        $(document).trigger('scroll');

		$(document).on('click', '.main-navigation-mobile .close', function (e) {
			e.preventDefault();
			$('body').removeClass('show-main-nav');
		});

		$('.tooltip').tooltipster({
			theme:'tooltipster-shadow',
			contentAsHTML: true,
			side: ['bottom', 'top', 'left', 'right'],
			trigger: 'hover',
			distance: -10,
            functionInit: function(instance, helper){

                var $origin = $(helper.origin),
                    dataOptions = $origin.attr('data-tooltipster');

                if(dataOptions){

                    dataOptions = JSON.parse(dataOptions);

                    $.each(dataOptions, function(name, option){
                        instance.option(name, option);
                    });
                }
            }

		});

		$(document).on('click', '.toMapSection', function(e) {
			e.preventDefault();
            document.querySelector('#map-section').scrollIntoView({
                behavior: 'smooth',
				block: 'center'
            });
        });

		$('.tooltip-ajax').tooltipster({
			theme:'tooltipster-shadow',
			side: ['bottom', 'top', 'left', 'right'],
			updateAnimation: null,
			content: null,
			contentAsHTML: true,
			distance: -10,
			trigger: 'hover',


			// 'instance' is basically the tooltip. More details in the "Object-oriented Tooltipster" section.
			functionBefore: function(instance, helper) {

				var $origin = $(helper.origin);

				// we set a variable so the data is only loaded once via Ajax, not every time the tooltip opens
				if ($origin.data('loaded') !== true) {

					var contaminant_id = $origin.attr('data-contaminant-id');
					var site_id = $origin.attr('data-site-id');
					var source_id = $origin.attr('data-source-id');

					if (contaminant_id) {

						var data = {
							action: 'get_contaminant_details',
							contaminant_id: contaminant_id,
							site_id: site_id,
							source_id: source_id
						};
						// We can also pass the url value separately from ajaxurl for front end AJAX implementations
						$.get(ajax_object.ajax_url, data, function (data) {
							//alert('Got this from the server: ' + data);

							// call the 'content' method to update the content of our tooltip with the returned data.
							// note: this content update will trigger an update animation (see the updateAnimation option)
							instance.content(data);

							// to remember that the data has been loaded
							$origin.data('loaded', true);
						});


						/*
						 $.get('http://example.com/ajax.php', function(data) {

						 // call the 'content' method to update the content of our tooltip with the returned data.
						 // note: this content update will trigger an update animation (see the updateAnimation option)
						 instance.content(data);

						 // to remember that the data has been loaded
						 $origin.data('loaded', true);
						 });
						 */
					}
				}
			}
		});
	});
})(jQuery);