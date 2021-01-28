<?php

namespace WPGraphQL\ACF;

use WPGraphQL\Data\Loader\AbstractDataLoader;

class FieldGroupLoader extends AbstractDataLoader {
	public function get_model($entry, $key): FieldGroup
	{
		$ret = new FieldGroup($entry);
		return $ret;
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
