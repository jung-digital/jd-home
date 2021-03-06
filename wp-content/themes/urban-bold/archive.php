<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">
					<div class="home-content-area">
						<ul class="blog-list">
							<header class="article-header">
									<?php if (is_category()) : ?>
										<h1 class="archive-title h2">
											<?php single_cat_title(); ?>
										</h1>

									<?php elseif (is_tag()) : ?>
										<h1 class="archive-title h2">
											<?php single_tag_title(); ?>
										</h1>

									<?php elseif (is_author()) :
										global $post;
										$author_id = $post->post_author;
									?>
										<h1 class="archive-title h2">
											<?php the_author_meta('display_name', $author_id); ?>
										</h1>

									<?php elseif (is_day()) : ?>
										<h1 class="archive-title h2">
											<?php the_time(get_option('date_format')); ?>
										</h1>

									<?php elseif (is_month()) : ?>
											<h1 class="archive-title h2">
												<?php the_time(get_option('date_format')); ?>
											</h1>

									<?php elseif (is_year()) : ?>
											<h1 class="archive-title h2">
												<?php the_time(get_option('date_format')); ?>
											</h1>
									<?php endif; ?>
							</header>
							
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			  						<?php get_template_part( 'home-post-format/home', get_post_format() ); ?>
			  				<?php endwhile;  ?>
			  				<?php endif; ?>
		     				<div class="clear"></div>
		     				<?php  urbanbold_page_navi(); ?>
							<?php wp_reset_postdata(); ?>

						</ul>
						<div id="sidebar5" class="sidebar m-all t-1of3 d-2of7 last-col cf" role="complementary">

							<?php if ( is_active_sidebar( 'sidebar5' ) ) : ?>

								<?php dynamic_sidebar( 'sidebar5' ); ?>

							<?php else : ?>

								<?php
									/*
									 * This content shows up if there are no widgets defined in the backend.
									*/
								?>

								<div class="no-widgets">
									<p><?php _e( 'This is a widget ready area. Add some and they will appear here.', 'urban-bold' );  ?></p>
								</div>

							<?php endif; ?>

						</div> <!-- sidebar -->
						<div class="clear"></div>
					</div><!-- content-area -->
				</div> <!-- inner-content -->

			</div>

<?php get_footer(); ?>