<?php
/**
 * @author Carlo Meier <carlo.meier@mail.ch>
 */

namespace OCA\Files_External_IPFS\Storage;

use League\Flysystem\FileNotFoundException;
use OC\Files\Storage\Flysystem;
use OC\Files\Storage\PolyFill\CopyDirectory;

class IPFS extends Flysystem {
	use CopyDirectory;

	private $adapter, $api;
	protected $baseDir;
	protected $root;

	public function __construct($params) {
		if (isset($params['host'])) {
			$this->root = isset($params['root']) ? "/{$params['root']}" : '/';
			$this->api = $params['host'];

			$this->adapter = new Adapter($this->api);
			$this->buildFlySystem($this->adapter);
		} else {
			throw new \Exception('Creating \OCA\Files_External_IPFS\IPFS storage failed');
		}
	}

	public function __destruct() {
	}

	public static function checkDependencies() {
		$deps = [];
		//TODO: /api/v0/version

		if (!function_exists('ftp_login')) $deps[] = 'ftp';

		return count($deps) == 0 ? true : $deps;
	}

	public function getId() {
		return "IPFS::{$this->api}#{$this->baseDir}";
	}
}
