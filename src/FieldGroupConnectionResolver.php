<?php

namespace WPGraphQL\ACF;

use Exception;
use WP_Query;
use WPGraphQL\Data\Connection\AbstractConnectionResolver;
use WPGraphQL\Types;

/**
 * Class CommentConnectionResolver
 *
 * @package WPGraphQL\Data\Connection
 */
class FieldGroupConnectionResolver extends AbstractConnectionResolver {

	/**
	 * @return array
	 * @throws Exception
	 */
	public function get_query_args(): array
	{
		return ['argument' => 'Here is a value'];
	}

	/**
	 * Get_query
	 *
	 * Return the instance of the WP_Comment_Query
	 *
	 * @throws Exception
	 */
	public function get_query(): WP_Query
	{
		$query_args = ['post_type' => 'acf-field-group'];
		$query = new WP_Query($query_args);
		return $query;
	}

	/**
	 * Return the name of the loader
	 *
	 * @return string
	 */
	public function get_loader_name() {
		return 'fieldGroups';
	}

	/**
	 * @return array
	 * @throws Exception
	 */
	public function get_ids() {
		$ids = array_map(function ($item) { return $item->ID; }, $this->query->get_posts());
		return $ids;
	}

	/**
	 * This can be used to determine whether the connection query should even execute.
	 *
	 * For example, if the $source were a post_type that didn't support comments, we could prevent
	 * the connection query from even executing. In our case, we prevent comments from even showing
	 * in the Schema for post types that don't have comment support, so we don't need to worry
	 * about that, but there may be other situations where we'd need to prevent it.
	 *
	 * @return boolean
	 */
	public function should_execute() {
		return true;
	}

	/**
	 * This sets up the "allowed" args, and translates the GraphQL-friendly keys to
	 * WP_Comment_Query friendly keys.
	 *
	 * There's probably a cleaner/more dynamic way to approach this, but this was quick. I'd be
	 * down to explore more dynamic ways to map this, but for now this gets the job done.
	 *
	 * @param array $args The array of query arguments
	 *
	 * @since  0.0.5
	 * @return array
	 */
	public function sanitize_input_fields( array $args ) {
		$arg_mapping = [
			'authorEmail'        => 'author_email',
			'authorIn'           => 'author__in',
			'authorNotIn'        => 'author__not_in',
			'authorUrl'          => 'author_url',
			'commentIn'          => 'comment__in',
			'commentNotIn'       => 'comment__not_in',
			'contentAuthor'      => 'post_author',
			'contentAuthorIn'    => 'post_author__in',
			'contentAuthorNotIn' => 'post_author__not_in',
			'contentId'          => 'post_id',
			'contentIdIn'        => 'post__in',
			'contentIdNotIn'     => 'post__not_in',
			'contentName'        => 'post_name',
			'contentParent'      => 'post_parent',
			'contentStatus'      => 'post_status',
			'contentType'        => 'post_type',
			'includeUnapproved'  => 'include_unapproved',
			'parentIn'           => 'parent__in',
			'parentNotIn'        => 'parent__not_in',
			'userId'             => 'user_id',
		];

		/**
		 * Map and sanitize the input args to the WP_Comment_Query compatible args
		 */
		$query_args = Types::map_input( $args, $arg_mapping );

		/**
		 * Filter the input fields
		 *
		 * This allows plugins/themes to hook in and alter what $args should be allowed to be passed
		 * from a GraphQL Query to the get_terms query
		 *
		 * @since 0.0.5
		 */
		$query_args = apply_filters( 'graphql_map_input_fields_to_wp_comment_query', $query_args, $args, $this->source, $this->args, $this->context, $this->info );

		return ! empty( $query_args ) && is_array( $query_args ) ? $query_args : [];

	}

	/**
	 * Determine whether or not the the offset is valid, i.e the comment corresponding to the
	 * offset exists. Offset is equivalent to comment_id. So this function is equivalent to
	 * checking if the comment with the given ID exists.
	 *
	 * @param int $offset The ID of the node used for the cursor offset
	 *
	 * @return bool
	 */
	public function is_valid_offset( $offset ) {
		return ! empty( get_comment( $offset ) );
	}

}
