<?php
global $th_folio_count;
$folio_id = 'th-portfolio-' . ++$th_folio_count;

$column_number = $instance['columns'];
switch( $column_number ) {
	case 2:
		$portfolio_row = ' two-columns';
		$portfolio_item = array('th-portfolio-item', 'item', 'col-sm-6');
		break;
	case 3:
		$portfolio_row = ' three-columns';
		$portfolio_item = array('th-portfolio-item', 'item', 'col-md-4', 'col-sm-6');
		break;
	case 4:
		$portfolio_row = ' four-columns';
		$portfolio_item = array('th-portfolio-item', 'item', 'col-md-3', 'col-sm-6');
		break;
	case 5:
		$portfolio_row = ' five-columns';
		$portfolio_item = array('th-portfolio-item', 'item', 'col-md-2', 'col-sm-6');
		break;
	default:
		$portfolio_row = '';
		$portfolio_item = '';
}
?>

<div id="th-portfolio-content <?php echo $folio_id; ?>" class="th-portfolio">

	<?php if ( $instance['filter'] ) : ?>

		<div id="filters" class="th-portfolio-filters">
			<span><?php echo __( 'Sort:', 'themovation-widgets' ); ?></span>
			<a href="#" data-filter="*" class="current"><?php echo __( 'All', 'themovation-widgets' ); ?></a>

			<?php
			$taxonomy = 'themo_project_type';
			$tax_terms = get_terms( $taxonomy );

			foreach ( $tax_terms as $tax_term ) {
				echo '<a href="#" data-filter="#th-portfolio-content .p-' . $tax_term->slug . '">' . $tax_term->name .'</a>';
			}
			?>
		</div>

	<?php endif; ?>

	<div id="th-portfolio-row" class="th-portfolio-row row portfolio_content <?php echo $portfolio_row; ?>">

		<?php

		$args = array();

		if ( $instance['individual'] != 'none' ) {
			if ( is_array( $instance['individual'] ) ) {
				if ( in_array( 'none', $instance['individual'] ) ) {
					$instance['individual'] = array_diff( $instance['individual'], array('none') );
				}

				$post_ids = $instance['individual'];
			} else {
				$post_ids = array($instance['individual']);
			}
			$args['post__in'] = $post_ids;
		}

		$args['post_type'] = array( 'themo_portfolio' );

		if ( $instance['group'] != 'none' ) {
			if ( is_array( $instance['group'] ) ) {
				if ( in_array( 'none', $instance['group'] ) ) {
					$instance['group'] = array_diff( $instance['group'], array('none') );
				}

				$project_type_id = $instance['group'];
			} else {
				$project_type_id = array($instance['group']);
			}
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'themo_project_type',
					'field'    => 'term_id',
					'terms'    => $project_type_id,
				),
			);
		}

		if ( $instance['order'] == 'date' ) {
			$args['orderby'] = 'date';
		} elseif ( $instance['order'] == 'menu_order' ) {
			$args['orderby'] = 'menu_order';
			$args['order'] = 'ASC';
		}

		// The Query
		$query = new WP_Query( $args );

		// The Loop
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();

				$terms = get_the_terms( $post->ID, 'themo_project_type' );

				if ( $terms && ! is_wp_error( $terms ) ) :

					$filtering_links = array();

					foreach ( $terms as $term ) {
						$filtering_links[] = 'p-' . $term->slug;
					}

				endif;

				$classes = array_merge( $portfolio_item, $filtering_links );
				?>
				<div id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
					<div class="th-port-wrap">
						<?php the_post_thumbnail(); ?>
						<div class="th-port-overlay"></div>
						<div class="th-port-inner">
							<div class="th-port-center">
								<i class="th-port-icon glyphicons glyphicons-lightbulb"></i>
								<h3 class="th-port-title"><?php the_title(); ?></h3>
								<p class="th-port-sub">Malesuada tortor nunc</p>
							</div>
							<a class="th-port-link" href="#"></a>
						</div>
					</div>
				</div>
				<?php
			}
		} else {
			echo '<div class="alert">';
			_e('Sorry, no results were found.', 'themovation-widgets');
			echo '</div>';
			get_search_form();
		}

		// Restore original Post Data
		wp_reset_postdata();
		?>

	</div>

</div><!-- #th-portfolio-content -->

<!-- 4 column example -->

