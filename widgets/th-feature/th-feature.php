<?php
/*
Widget Name: Themovation Feature
Description: A featured content block. Includes photo, heading, text and more.
Author: Themovation
Author URI: themovation.com
*/

class Themovation_SO_WB_Feature_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(

			'th-feature',

			__('Themovation Feature', 'themovation-widgets'),

			array(
				'description' => __('A featured content block. Includes photo, heading, text and more.', 'themovation-widgets'),
				'help'        => '',
			),

			array(
			),

			array(
				'image' => array(
					'type' => 'media',
					'fallback' => false,
					'label' => __('Image', 'themovation-widgets'),
					'default'     => '',
					'library' => 'image',
				),

				'icon' => array(
					'type' => 'widget',
					'class' => 'Themovation_SO_WB_Icon_Widget',
					'label' => __('Icon', 'themovation-widgets'),
					'hide' => false
				),

				'title' => array(
					'type' => 'text',
					'label' => __('Title', 'themovation-widgets'),
					'placeholder' => __('Enter title here', 'themovation-widgets'),
				),

				'content' => array(
					'type' => 'tinymce',
					'label' => __('Content', 'themovation-widgets'),
					'default' => '',
					'rows' => 10,
					'default_editor' => 'tinymce',
					'button_filters' => array(
						'mce_buttons' => array( $this, 'filter_mce_buttons' ),
						'mce_buttons_2' => array( $this, 'filter_mce_buttons_2' ),
						'mce_buttons_3' => array( $this, 'filter_mce_buttons_3' ),
						'mce_buttons_4' => array( $this, 'filter_mce_buttons_5' ),
						'quicktags_settings' => array( $this, 'filter_quicktags_settings' ),
					),
				),

				'link' => array(
					'type' => 'widget',
					'class' => 'Themovation_SO_WB_Link_Widget',
					'label' => __('Link', 'themovation-widgets'),
					'hide' => false
				),

				'background' => array(
					'type' => 'section',
					'label' => __('Background' , 'themovation-widgets'),
					'hide' => true,
					'fields' => array(

						'color' => array(
							'type' => 'color',
							'label' => __('Background Color', 'themovation-widgets'),
						),

						'contrast'    => array(
							'type'    => 'radio',
							'default' => 'dark',
							'label'   => __('Text Contrast', 'themovation-widgets'),
							'options' => array(
								'dark' => __('Dark Text', 'themovation-widgets'),
								'light' => __('Light Text', 'themovation-widgets'),
							),
						),
					)
				)
			),

			plugin_dir_path(__FILE__)
		);
	}

	function get_template_name($instance) {
		return 'feature';
	}

	function get_style_name($instance) {
		return '';
	}

	function enqueue_frontend_scripts( $instance ) {

		wp_enqueue_style( 'themo-feature', siteorigin_widget_get_plugin_dir_url('th-feature') . 'styles/feature.css', array(), INKED_SO_WIDGETS );

		parent::enqueue_frontend_scripts( $instance );
	}
}
siteorigin_widget_register('th-feature', __FILE__, 'Themovation_SO_WB_Feature_Widget');
