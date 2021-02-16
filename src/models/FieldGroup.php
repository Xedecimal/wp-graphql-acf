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
class FieldGroup extends Model {

	/**
	 * Stores the incoming WP_Comment object to be modeled
	 *
	 * @var Product $data
	 */
	protected $data;
	protected $post_content;

	/**
	 * Comment constructor.
	 *
	 * @param WP_Post $fieldGroup The incoming WP_Comment to be modeled
	 *
	 * @throws Exception
	 */
	public function __construct( $fieldGroup ) {
		$this->data = $fieldGroup;
		$this->post_content = unserialize($fieldGroup->post_content);

		parent::__construct( null, null, null );
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
					return $this->post_content['graphql_field_name'];
				},
				'locations' => function () {
					return $this->post_content['location'][0];
				},
			];
		}
	}
}
