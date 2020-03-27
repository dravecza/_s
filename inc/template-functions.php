<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Tarsasnavigator_s
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function tarsasnavigator_s_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'tarsasnavigator_s_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function tarsasnavigator_s_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'tarsasnavigator_s_pingback_header' );


// Overriding the original loop-product thumbnail
add_action('init', 'replace_default_loop_product_thumbnail');
function replace_default_loop_product_thumbnail(){
    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

		//add_action( 'woocommerce_before_shop_loop_item_title', 'tn_template_loop_product_thumbnail', 10);
		if ( ! function_exists( 'tn_template_loop_product_thumbnail' ) ) {
			function tn_template_loop_product_thumbnail() {
				tn_get_product_thumbnail();
			}
		}

		if ( ! function_exists( 'tn_get_product_thumbnail' ) ) {
			function tn_get_product_thumbnail( $size = 'shop_catalog' ) {
				global $post;
				$output = '<div class="col-lg-4">';
				if ( has_post_thumbnail() ) {
					$output .= get_the_post_thumbnail( $post->ID, $size );
				} else {
					$output .= wc_placeholder_img( $size );
					// Or alternatively setting yours width and height shop_catalog dimensions.
					// $output .= '<img src="' . woocommerce_placeholder_img_src() . '" alt="Placeholder" width="300px" height="300px" />';
				}
				$output .= '</div>';
				echo $output;
			}
		}
}

// Overriding the default loop-product link-start
add_action('init', 'replace_default_loop_product');
function replace_default_loop_product() {
	// Main item wrapper
	remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
	add_action( 'woocommerce_before_shop_loop_item', 'tn_template_loop_product_link_open', 10);
	// BEFORE image + language + details
	remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
	add_action( 'woocommerce_before_shop_loop_item_title', 'tn_before_shop_loop_item_title', 10);
	// AFTER image + language + details & BEFORE item title
	remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 10);
	add_action( 'woocommerce_shop_loop_item_title', 'tn_shop_loop_item_title', 10);
	// AFTER item title & BEFORE price
	remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
	remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
	add_action( 'woocommerce_after_shop_loop_item_title', 'tn_after_shop_loop_item_title', 10);

	//////// Hook functions
	// BEFORE the whole shop loop item
	if ( ! function_exists( 'tn_template_loop_product_link_open' ) ) {
		function tn_template_loop_product_link_open() {
			global $product;

			$size = 'shop_catalog';
			$style = 'style="background-image: url(';
			if ( has_post_thumbnail() ) {
				$style .= esc_url(get_the_post_thumbnail_url( $post->ID, $size));
			} else {
				$style .= esc_attr(wc_placeholder_img_src( $size ));
			}
			$style .= ')"';

      $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
      echo '<a href="' . esc_url( $link ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">';
			echo '<div class="tn-product-thumbnail" ' . $style . '>';
				tn_display_product_language();
				// TODO: onsale? (aka sale-flash)
				tn_display_product_rented();
				tn_display_product_details();
			echo '</div>';
			echo '</a>';
		}
	}
	// BEFORE item title
	if ( ! function_exists( 'tn_before_shop_loop_item_title' ) ) {
		function tn_before_shop_loop_item_title() {
			global $product;
			$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
      echo '<a href="' . esc_url( $link ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__title-wrapper">';
		}
	}
	// AFTER item title
	if ( ! function_exists( 'tn_shop_loop_item_title' ) ) {
		function tn_shop_loop_item_title() {
			global $product;
			//echo '</a>';
		}
	}
	// AFTER item title & BEFORE price
	if ( ! function_exists( 'tn_after_shop_loop_item_title' ) ) {
		function tn_after_shop_loop_item_title() {
			global $product;
			$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
			//echo '<a href="' . esc_url( $link ) . '" class="woocommerce-LoopProduct-link star-rating-wrapper">';
			wc_get_template( 'loop/rating.php' );
			echo '</a>';
			echo '<a href="' . esc_url( $link ) . '" class="woocommerce-LoopProduct-link price-wrapper">';
			wc_get_template( 'loop/price.php' );
			echo '</a>';
		}
	}

	// Product details (icons)
	if ( ! function_exists( 'tn_display_product_details' ) ) {
		function tn_display_product_details() {
			global $product;
			// Product details
			$age = $product->get_attribute("eletkor");
			$length = $product->get_attribute("jatekido");
			$players = $product->get_attribute("jatekosok-szama");
			$difficulty = $product->get_attribute("osszetettseg");

			if($age || $length || $players || $difficulty) {
				// Desktop
				echo '<div class="game-info-icons">';
				echo '<i class="tn-players-icon ' . ($players ? ' fas fa-users' : '') . '"></i>';
				echo '<span class="tn-players" title="Játékosok száma">' . ($players ? $players : '') . '</span>';
				echo '<i class="tn-time-icon ' . ($length ? ' fas fa-clock' : '') . '"></i>';
				echo '<span class="tn-playtime" title="Játékidő">' . ($length ? str_replace(" perc", "'", $length) : '') . '</span>';
				echo '<i class="tn-age-icon ' . ($age ? ' fas fa-birthday-cake' : '') . '"></i>';
				echo '<span class="tn-age" title="Ajánlott életkor">' . ($age ? $age : '') . '</span>';
				echo '<i class="tn-difficulty-icon ' . ($difficulty ? ' fas fa-cogs' : '') . '"></i>';
				echo '<span class="tn-difficulty" title="Összetettség">' . ($difficulty ? $difficulty : '') . '</span>';
				echo '</div>';
			}
		}
	}
	// Nyelv-ikon
	if ( ! function_exists( 'tn_display_product_language' ) ) {
		function tn_display_product_language() {
			global $product;
			$language = $product->get_attribute("nyelv");
			if($language) {
				$lang = explode(" ", $language)[0];
				$lang_icons = [
					'Német' => "de_DE.png",
					'Angol' => "en_GB.png",
					'Francia' => "fr_FR.png",
					'Magyar' => "hu_HU.png"
				];
				if($lang_icons[$lang]) {
					echo '<img src="' . get_template_directory_uri() . '/assets/images/' . $lang_icons[$lang] . '" class="product-language" alt="' . $language .' nyelvű" title="' . $language .' nyelvű">';
				}
			}
		}
	}

	// Kölcsönzés
	if ( ! function_exists( 'tn_display_product_rented' ) ) {
		function tn_display_product_rented() {
			global $product;

			$attributes = $product->get_attributes();
			if( isset($attributes["pa_kolcsonozheto"]) ) {
				$lending_status = get_term_by("id", $attributes["pa_kolcsonozheto"]->get_data()['options'][0], "pa_kolcsonozheto")->slug;
				if( explode("_", $lending_status)[0] == "0") {
					echo '<span class="product-lent">Kikölcsönözve</span>';
				}
			}
		}
	}
}
