<?php
/**
 * @author Carlo Meier <carlo.meier@mail.ch>
 */

namespace OCA\Files_External_IPFS\AppInfo;

use OCA\Files_External_IPFS\Backend\IPFS;
use OCP\AppFramework\App;
use OCA\Files_External\Lib\Config\IBackendProvider;
use OCA\Files_External\Service\BackendService;

/**
 * @package OCA\Files_External_IPFS\AppInfo
 */
class Application extends App implements IBackendProvider {

	public function __construct(array $urlParams = []) {
		parent::__construct('files_external_ipfs', $urlParams);
		$this->register();
	}

	public function register() {
		$container = $this->getContainer();

		/** @var BackendService $backendService */
		$backendService = $container->query(BackendService::class);
		$backendService->registerBackendProvider($this);
	}


	/**
	 * @{inheritdoc}
	 */
	public function getBackends() {
		$container = $this->getContainer();

		return [
			$container->query(IPFS::class)
		];
	}
}
