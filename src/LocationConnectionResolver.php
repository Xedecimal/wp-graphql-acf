<?php

namespace WPGraphQL\ACF;

use Exception;
use WP_Query;
use WPGraphQL\Data\Connection\AbstractConnectionResolver;

/**
 * Class CommentConnectionResolver
 *
 * @package WPGraphQL\Data\Connection
 */
class LocationConnectionResolver extends AbstractConnectionResolver {

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
		return new WP_Query($query_args);
	}

	/**
	 * Return the name of the loader
	 *
	 * @return string
	 */
	public function get_loader_name(): string {
		return 'location';
	}

	/**
	 * @return array
	 * @throws Exception
	 */
	public function get_ids(): array {
		global $test;
		$test = $this->source;
		return array_keys($this->source->fields['locations']());
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
	public function should_execute(): bool {
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
	public function sanitize_input_fields(): array {
		return [];
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
	public function is_valid_offset( $offset ): bool {
		return ! empty( get_comment( $offset ) );
	}
}
