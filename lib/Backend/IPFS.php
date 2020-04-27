<?php
/**
 * @author Carlo Meier <carlo.meier@mail.ch>
 */

namespace OCA\Files_External_IPFS\Backend;

use OCP\IL10N;
use OCA\Files_External\Lib\Backend\Backend;
use OCA\Files_External\Lib\DefinitionParameter;
use OCA\Files_External\Lib\Auth\AuthMechanism;
use OCA\Files_External\Lib\LegacyDependencyCheckPolyfill;
use OCA\Files_External\Lib\Auth\Password\Password;

class IPFS extends Backend {
	use LegacyDependencyCheckPolyfill;

	public function __construct(IL10N $l, Password $legacyAuth) {
		$this->setIdentifier('ipfs_filesystem')
			->setStorageClass(\OCA\Files_External_IPFS\Storage\IPFS::class)
			->setText($l->t('IPFS'))
			->addParameters([
				(new DefinitionParameter('host', $l->t('IPFS API'))),
				(new DefinitionParameter('root', $l->t('Subfolder')))
					->setFlag(DefinitionParameter::FLAG_OPTIONAL),
			]);
			//->addAuthScheme(AuthMechanism::SCHEME_PASSWORD);
	}
}
