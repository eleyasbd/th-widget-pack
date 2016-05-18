<?php
/*
Widget Name: Themovation Google Map
Description:
Author: Themovation
Author URI: themovation.com
*/

class Themovation_SO_WB_Maps_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(

			'th-maps',

			__('Themovation Google Map', 'themovation-widgets'),

			array(
				'description' => __('Add a Google Map widget.', 'themovation-widgets'),
				'help'        => '',
			),

			array(
			),

			array(
				'map' => array(
					'type' => 'widget',
					'class' => 'SiteOrigin_Widget_GoogleMap_Widget',
					'label' => __('SiteOrigin Google Maps Widget', 'themovation-widgets'),
				),
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
siteorigin_widget_register('th-maps', __FILE__, 'Themovation_SO_WB_Maps_Widget');
