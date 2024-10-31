<?php
/**
 * Nice Testimonials by NiceThemes.
 *
 * This file contains general functions that can be used from the public side
 * of the plugin.
 *
 * @package Nice_Testimonials
 * @since   1.0
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! function_exists( 'nice_testimonials_output' ) ) :
/**
 * Build HTML output for the `testimonials` shortcode.
 *
 * @since 1.0
 *
 * @param  array  $atts Shortcode attributes.
 * @return string
 */
function nice_testimonials_output( $atts ) {
	$settings      = nice_testimonials_settings();
	$category_name = nice_testimonials_category_name();

	// Build query for taxonomies.
	$tax_query = array();
	if ( $atts['category'] ) {
		$tax_query[] = array(
			'taxonomy'         => $category_name,
			'field'            => 'id',
			'terms'            => explode( ',', $atts['category'] ),
			'include_children' => $settings['include_children'],
		);
	}
	if ( $atts['exclude_category'] ) {
		$tax_query[] = array(
			'taxonomy' => $category_name,
			'field'    => 'id',
			'terms'    => explode( ',', $atts['exclude_category'] ),
			'operator' => 'NOT IN',
		);
	}

	// Obtain query arguments.
	$query_args = $atts;
	$query_args['tax_query'] = $tax_query;
	$query_args = apply_filters( 'nice_testimonials_shortcode_query_args', $query_args );

	// Obtain generated output.
	$output = nice_get_testimonials( $query_args );
	$output = apply_filters( 'nice_testimonials_shortcode_output', $output );

	return $output;
}
endif;

if ( ! function_exists( 'nice_get_testimonials' ) ) :
/**
 * Basic template for testimonials.
 *
 * @since  1.0
 *
 * @param  array             $args
 * @return mixed|string|void
 */
