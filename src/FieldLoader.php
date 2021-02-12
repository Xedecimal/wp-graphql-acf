<?php

namespace WPGraphQL\ACF;

use Exception;
use WPGraphQL\Data\Loader\AbstractDataLoader;

class FieldLoader extends AbstractDataLoader {
	/**
	 * @param mixed $entry
	 * @param mixed $key
	 * @return Field
	 * @throws Exception
	 */
	public function get_model($entry, $key): Field
	{
		return new Field($entry);
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
