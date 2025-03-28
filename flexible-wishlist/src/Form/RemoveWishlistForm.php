<?php
/**
 * @package WPDesk\FlexibleWishlist
 */

namespace WPDesk\FlexibleWishlist\Form;

use WPDesk\FlexibleWishlist\Exception\InvalidFormRequestId;
use WPDesk\FlexibleWishlist\Exception\UnauthorizedRequest;
use WPDesk\FlexibleWishlist\Repository\WishlistRepository;
use WPDesk\FlexibleWishlist\Service\UserAuthManager;

/**
 * {@inheritdoc}
 */
class RemoveWishlistForm implements Form {

	const ACTION_NAME       = 'wishlist_remove';
	const PARAM_WISHLIST_ID = 'wishlist_id';
	const NONCE_FIELD       = self::ACTION_NAME . '_nonce';

	/**
	 * @var UserAuthManager
	 */
	private $user_auth_manager;

	/**
	 * @var WishlistRepository
	 */
	private $wishlist_repository;

	public function __construct(
		UserAuthManager $user_auth_manager,
		WishlistRepository $wishlist_repository
	) {
		$this->user_auth_manager   = $user_auth_manager;
		$this->wishlist_repository = $wishlist_repository;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_action_name(): string {
		return self::ACTION_NAME;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @throws InvalidFormRequestId
	 * @throws UnauthorizedRequest
	 */
	public function process_request( array $form_data ) {
		if ( ! wp_verify_nonce( $form_data[ self::NONCE_FIELD ] ?? '', self::ACTION_NAME ) ) {
			throw new UnauthorizedRequest();
		}

		$wishlist = $this->wishlist_repository->get_by_id( $form_data[ self::PARAM_WISHLIST_ID ] );
		if ( $wishlist === null ) {
			throw new InvalidFormRequestId();
		}

		if ( $wishlist->get_user_id() !== $this->user_auth_manager->get_user()->get_id() ) {
			throw new UnauthorizedRequest();
		}

		$this->wishlist_repository->remove( $wishlist );
	}
}