<div id="th-portfolio-content" class="th-portfolio">

	<div id="filters" class="th-portfolio-filters">
		<span>Sort:</span>
		<a href="#" data-filter="*" class="current">All</a>
		<a href='#' data-filter='#th-portfolio-content .p-collaboration'>Collaboration</a>
		<a href='#' data-filter='#th-portfolio-content .p-development'>Development</a>
		<a href='#' data-filter='#th-portfolio-content .p-integration'>Integration</a>
	</div>

	<div id="th-portfolio-row" class="th-portfolio-row row portfolio_content four-columns">

		<div id="post-130" class=" th-portfolio-item item col-md-3 col-sm-6 p-development p-integration post-130 status-publish format-standard has-post-thumbnail hentry themo_project_type-development themo_project_type-integration">
			<div class="th-port-wrap">
				<img width="500" height="500" src="http://stratus-3c99.kxcdn.com/stratus/wp-content/uploads/2015/03/office-800-380x380.jpg" class="img-responsive th-port-img wp-post-image" alt="Office" srcset="http://stratus-3c99.kxcdn.com/stratus/wp-content/uploads/2015/03/office-800-380x380.jpg 380w, http://demo.themovation.com/stratus/wp-content/uploads/2015/03/office-800-150x150.jpg 150w, http://demo.themovation.com/stratus/wp-content/uploads/2015/03/office-800-180x180.jpg 180w, http://demo.themovation.com/stratus/wp-content/uploads/2015/03/office-800-300x300.jpg 300w, http://demo.themovation.com/stratus/wp-content/uploads/2015/03/office-800-60x60.jpg 60w" sizes="(max-width: 380px) 100vw, 380px" />
				<div class="th-port-overlay"></div>
				<div class="th-port-inner">
					<div class="th-port-center">
						<i class="th-port-icon glyphicons glyphicons-lightbulb"></i>
						<h3 class="th-port-title">Idea Collaboration</h3>
						<p class="th-port-sub">Malesuada tortor nunc</p>
					</div>
					<a class="th-port-link" href="#"></a>
				</div>
			</div>
		</div>

		<div id="post-121" class=" th-portfolio-item item col-md-3 col-sm-6 p-collaboration p-development p-integration post-121 status-publish format-standard has-post-thumbnail hentry themo_project_type-collaboration themo_project_type-development themo_project_type-integration">
			<div class="th-port-wrap">
				<img width="500" height="500" src="http://stratus-3c99.kxcdn.com/stratus/wp-content/uploads/2015/03/person-woman-hand-space-380x380.jpg" class="img-responsive th-port-img wp-post-image" alt="" srcset="http://stratus-3c99.kxcdn.com/stratus/wp-content/uploads/2015/03/person-woman-hand-space-380x380.jpg 380w, http://demo.themovation.com/stratus/wp-content/uploads/2015/03/person-woman-hand-space-150x150.jpg 150w, http://demo.themovation.com/stratus/wp-content/uploads/2015/03/person-woman-hand-space-180x180.jpg 180w, http://demo.themovation.com/stratus/wp-content/uploads/2015/03/person-woman-hand-space-300x300.jpg 300w, http://demo.themovation.com/stratus/wp-content/uploads/2015/03/person-woman-hand-space-600x600.jpg 600w, http://demo.themovation.com/stratus/wp-content/uploads/2015/03/person-woman-hand-space-60x60.jpg 60w" sizes="(max-width: 380px) 100vw, 380px" />
				<div class="th-port-overlay"></div>
				<div class="th-port-inner">
					<div class="th-port-center">
						<i class="th-port-icon glyphicons glyphicons-iphone"></i>
						<h3 class="th-port-title">Mobile Marketing</h3>
						<p class="th-port-sub">Vitae est tincidunt</p>
					</div>
					<a class="th-port-link" href="#"></a>
				</div>
			</div>
		</div>

		<div id="post-128" class=" th-portfolio-item item col-md-3 col-sm-6 p-development p-integration post-128 status-publish format-standard has-post-thumbnail hentry themo_project_type-development themo_project_type-integration">
			<div class="th-port-wrap">
				<img width="500" height="500" src="http://stratus-3c99.kxcdn.com/stratus/wp-content/uploads/2015/02/8865586006_560677ac33_o-380x380.jpg" class="img-responsive th-port-img wp-post-image" alt="" srcset="http://stratus-3c99.kxcdn.com/stratus/wp-content/uploads/2015/02/8865586006_560677ac33_o-380x380.jpg 380w, http://demo.themovation.com/stratus/wp-content/uploads/2015/02/8865586006_560677ac33_o-150x150.jpg 150w, http://demo.themovation.com/stratus/wp-content/uploads/2015/02/8865586006_560677ac33_o-180x180.jpg 180w, http://demo.themovation.com/stratus/wp-content/uploads/2015/02/8865586006_560677ac33_o-300x300.jpg 300w, http://demo.themovation.com/stratus/wp-content/uploads/2015/02/8865586006_560677ac33_o-600x600.jpg 600w, http://demo.themovation.com/stratus/wp-content/uploads/2015/02/8865586006_560677ac33_o-60x60.jpg 60w" sizes="(max-width: 380px) 100vw, 380px" />
				<div class="th-port-overlay"></div>
				<div class="th-port-inner">
					<div class="th-port-center">
						<i class="th-port-icon glyphicons glyphicons-search"></i>
						<h3 class="th-port-title">Procedural Testing</h3>
						<p class="th-port-sub">Vitae laoreet sollicitudin</p>
					</div>
					<a class="th-port-link" href="#"></a>
				</div>
			</div>
		</div>

		<div id="post-119" class=" th-portfolio-item item col-md-3 col-sm-6 p-collaboration p-integration post-119 status-publish format-standard has-post-thumbnail hentry themo_project_type-collaboration themo_project_type-integration">
			<div class="th-port-wrap">
				<img width="500" height="500" src="http://stratus-3c99.kxcdn.com/stratus/wp-content/uploads/2015/03/watch-unboxing-380x380.jpg" class="img-responsive th-port-img wp-post-image" alt="Open" srcset="http://stratus-3c99.kxcdn.com/stratus/wp-content/uploads/2015/03/watch-unboxing-380x380.jpg 380w, http://demo.themovation.com/stratus/wp-content/uploads/2015/03/watch-unboxing-150x150.jpg 150w, http://demo.themovation.com/stratus/wp-content/uploads/2015/03/watch-unboxing-180x180.jpg 180w, http://demo.themovation.com/stratus/wp-content/uploads/2015/03/watch-unboxing-300x300.jpg 300w, http://demo.themovation.com/stratus/wp-content/uploads/2015/03/watch-unboxing-600x600.jpg 600w, http://demo.themovation.com/stratus/wp-content/uploads/2015/03/watch-unboxing-60x60.jpg 60w" sizes="(max-width: 380px) 100vw, 380px" />
				<div class="th-port-overlay"></div>
				<div class="th-port-inner">
					<div class="th-port-center">
						<i class="th-port-icon glyphicons glyphicons-shopping-cart"></i>
						<h3 class="th-port-title">Product Development</h3>
						<p class="th-port-sub">Sollic itudin</p>
					</div>
					<a class="th-port-link" href="#"></a>
				</div>
			</div>
		</div>

		<div id="post-123" class=" th-portfolio-item item col-md-3 col-sm-6 p-collaboration p-development post-123 status-publish format-standard has-post-thumbnail hentry themo_project_type-collaboration themo_project_type-development">
			<div class="th-port-wrap">
				<img width="500" height="500" src="http://stratus-3c99.kxcdn.com/stratus/wp-content/uploads/2015/03/HNCK5658-380x380.jpg" class="img-responsive th-port-img wp-post-image" alt="Workspace" srcset="http://stratus-3c99.kxcdn.com/stratus/wp-content/uploads/2015/03/HNCK5658-380x380.jpg 380w, http://demo.themovation.com/stratus/wp-content/uploads/2015/03/HNCK5658-150x150.jpg 150w, http://demo.themovation.com/stratus/wp-content/uploads/2015/03/HNCK5658-180x180.jpg 180w, http://demo.themovation.com/stratus/wp-content/uploads/2015/03/HNCK5658-300x300.jpg 300w, http://demo.themovation.com/stratus/wp-content/uploads/2015/03/HNCK5658-600x600.jpg 600w, http://demo.themovation.com/stratus/wp-content/uploads/2015/03/HNCK5658-60x60.jpg 60w" sizes="(max-width: 380px) 100vw, 380px" />
				<div class="th-port-overlay"></div>
				<div class="th-port-inner">
					<div class="th-port-center">
						<i class="th-port-icon glyphicons glyphicons-charts"></i>
						<h3 class="th-port-title">Growth Strategies</h3>
						<p class="th-port-sub">Donec volutpat sapien</p>
					</div>
					<a class="th-port-link" href="#"></a>
				</div>
			</div>
		</div>

		<div id="post-126" class=" th-portfolio-item item col-md-3 col-sm-6 p-collaboration p-integration post-126 status-publish format-standard has-post-thumbnail hentry themo_project_type-collaboration themo_project_type-integration">
			<div class="th-port-wrap">
				<img width="500" height="500" src="http://stratus-3c99.kxcdn.com/stratus/wp-content/uploads/2015/03/FSPLFPQBCZ-380x380.jpg" class="img-responsive th-port-img wp-post-image" alt="FSPLFPQBCZ" srcset="http://stratus-3c99.kxcdn.com/stratus/wp-content/uploads/2015/03/FSPLFPQBCZ-380x380.jpg 380w, http://demo.themovation.com/stratus/wp-content/uploads/2015/03/FSPLFPQBCZ-150x150.jpg 150w, http://demo.themovation.com/stratus/wp-content/uploads/2015/03/FSPLFPQBCZ-180x180.jpg 180w, http://demo.themovation.com/stratus/wp-content/uploads/2015/03/FSPLFPQBCZ-300x300.jpg 300w, http://demo.themovation.com/stratus/wp-content/uploads/2015/03/FSPLFPQBCZ-600x600.jpg 600w, http://demo.themovation.com/stratus/wp-content/uploads/2015/03/FSPLFPQBCZ-60x60.jpg 60w" sizes="(max-width: 380px) 100vw, 380px" />
				<div class="th-port-overlay"></div>
				<div class="th-port-inner">
					<div class="th-port-center">
						<i class="th-port-icon glyphicons glyphicons-credit-card"></i>
						<h3 class="th-port-title">Platform Integration</h3>
						<p class="th-port-sub">Aenean id turpis</p>
					</div>
					<a class="th-port-link" href="#"></a>
				</div>
			</div>
		</div>

	</div>

</div>
