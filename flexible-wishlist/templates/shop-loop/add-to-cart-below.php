<?php
/**
 * @var \WC_Product $product           .
 * @var bool        $status            .
 * @var string      $icon_type         .
 * @var string      $text_status_add   .
 * @var string      $text_status_added .
 *
 * @package WPDesk\FlexibleWishlist
 */

?>
<div>
	<span data-fw-action="add-to-wishlist"
		tabindex="0"
		role="button"
		aria-label="<?php esc_attr_e( 'Add to wishlist', 'flexible-wishlist' ); ?>"
		class="fw-button fw-button--below <?php echo esc_attr( ( $status ) ? 'fw-button--active' : '' ); ?>"
		data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
		<span class="fw-button-icon fw-button-icon--<?php echo esc_attr( $icon_type ); ?>"></span>
		<span class="fw-button-text"
			data-text-default="<?php echo esc_attr( $text_status_add ); ?>"
			data-text-active="<?php echo esc_attr( $text_status_added ); ?>"></span>
	</span>
</div>
