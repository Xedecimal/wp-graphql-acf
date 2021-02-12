<?php

namespace WPGraphQL\ACF;

use Exception;
use WPGraphQL\Data\Loader\AbstractDataLoader;

class LocationsLoader extends AbstractDataLoader {
	/**
	 * @param mixed $entry
	 * @param mixed $key
	 * @return Location
	 * @throws Exception
	 */
	public function get_model($entry, $key): Location
	{
		return new Location($entry);
	}

	/**
	 * @param array $keys
	 * @return array
	 * @throws Exception
	 */
	public function loadKeys(array $keys): array
	{
		global $test;
		$locations = $test->fields['locations']();

		$loaded = [];

		foreach ($keys as $key ) {
			$loaded[ $key ] = $locations[$key];
		}

		return $loaded;
	}
}
