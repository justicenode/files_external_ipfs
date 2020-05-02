<?php

namespace OCA\Files_External_IPFS\Storage;

/**
 * Class MultipartData
 * @package OCA\Files_External_IPFS\Storage
 * @author V31L <veil@mail.ch>
 */
class MultipartData {
	private $content, $path, $mode, $mtime, $mime, $delimiter, $data, $fields;

	public function __construct($content, string $path, int $mode, int $mtime = null, string $mime = 'application/octet-stream') {
		$this->content = $content;
		$this->mode = sprintf('0%o', $mode);
		$this->mtime = empty($mtime) ? time() : $mtime;
		$this->path = $path;
		$this->mime = $mime;
		$this->delimiter = '-------------' . uniqid();
	}

	/**
	 * @param array $fields
	 */
	public function setFields(array $fields) {
		$this->fields = $fields;
	}

	/**
	 * @param $curl
	 */
	public function apply($curl) {
		$this->data = '';

		// populate normal fields
		foreach ($this->fields as $name => $content) {
			$this->data .= "--{$this->delimiter}\r\n";
			$this->data .= "Content-Disposition: form-data; name=\"{$name}\"\r\n{$content}\r\n\r\n";
		}

		// populate file field
		$this->data .= "--" . $this->delimiter . "\r\n";
		$this->data .= "Content-Disposition: form-data; name=\"file\"; filename=\"{$this->path}\"\r\n";
		$this->data .= "Content-Type: {$this->mime}\r\n";
		$this->data .= "mode: {$this->mode}\r\n";
		$this->data .= "mtime: {$this->mtime}\r\n";
		$this->data .= $this->content . "\r\n";

		// last delimiter
		$this->data .= "--" . $this->delimiter . "--\r\n";

		// Add data to curl request
		curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders());
		curl_setopt($curl, CURLOPT_POSTFIELDS, $this->data);
	}

	/**
	 * @return string[]
	 */
	private function getHeaders() {
		return [
			"Content-Type: multipart/form-data; boundary={$this->delimiter}",
			'Content-Length: ' . strlen($this->data)
		];
	}
}