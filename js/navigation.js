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
		var container, button, menu, links, i, len;
		$(document).on('click', '.burger', function () {
			$('body').toggleClass('show-main-nav');
		});

		$(document).on('click', '.main-navigation-mobile .close', function (e) {
			e.preventDefault();
			$('body').removeClass('show-main-nav');
		})

		$('.tooltip').tooltipster({theme:'tooltipster-shadow', contentAsHTML: true});
	});
})(jQuery);