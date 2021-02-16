<?php

namespace WPGraphQL\ACF;

use Exception;
use GraphQLRelay\Relay;
use WP_Post;
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
class Field extends Model {

	/**
	 * Stores the incoming WP_Comment object to be modeled
	 *
	 * @var WP_Post $data
	 */
	protected $data;

	/**
	 * Comment constructor.
	 *
	 * @param Product $product The incoming WP_Comment to be modeled
	 *
	 * @throws Exception
	 */
	public function __construct( $product ) {
		$allowed_restricted_fields = [
			'id',
			'ID',
			'name',
			'title',
		];

		$this->data = $product;
		$owner      = ! empty( $comment->user_id ) ? absint( $comment->user_id ) : null;
		parent::__construct( 'moderate_comments', $allowed_restricted_fields, $owner );
	}

	/**
	 * Initializes the object
	 *
	 * @return void
	 */
	protected function init() {
		if ( empty( $this->fields ) ) {

			$this->fields = [
				'id'                 => function() {
					return ! empty( $this->data->ID ) ? Relay::toGlobalId( 'comment', $this->data->ID ) : null;
				},
				'name' => function() {
					return Config::camel_case($this->data->post_title);
				},
				'title' => function() {
					return $this->data->post_title;
				},
				'choices' => function () {
					$choices = unserialize($this->data->post_content)['choices'];
					$ret = $choices ? array_map(function ($value, $label) {
						return [ 'value' => $value, 'label' => $label];
					}, array_keys($choices), $choices) : null;
					return $ret;
				},
			];
		}
	}
}