function nice_get_testimonials( $args = array() ) {
	$output        = '';
	$category_name = nice_testimonials_category_name();

	// Obtain a list of testimonials from normalized arguments.
	$args  = nice_testimonials_normalize_args( $args );
	$posts = nice_testimonials_get_posts( $args );

	do_action( 'nice_testimonials_before_template', $args );

	if ( ! empty( $posts ) ) {
		// Initialize output.
		$output = $args['before'] . "\n";

		// Create basic template.
		$tpl = '
		<div class="nice-testimonial %%CLASS%%">
			<blockquote class="nice-testimonial-content">
				%%IMAGE%%
				%%CONTENT%%
			</blockquote>
			<cite class="nice-testimonial-author">%%TITLE%%</cite>
		</div>';
		$tpl = apply_filters( 'nice_testimonials_post_template', $tpl, $args );

		if ( apply_filters( 'nice_testimonials_post_use_container', true ) ) {
			$type = _nice_testimonials_doing_widget() ? 'widget' : 'grid';
			$data_columns = _nice_testimonials_doing_widget() ? '' : ' data-columns="' . esc_attr( intval( $args['columns'] ) ) . '"';
			$html_tag = _nice_testimonials_doing_widget() ? 'ul' : 'div';
			$output .= '<' . $html_tag . ' class="nice-testimonials ' . ( $args['avoidcss'] ? '' : 'default-styles ' ) . $type . '" ' . $data_columns . '>' . "\n";
		}

		$loop = 0;

		foreach ( $posts as $post ) {
			// Continue if post is not valid.
			if ( ! $post instanceof WP_Post ) {
				continue;
			}

			$loop++;

			$template = $tpl;

			// Obtain custom fields
			$testimonial_meta = nice_testimonials_get_post_meta( $post );

			// Construct a string with the names of the terms associated to the current post.
			$terms = get_the_terms( $post->ID, $category_name );
			$terms_class = '';
			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					$terms_class .= ' term-' . $term->term_id;
				}
			}

			// Get image size.
			$image_size   = array( $args['image_size'], $args['image_size'] );
			$image_size   = apply_filters( 'nice_testimonials_posts_image_size', $image_size );

			// Initialize HTML class for main container.
			$class = 'item post-' . $post->ID . ' ' . $terms_class;

			if ( ! _nice_testimonials_doing_widget() ) {
				$class .= ' columns-' . esc_attr( intval( $args['columns'] ) );

				if ( ( $loop % $args['columns'] ) === 0 ) {
					$class .= ' last';
				}
				if ( ( ( $loop - 1 ) % $args['columns'] ) === 0 ) {
					$class .= ' first';
				}
			}

			// Obtain testimonial image.
			$image = '';
			if ( $args['avatar'] ) {
				$testimonial_email = isset( $testimonial_meta['testimonial_email'] ) ? $testimonial_meta['testimonial_email'] : '';

				if ( $testimonial_email ) {
					$image = get_avatar( $testimonial_email, $image_size[0] );
				} elseif ( ( function_exists( 'has_post_thumbnail' ) ) && ( has_post_thumbnail( $post->ID ) ) ) {
					if ( function_exists( 'nice_image' ) ) {
						$image = nice_image( array(
								'size'   => '',
								'width'  => $image_size[0],
								'height' => $image_size[1],
								'id'     => $post->ID,
								'echo'   => false,
							)
						);
					} else {
						$image = get_the_post_thumbnail( $post->ID, $image_size );
					}
				}
			}

			if ( empty( $image ) ) {
				$class .= ' no-image';
			}

			$testimonial_url = isset( $testimonial_meta['testimonial_url'] ) ? $testimonial_meta['testimonial_url'] : '';
			$testimonial_url_target_blank = isset( $testimonial_meta['testimonial_url_target_blank'] ) ? $testimonial_meta['testimonial_url_target_blank'] : '';

			$use_avatar_link = ( $image && $testimonial_url && $args['avatar_link'] );
			$use_avatar_link = apply_filters( 'nice_testimonials_post_thumbnail_use_link', $use_avatar_link, $post, $image, $testimonial_url );
			$image    = $use_avatar_link ? '<a class="avatar" href="' . $testimonial_url . '"' . ( $testimonial_url_target_blank ? ' target="_blank"' : '' ) . '>' . $image . '</a>' : $image;
			$image    = $image ? '<div class="nice-testimonial-thumb">' . $image . '</div>' : '';
			$image    = apply_filters( 'nice_testimonials_post_thumbnail', $image, $post );
			$template = str_replace( '%%IMAGE%%', $image, $template );

			// Obtain author title.
			$title = '';
			if ( $args['author'] ) {
				$testimonial_byline = isset( $testimonial_meta['testimonial_byline'] ) ? $testimonial_meta['testimonial_byline'] : '';

				$title    = '<span class="author-name">' . $post->post_title . '</span>';
				$title   .= $testimonial_byline ? '<span class="author-title" itemprop="jobTitle">' . $testimonial_byline . '</span>' : '';
				$title   .= ( $args['url'] && $testimonial_url ) ? '<span class="author-url"><a href="' . $testimonial_url . '" itemprop="url" ' . ( $testimonial_url_target_blank ? ' target="_blank"' : '' ) . '>' . $testimonial_url . '</a></span>' : '';
			}
			$template = str_replace( '%%TITLE%%', $title, $template );

			// Obtain content.
			$content  = wpautop( $post->post_content );
			$content  = apply_filters( 'nice_testimonials_content', $content, $post );
			$template = str_replace( '%%CONTENT%%', $content, $template );

			// Apply HTML class to template.
			$class    = apply_filters( 'nice_testimonials_post_class', $class, $post );
			$template = str_replace( '%%CLASS%%', $class, $template );

			// Allow modifications on template.
			$template = apply_filters( 'nice_testimonials_template', $template, $post, $args );

			// Add whole template to output.
			$output .= $template;
		}

		// Close grid div.
		if ( apply_filters( 'nice_testimonials_post_use_container', true ) ) {
			$output .= '</' . esc_attr( $html_tag ) . '><!--/.nice-testimonials -->' . "\n";
		}
		$output .= $args['after'] . "\n";
	}
	// Allow child themes/plugins to filter here.
	$output = apply_filters( 'nice_testimonials_html', $output, $posts, $args );

	do_action( 'nice_testimonials_after_template', $args );

	if ( true === $args['echo'] ) {
		echo $output; // WPCS: XSS ok.
	}

	return $output;
}
endif;

