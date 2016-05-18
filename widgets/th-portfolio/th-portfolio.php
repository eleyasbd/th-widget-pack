<?php
/*
Widget Name: Themovation Portfolio
Description:
Author: Themovation
Author URI: themovation.com
*/

class Themovation_SO_WB_Portfolio_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(

			'th-portfolio',

			__('Themovation Portfolio', 'themovation-widgets'),

			array(
				'description' => __('Displays portfolio items with column and sort layout options.', 'themovation-widgets'),
				'help'        => '',
			),

			array(
			),

			array(
				// Fields go here
			),

			plugin_dir_path(__FILE__)
		);
	}

	function get_template_name($instance) {
		return '';
	}

	function get_style_name($instance) {
		return '';
	}
}
siteorigin_widget_register('th-portfolio', __FILE__, 'Themovation_SO_WB_Portfolio_Widget');
