<?php

namespace Infusionsoft\Api;

class EmailService extends AbstractApi {

	/**
	 * @param string $placeTitle
	 * @param string $categories
	 * @param string $fromAddress
	 * @param string $toAddress
	 * @param string $ccAddress
	 * @param string $bccAddress
	 * @param string $subject
	 * @param string $textBody
	 * @param string $htmlBody
	 * @param string $contentType
	 * @param string $mergeContext
	 * @return integer
	 */
	public function addEmailTemplate($placeTitle, $categories, $fromAddress, $toAddress, $ccAddress, $bccAddress, $subject, $textBody, $htmlBody, $contentType, $mergeContext)
	{
		return $this->client->request($this->method(), $placeTitle, $categories, $fromAddress, $toAddress, $ccAddress, $bccAddress, $subject, $textBody, $htmlBody, $contentType, $mergeContext);
	}

	/**
	 * @param integer $contactId
	 * @param string $fromName
	 * @param string $fromAddress
	 * @param string $toAddress
	 * @param string $ccAddress
	 * @param string $bccAddress
	 * @param string $contentType
	 * @param string $subject
	 * @param string $htmlBody
	 * @param string $textBody
	 * @param string $header
	 * @param string $receivedDate
	 * @param string $sentDate
	 * @param integer $emailSentType
	 * @return bool
	 */
	public function attachEmail($contactId, $fromName, $fromAddress, $toAddress, $ccAddress, $bccAddress, $contentType, $subject, $htmlBody, $textBody, $header, $receivedDate, $sentDate, $emailSentType)
	{
		return $this->client->request($this->method(), $contactId, $fromName, $fromAddress, $toAddress, $ccAddress, $bccAddress, $contentType, $subject, $htmlBody, $textBody, $header, $receivedDate, $sentDate, $emailSentType);
	}

	/**
	 * @param integer $templateId
	 * @return array
	 */
	public function getEmailTemplate($templateId)
	{
		return $this->client->request($this->method(), $templateId);
	}

	/**
	 * @param string $email
	 * @return integer
	 */
	public function getOptStatus($email)
	{
		return $this->client->request($this->method(), $email);
	}

	/**
	 * @param string $email
	 * @param string $optInReason
	 * @return bool
	 */
	public function optIn($email, $optInReason)
	{
		return $this->client->request($this->method(), $email, $optInReason);
	}

	/**
	 * @param string $email
	 * @param string $optOutReason
	 * @return bool
	 */
	public function optOut($email, $optOutReason)
	{
		return $this->client->request($this->method(), $email, $optOutReason);
	}

	/**
	 * @param string $contactList
	 * @param string $fromAddress
	 * @param string $toAddress
	 * @param string $ccAddress
	 * @param string $bccAddress
	 * @param string $contentType
	 * @param string $subject
	 * @param string $htmlBody
	 * @param string $textBody
	 * @param string $templateId
	 * @return bool
	 */
	public function sendEmail($contactList, $fromAddress, $toAddress, $ccAddress, $bccAddress, $contentType, $subject, $htmlBody, $textBody, $templateId)
	{
		return $this->client->request($this->method(), $contactList, $fromAddress, $toAddress, $ccAddress, $bccAddress, $contentType, $subject, $htmlBody, $textBody, $templateId);
	}

	/**
	 * @param string $contactList
	 * @param string $templateId
	 * @return bool
	 */
	public function sendTemplate($contactList, $templateId)
	{
		return $this->client->request($this->method(), $contactList, $templateId);
	}

	/**
	 * @param string $templateId
	 * @param string $pieceTitle
	 * @param string $category
	 * @param string $fromAddress
	 * @param string $toAddress
	 * @param string $ccAddress
	 * @param string $bccAddress
	 * @param string $subject
	 * @param string $textBody
	 * @param string $htmlBody
	 * @param string $contentType
	 * @param string $mergeContext
	 * @return bool
	 */
	public function updateEmailTemplate($templateId, $pieceTitle, $category, $fromAddress, $toAddress, $ccAddress, $bccAddress, $subject, $textBody, $htmlBody, $contentType, $mergeContext)
	{
		return $this->client->request($this->method(), $templateId, $pieceTitle, $category, $fromAddress, $toAddress, $ccAddress, $bccAddress, $subject, $textBody, $htmlBody, $contentType, $mergeContext);
	}

}