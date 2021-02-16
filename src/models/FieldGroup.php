<?php

namespace WPGraphQL\ACF;

use Exception;
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

	/**
	 * Stores the incoming WP_Comment object to be modeled
	 *
	 * @var Product $data
	 */
	public $data;

	/**
	 * Comment constructor.
	 *
	 * @param Product $comment The incoming WP_Comment to be modeled
	 *
	 * @throws Exception
	 */
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
	}

	protected function init() {
		if ( empty( $this->fields ) ) {

			$this->fields = [
				'id' => function() {
					return ! empty( $this->data->ID ) ? Relay::toGlobalId( 'fieldGroup', $this->data->ID ) : null;
				},
				'ID' => function () {
					return $this->data->ID;
				},
				'fieldGroupName' => function() {
					$fieldName = unserialize($this->data->post_content)['graphql_field_name'];
					dd($fieldName);
					return $fieldName;
				},
				'locations' => function () {
					return unserialize($this->data->post_content)['location'][0];
				},
			];
		}
	}
}
