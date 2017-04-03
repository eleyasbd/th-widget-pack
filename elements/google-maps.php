<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Themo_Widget_GoogleMaps extends Widget_Base {

	public function get_name() {
		return 'themo-google-maps';
	}

	public function get_title() {
		return __( 'Google Maps', 'elementor' );
	}

	public function get_icon() {
		return 'eicon-google-maps';
	}

	public function get_categories() {
		return [ 'themo-elements' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_map',
			[
				'label' => __( 'Map', 'elementor' ),
			]
		);

		$default_address = __( 'London Eye, London, United Kingdom', 'elementor' );
		$this->add_control(
			'address',
			[
				'label' => __( 'Map Address', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => $default_address,
				'default' => $default_address,
				'label_block' => true,
			]
		);

		// $this->add_control(
		// 	'address_lat',
		// 	[
		// 		'label' => __( 'Address Latitude', 'elementor' ),
		// 		'type' => Controls_Manager::HIDDEN,
		// 	]
		// );
		//
		// $this->add_control(
		// 	'address_lng',
		// 	[
		// 		'label' => __( 'Address Longitude', 'elementor' ),
		// 		'type' => Controls_Manager::HIDDEN,
		// 	]
		// );

		$this->add_control(
			'zoom',
			[
				'label' => __( 'Zoom Level', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
			]
		);

		$this->add_control(
			'api',
			[
				'label' => __( 'Google Maps API', 'elementor' ),
				'description' => __( '<a href="https://developers.google.com/maps/documentation/javascript/" target="_blank">Get an API key</a>', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'height',
			[
				'label' => __( 'Height', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 300,
				],
				'range' => [
					'px' => [
						'min' => 40,
						'max' => 1440,
					],
				],
			]
		);

		$this->add_control(
			'prevent_scroll',
			[
				'label' => __( 'Prevent Scroll', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => __( 'Yes', 'elementor' ),
				'label_off' => __( 'No', 'elementor' ),
				'selectors' => [
					'{{WRAPPER}} iframe' => 'pointer-events: none;',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'elementor' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_text_block',
			[
				'label' => __( 'Text Block', 'elementor' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'elementor' ),
				'default' => __( 'Company Co.', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'business_address',
			[
				'label' => __( 'Business Address', 'elementor' ),
				'default' => __( "1366 Main Street\nancouver Canada\nV8V 3K6", 'elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'hours',
			[
				'label' => __( 'Hours', 'elementor' ),
				'default' => __( "Monday to Friday: 10am - 6pm\nSaturday: 11am - 4pm\nSunday: Closed", 'elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'link_1_text',
			[
				'label' => __( 'Link 1 Text', 'elementor' ),
				'default' => __( 'Call Us', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'link_1_url',
			[
				'label' => __( 'Link 1 URL', 'elementor' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'http://your-link.com', 'elementor' ),
                'default' => [
                    'url' => 'tel:222-2222',
                ],
			]
		);

		$this->add_control(
			'link_2_text',
			[
				'label' => __( 'Link 2 Text', 'elementor' ),
                'default' => __( 'Email Us', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'link_2_url',
			[
				'label' => __( 'Link 2 URL', 'elementor' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'http://your-link.com', 'elementor' ),
                'default' => [
                    'url' => 'mailto:info@companyco.com',
                ],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();
		// global $th_map_id;
		// $map_id = 'th-map-' . ++$th_map_id;

		$map_id = 'map';

		if ( empty( $settings['address'] ) ) return;

		if ( 0 === absint( $settings['zoom']['size'] ) ) $settings['zoom']['size'] = 10;

		// url encode the address
		$address = urlencode( $settings['address'] );
		// google map geocode api url
		$url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key={$settings['api']}";
		// get the json response
		$resp_json = file_get_contents( $url );
		// decode the json
		$resp = json_decode( $resp_json, true );

		// response status will be 'OK', if able to geocode given address
		if ( $resp['status'] == 'OK' ) {
			// get the important data
			$settings['address_lat'] = $resp['results'][0]['geometry']['location']['lat'];
			$settings['address_lng'] = $resp['results'][0]['geometry']['location']['lng'];
		} else {
			return false;
		}
		?>

		<!-- <!DOCTYPE html>
		<html>
		  <head>
		    <style>
		       <?php echo $map_id ?> {
		        width: 100%;
		       }
		    </style>
		  </head>
		  <body>
		    <div id="<?php echo $map_id ?>"></div>
		    <script>
		      function initMap() {
		        var uluru = {lat: <?php echo $settings['address_lat'] ?>, lng: <?php echo $settings['address_lng'] ?>};
		        var map = new google.maps.Map(document.getElementById('<?php echo $map_id ?>'), {
		          zoom: <?php echo $settings['zoom']['size'] ?>,
		          center: uluru,
				  mapTypeId: 'hybrid',
				  disableDefaultUI: true
		        });
		      }
		    </script>
		    <script async defer
		    src="https://maps.googleapis.com/maps/api/js?key=<?php echo $settings['api'] ?>&callback=initMap">
		    </script>
		  </body>
		</html> -->
		<div class="th-google-map">
			<center>
				<img src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $address ?>&zoom=<?php echo $settings['zoom']['size'] ?>&size=1280x<?php echo $settings['height']['size'] ?>&scale=2&key=<?php echo $settings['api'] ?>" />
			</center>

			<div class="map-info">
				<h3><?php echo $settings['title']; ?></h3>
				<?php echo wpautop( $settings['business_address'] ); ?>
				<?php echo wpautop( $settings['hours'] ); ?>
				<?php if ( $settings['link_1_url'] ) : ?>
					<a href="<?php echo $settings['link_1_url']['url'] ?>">
						<?php echo $settings['link_1_text'] ?>
					</a>
				<?php endif; ?>
				<?php if ( $settings['link_2_url'] ) : ?>
					<a href="<?php echo $settings['link_2_url']['url'] ?>">
						<?php echo $settings['link_2_text'] ?>
					</a>
				<?php endif; ?>
			</div>
		</div>

		<style>
			.th-google-map {
				position: relative;
			}
			.map-info {
				background: #fff;
				padding: 25px;
				position: absolute;
				top: 50px;
				left: 50px;
			}
			.map-info a:last-child {
				padding-left: 20px;
			}
		</style>

		<?php
	}

	protected function _content_template() {}
}

Plugin::instance()->widgets_manager->register_widget_type( new Themo_Widget_GoogleMaps() );
