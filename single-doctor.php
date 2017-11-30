<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

get_header();
// require_once 'kint.php';
?>

<!-- #Content -->
<div id="Content" class="px-lg-2 py-lg-5" style="box-sizing:border-box;">
	<div class="content_wrapper single-doctor-content clearfix">

		<!-- .sections_group -->
		<div class="sections_group">

			<?php if( get_post_meta( get_the_ID(), 'mfn-post-template', true ) == 'builder' ):?>

				<?php
				$single_post_nav = array(
					'hide-sticky'	=> false,
					'in-same-term'	=> false,
				);

				$opts_single_post_nav = mfn_opts_get( 'prev-next-nav' );
				if( isset( $opts_single_post_nav['hide-sticky'] ) ){
					$single_post_nav['hide-sticky'] = true;
				}

				// single post navigation | sticky
				if( ! $single_post_nav['hide-sticky'] ){
					if( isset( $opts_single_post_nav['in-same-term'] ) ){
						$single_post_nav['in-same-term'] = true;
					}

					$post_prev = get_adjacent_post( $single_post_nav['in-same-term'], '', true );
					$post_next = get_adjacent_post( $single_post_nav['in-same-term'], '', false );

					echo mfn_post_navigation_sticky( $post_prev, 'prev', 'icon-left-open-big' );
					echo mfn_post_navigation_sticky( $post_next, 'next', 'icon-right-open-big' );
				}


				while( have_posts() ){
					the_post();							// Post Loop
					mfn_builder_print( get_the_ID() );	// Content Builder & WordPress Editor Content
				}
				?>

			<?php else: ?>

				<!-- Template | Builder -->

				<?php while (have_posts()) : the_post(); ?>

					<div class="container-wrapper">
						<div class="row">
							<div class="col-lg-5 col-12 left_wrapper">
								<?php the_post_thumbnail('342X368'); ?>
							</div>
							<div class="col right_wrapper">
								<h3 class="single-title mb-4"><?php the_title();?></h3>
								<?php
									$education = get_field_object('education');
									$experience = get_field_object('experience');
									$treatment = get_field_object('treatment');
								?>
								<div class="education_wrapper">
									<div class="field-label">
										<?php print $education['label']; ?>
									</div>
									<div class="field-items">
										<div class="field-item">
											<?php print $education['value']; ?>
										</div>
									</div>
								</div>

								<div class="experience_wrapper">
									<div class="field-label">
										<?php print $experience['label']; ?>
									</div>
									<div class="field-items">
										<div class="field-item">
											<?php print $experience['value']; ?>
										</div>
									</div>
								</div>
								<div class="body_wrapper">
									<?php the_content(); ?>
								</div>

								<div class="treatment_wrapper">
									<div class="field-label">
										<?php print $treatment['label']; ?>
									</div>
									<div class="field-items row">
										<?php foreach($treatment['value'] as $treatment_post): ?>
											<div class="field-item col-md-3 col-sm-6">
												<div class="referenced-entity treatment_node_type">

													<div class="icon">
														<?php $icon = get_field('icon_node', $treatment_post->ID); ?>
														<a href="<?php the_permalink($treatment_post->ID); ?>">
															<img src="<?php print $icon['url']?>" alt="<?php print $icon['alt']?>">
														</a>
													</div>

													<div class="title">
														<a href="<?php the_permalink($treatment_post->ID); ?>">
															<?php print $treatment_post->post_title; ?>
														</a>
													</div>

												</div>
											</div>
										<?php endforeach ?>
									</div>
								</div>
							</div>
						</div>
					</div>




					<?php //get_template_part( 'includes/content', 'single' ); ?>

				<?php endwhile; ?>

			<?php endif; ?>
		</div>

		<!-- .four-columns - sidebar -->
		<?php get_sidebar(); ?>

	</div>
</div>

<?php get_footer(); ?>
