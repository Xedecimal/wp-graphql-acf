<?php

namespace WPGraphQL\ACF;

use Exception;
use WPGraphQL\Data\Loader\AbstractDataLoader;

class FieldGroupLoader extends AbstractDataLoader {
	/**
	 * @param mixed $entry
	 * @param mixed $key
	 * @return FieldGroup
	 * @throws Exception
	 */
	public function get_model($entry, $key): FieldGroup
	{
		return new FieldGroup($entry);
	}

	public function loadKeys( $keys ): array
	{
		$loaded = [];
		foreach ( $keys as $key ) {
			$loaded[ $key ] = get_post( $key );
		}

		return $loaded;
	}
}
