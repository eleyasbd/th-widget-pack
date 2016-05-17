<?php
/*
Widget Name: Themovation Video Player
Description:
Author: Themovation
Author URI: themovation.com
*/

class Themovation_SO_WB_Video_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(

			'th-video',

			__('Themovation Video Player', 'themovation-widgets'),

			array(
				'description' => __('', 'themovation-widgets'),
				'help'        => '',
			),

			array(
			),

			array(
				'video' => array(
					'type' => 'widget',
					'class' => 'SiteOrigin_Widget_Video_Widget',
					'label' => __('SiteOrigin Video Widget', 'themovation-widgets'),
				),

				'webm' => array(
					'type' => 'media',
					'fallback' => false,
					'label' => __('Select webm video', 'themovation-widgets'),
					'default'     => '',
					'library' => 'file',
					'state_handler' => array(
						'video_type[self]' => array('show'),
						'video_type[external]' => array('hide'),
					)
				),

				'ovg' => array(
					'type' => 'media',
					'fallback' => false,
					'label' => __('Select ogv video', 'themovation-widgets'),
					'default'     => '',
					'library' => 'file',
					'state_handler' => array(
						'video_type[self]' => array('show'),
						'video_type[external]' => array('hide'),
					)
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
siteorigin_widget_register('th-video', __FILE__, 'Themovation_SO_WB_Video_Widget');