if ( ! function_exists( 'nice_testimonials_get_posts' ) ) :
/**
 * Create a list of testimonials projects by category.
 *
 * @since  1.0
 *
 * @param  array $args Arguments to construct the query.
 *
 * @return array
 */
function nice_testimonials_get_posts( $args = array() ) {
	$args = nice_testimonials_normalize_args( $args );

	do_action( 'nice_testimonials_posts_before', $args );

	$testimonials_posts = array();

	if ( 0 != $args['limit'] ) { // WPCS: loose comparison ok.
		// Construct query.
		$query = new WP_Query( array(
			'post_type'      => nice_testimonials_post_type_name(),
			'orderby'        => $args['orderby'],
			'posts_per_page' => $args['limit'],
			'order'          => $args['order'],
			'tax_query'      => $args['tax_query'],
			'paged'          => $args['paged'],
			'p'              => $args['id'],
		) );

		if ( $query->have_posts() ) {
			$testimonials_posts = $query->posts;
		}

		wp_reset_postdata();
	}

	return $testimonials_posts;
}
endif;

if ( ! function_exists( 'nice_testimonials_normalize_args' ) ) :
/**
 * Normalize an array of arguments to build a list of testimonials projects.
 *
 * @since  1.0
 *
 * @param  array            $args
 * @return array|mixed|void
 */
function nice_testimonials_normalize_args( $args = array() ) {
	$settings = nice_testimonials_settings();

	$defaults = apply_filters(
		'nice_testimonials_posts_default_args', array(
			'columns'                 => $settings['columns'],
			'rows'                    => false,
			'numberposts'             => $settings['limit'],
			'orderby'                 => $settings['orderby'],
			'echo'                    => false,
			'order'                   => strtoupper( $settings['order'] ),
			'before'                  => '',
			'after'                   => '',
			'before_title'            => '',
			'after_title'             => '',
			'tax_query'               => array(),
			'paged'                   => null,
			'id'                      => null,
		)
	);
	$defaults = apply_filters( 'nice_testimonials_default_args', $defaults );

	$args = wp_parse_args( $args, $defaults );
	$args = apply_filters( 'nice_testimonials_normalized_args', $args );

	return $args;
}
endif;

if ( ! function_exists( 'nice_testimonials_get_post_meta' ) ) :
/**
 * Get meta data of a project.
 *
 * @since 1.0
 *
 * @param  WP_Post $post
 * @return array
 */
function nice_testimonials_get_post_meta( WP_Post $post ) {
	$testimonial_meta = array(
		'testimonial_url'              => get_post_meta( $post->ID, '_testimonial_url', true ),
		'testimonial_url_target_blank' => get_post_meta( $post->ID, '_testimonial_url_target_blank', true ),
		'testimonial_email'            => get_post_meta( $post->ID, '_testimonial_email', true ),
		'testimonial_byline'           => get_post_meta( $post->ID, '_testimonial_byline', true ),
	);
	$testimonial_meta = apply_filters( 'nice_testimonials_post_meta', $testimonial_meta, $post );

	return $testimonial_meta;
}
endif;

if ( ! function_exists( 'nice_testimonials_needs_assets' ) ) :
/**
 * Check if we need to load assets.
 *
 * @since  1.0
 *
 * @return bool
 */
function nice_testimonials_needs_assets() {
	$post = get_post();

	// Return early if post doesn't exist.
	if ( empty( $post ) ) {
		return false;
	}

	$settings     = nice_testimonials_settings();
	$needs_assets = false;

	if ( ! $settings['avoidcss']                                         // Usage of scripts is permitted.
	     && (    has_shortcode( $post->post_excerpt, 'testimonials' )    // Excerpt uses the shortcode.
	          || has_shortcode( $post->post_content, 'testimonials' )    // Content uses the shortcode
	          || is_home()                                               // Current page is home page.
	          || is_archive()                                            // Current page is some kind of archive page.
			  || nice_testimonials_post_type_name() === $post->post_type // Current page is for testimonial post type.
			)
	) {
		$needs_assets = true;
	}

	$needs_assets = apply_filters( 'nice_testimonials_needs_assets', $needs_assets );

	return $needs_assets;
}
endif;
