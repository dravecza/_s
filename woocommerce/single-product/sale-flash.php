<?php
/**
 * Single Product Sale Flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;
?>
<?php if ( $product->is_on_sale() ) : ?>

	<?php
		$regular_price = get_post_meta( get_the_ID(), '_regular_price', true);;
		$sale_price = get_post_meta( get_the_ID(), '_sale_price', true);
		$sale_percent = floor(100 - ($sale_price / $regular_price * 100));
		echo apply_filters( 'woocommerce_sale_flash',
			'<span class="onsale' . ($sale_percent > 10 ? " bigsale" : "") . '"><span>' .
				($sale_percent > 10 ? "-" . $sale_percent . "%" : "%") .
				'<br />' .
				'<span class="countdown-timer" data-cd-end="' . $product->get_date_on_sale_to(). '"></span>' .
			'</span></span>', $post, $product ); ?>
	<?php if ( $product->get_date_on_sale_to() ) : ?>

		<script type="text/javascript">

			function Stopwatch(config) {
			  // If no config is passed, create an empty set
			  config = config || {};
			  // Set the options (passed or default)
			  this.element = config.element || {};
			  this.previousTime = config.previousTime || new Date().getTime();
			  this.paused = config.paused && true;
			  this.elapsed = config.elapsed || 0;
			  this.countingUp = config.countingUp && true;
			  this.timeLimit = config.timeLimit || (this.countingUp ? 60 * 10 : 0);
			  this.updateRate = config.updateRate || 100;
			  this.onTimeUp = config.onTimeUp || function() {
			    this.stop();
			  };
			  this.onTimeUpdate = config.onTimeUpdate || function() {
			    console.log(this.elapsed)
			  };
			  if (!this.paused) {
			    this.start();
			  }
			}


			Stopwatch.prototype.start = function() {
			  // Unlock the timer
			  this.paused = false;
			  // Update the current time
			  this.previousTime = new Date().getTime();
			  // Launch the counter
			  this.keepCounting();
			};

			Stopwatch.prototype.keepCounting = function() {
			  // Lock the timer if paused
			  if (this.paused) {
			    return true;
			  }
			  // Get the current time
			  var now = new Date().getTime();
			  // Calculate the time difference from last check and add/substract it to 'elapsed'
			  var diff = (now - this.previousTime);
			  if (!this.countingUp) {
			    diff = -diff;
			  }
			  this.elapsed = this.elapsed + diff;
			  // Update the time
			  this.previousTime = now;
			  // Execute the callback for the update
			  this.onTimeUpdate();
			  // If we hit the time limit, stop and execute the callback for time up
			  if ((this.elapsed >= this.timeLimit && this.countingUp) || (this.elapsed <= this.timeLimit && !this.countingUp)) {
			    this.stop();
			    this.onTimeUp();
			    return true;
			  }
			  // Execute that again in 'updateRate' milliseconds
			  var that = this;
			  setTimeout(function() {
			    that.keepCounting();
			  }, this.updateRate);
			};

			Stopwatch.prototype.stop = function() {
			  // Change the status
			  this.paused = true;
			};



			/******************
			 * MAIN SCRIPT
			 *****************/
			 function stopSale() {
				 jQuery('.onsale').fadeOut();
				 jQuery('.summary .price ins').html(jQuery('.summary .price del').html());
				 jQuery('.summary .price del').fadeOut();
			 }

			jQuery(document).ready(function() {
			  /*
			   * First example, producing 2 identical counters (countdowns)
			   */
			  jQuery('.countdown-timer').each(function() {
					var cdEnd = jQuery(this).attr('data-cd-end');
			    var stopwatch = new Stopwatch({
			      'element': jQuery(this),               // DOM element
			      'paused': false,                  // Status
						'elapsed': moment(cdEnd).diff(moment()),        // Current time in milliseconds
			      'countingUp': false,              // Counting up or down
			      'timeLimit': 0,                   // Time limit in milliseconds
			      'updateRate': 1000,                // Update rate, in milliseconds
			      'onTimeUp': function() {          // onTimeUp callback
			        this.stop();
							stopSale();
			        jQuery(this.element).html('');
			      },
			      'onTimeUpdate': function() {      // onTimeUpdate callback
			        var t = this.elapsed,
									toDisplay = moment.duration(t).asDays() >= 1 ? "Már csak " + Math.round(moment.duration(t).asDays()) + " napig!" : moment(t).format("HH:mm:ss");
							if(moment.duration(t).asDays() >= 1) {
								console.info("We have so much time left...");
								jQuery(this.element).addClass('days-remaining');
								this.updateRate = 60 * 1000;
							} else {
								console.info("The time is near!");
								jQuery(this.element).removeClass('days-remaining');
								this.update = 1000;
							}
			        jQuery(this.element).html(toDisplay);
			      }
			    });
			  });
			});

		</script>
	<?php endif; ?>
<?php endif;

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
