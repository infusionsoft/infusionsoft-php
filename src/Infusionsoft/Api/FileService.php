<?php

namespace Infusionsoft\Api;

class FileService extends AbstractApi {

	/**
	 * @param integer $fileId
	 * @return {{return}}
	 */
	public function getFile($fileId)
	{
		return $this->client->request($this->method(), $fileId);
	}

	/**
	 * @param integer $fileId
	 * @return {{return}}
	 */
	public function getDownloadUrl($fileId)
	{
		return $this->client->request($this->method(), $fileId);
	}

	/**
	 * @param string $fileName
	 * @param string $base64EncodedData
	 * @param integer $contactId
	 * @return {{return}}
	 */
	public function uploadFile($fileName, $base64EncodedData, $contactId)
	{
		return $this->client->request($this->method(), $fileName, $base64EncodedData, $contactId);
	}

	/**
	 * @param integer $fileId
	 * @param string $base64EncodedData
	 * @return {{return}}
	 */
	public function replaceFile($fileId, $base64EncodedData)
	{
		return $this->client->request($this->method(), $fileId, $base64EncodedData);
	}

	/**
	 * @param integer $fileId
	 * @param string $fileName
	 * @return {{return}}
	 */
	public function renameFile($fileId, $fileName)
	{
		return $this->client->request($this->method(), $fileId, $fileName);
	}

}