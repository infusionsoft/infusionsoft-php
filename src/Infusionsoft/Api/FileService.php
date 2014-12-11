<?php

namespace Infusionsoft\Api;

class FileService extends AbstractApi {

	/**
	 * @param integer $fileId
	 * @return mixed
	 */
	public function getFile($fileId)
	{
		return $this->client->request('FileService.getFile', $fileId);
	}

	/**
	 * @param integer $fileId
	 * @return mixed
	 */
	public function getDownloadUrl($fileId)
	{
		return $this->client->request('FileService.getDownloadUrl', $fileId);
	}

	/**
	 * @param string $fileName
	 * @param string $base64EncodedData
	 * @param integer $contactId
	 * @return mixed
	 */
	public function uploadFile($contactId, $fileName, $base64EncodedData)
	{
		return $this->client->request('FileService.uploadFile', $contactId, $fileName, $base64EncodedData);
	}

	/**
	 * @param integer $fileId
	 * @param string $base64EncodedData
	 * @return mixed
	 */
	public function replaceFile($fileId, $base64EncodedData)
	{
		return $this->client->request('FileService.replaceFile', $fileId, $base64EncodedData);
	}

	/**
	 * @param integer $fileId
	 * @param string $fileName
	 * @return mixed
	 */
	public function renameFile($fileId, $fileName)
	{
		return $this->client->request('FileService.renameFile', $fileId, $fileName);
	}

}
