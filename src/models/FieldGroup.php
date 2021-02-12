<?php

namespace WPGraphQL\ACF;

use GraphQLRelay\Relay;
use WPGraphQL\Model\Model;
use WPGraphQL\WooCommerce\Model\Product;

/**
 * Class Comment - Models data for Comments
 *
 * @property string $id
 * @property int    $commentId
 * @property string $commentAuthorEmail
 * @property string $comment_author
 * @property string $comment_author_url
 * @property int    $comment_ID
 * @property int    $comment_parent_id
 * @property string $parentId
 * @property int    $parentDatabaseId
 * @property string $authorIp
 * @property string $date
 * @property string $dateGmt
 * @property string $contentRaw
 * @property string $contentRendered
 * @property string $karma
 * @property int    $approved
 * @property string $agent
 * @property string $type
 * @property int    $userId
 *
 * @package WPGraphQL\Model
 */
class FieldGroup extends Model {
//
	/**
	 * Stores the incoming WP_Comment object to be modeled
	 *
	 * @var Product $data
	 */
	protected $data;
//
//	/**
//	 * Comment constructor.
//	 *
//	 * @param \WP_Comment $comment The incoming WP_Comment to be modeled
//	 *
//	 * @throws Exception
//	 */
	public function __construct( $product ) {

		$allowed_restricted_fields = [
			'id',
			'ID',
			'commentId',
			'databaseId',
			'contentRendered',
			'date',
			'dateGmt',
			'karma',
			'type',
			'commentedOnId',
			'comment_post_ID',
			'approved',
			'comment_parent_id',
			'parentId',
			'parentDatabaseId',
			'isRestricted',
			'userId',
		];

		$this->data = $product;
		$owner      = ! empty( $comment->user_id ) ? absint( $comment->user_id ) : null;
		parent::__construct( 'moderate_comments', $allowed_restricted_fields, $owner );
//
	}
//
//	/**
//	 * Method for determining if the data should be considered private or not
//	 *
//	 * @return bool
//	 * @throws Exception
//	 */
//	protected function is_private() {
//
//		if ( empty( $this->data->comment_post_ID ) ) {
//			return true;
//		}
//
//		$commented_on = get_post( (int) $this->data->comment_post_ID );
//
//		if ( empty( $commented_on ) ) {
//			return true;
//		}
//
//		// A comment is considered private if it is attached to a private post.
//		if ( empty( $commented_on ) || true === ( new Post( $commented_on ) )->is_private() ) {
//			return true;
//		}
//
//		// NOTE: Do a non-strict check here, as the return is a `1` or `0`.
//		// phpcs:disable WordPress.PHP.StrictComparisons.LooseComparison
//		if ( true != $this->data->comment_approved && ! current_user_can( 'moderate_comments' ) ) {
//			return true;
//		}
//
//		return false;
//
//	}
//
//	/**
//	 * Initializes the object
//	 *
//	 * @return void
//	 */
	protected function init() {
		if ( empty( $this->fields ) ) {

			$this->fields = [
				'id'                 => function() {
					return ! empty( $this->data->ID ) ? Relay::toGlobalId( 'comment', $this->data->ID ) : null;
				},
				'fieldGroupName' => function() {
					return unserialize($this->data->post_content)['graphql_field_name'];
				},
				'locations' => function () {
					return unserialize($this->data->post_content)['location'][0];
				},
			];
		}
	}
}
