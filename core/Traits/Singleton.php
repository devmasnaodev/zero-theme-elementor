<?php

namespace ZT\Core\Traits;

defined( 'ABSPATH' ) || exit;

/**
 * Singleton pattern class.
 */
trait Singleton {
	/**
	 * Instance of this static object.
	 *
	 * @var array
	 */
	private static array $instances = array();

	/**
	 * Consctruct.
	 * Private to avoid "new".
	 */
	private function __construct() {
	}

	/**
	 * Get singleton instance.
	 *
	 * @return object Current object instance.
	 */
	final public static function get_instance(): object {
		$class = get_called_class();

		if ( ! isset( $instances[ $class ] ) ) {
			self::$instances[ $class ] = new $class();
		}

		return self::$instances[ $class ];
	}

	/**
	 * Avoid clone instance
	 */
	private function __clone() {
	}

	/**
	 * Avoid serialize instance
	 */
	public function __sleep() {
	}

	/**
	 * Avoid unserialize instance
	 */
	public function __wakeup() {
	}
}
