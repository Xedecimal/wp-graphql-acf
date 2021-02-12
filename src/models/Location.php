<?php

namespace WPGraphQL\ACF;

use Exception;
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
class Location extends Model {

	/**
	 * Stores the incoming WP_Comment object to be modeled
	 *
	 * @var Product $data
	 */
	protected $data;

	/**
	 * Comment constructor.
	 *
	 * @param array $location
	 * @throws Exception
	 */
	public function __construct( array $location ) {
		$this->data = $location;
		parent::__construct( null, null );
	}

	/**
	 * Initializes the object
	 *
	 * @return void
	 */
	protected function init() {
		if ( empty( $this->fields ) ) {

			$this->fields = [
				'param' => function() {
					return $this->data['param'];
				},
				'operator' => function() {
					return $this->data['operator'];
				},
				'value' => function() {
					return $this->data['value'];
				},
			];
		}
	}
}
