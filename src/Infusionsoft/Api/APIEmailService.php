<?php

namespace Infusionsoft\Api;

class APIEmailService extends AbstractApi {

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
		return $this->client->request('APIEmailService.addEmailTemplate', $placeTitle, $categories, $fromAddress, $toAddress, $ccAddress, $bccAddress, $subject, $textBody, $htmlBody, $contentType, $mergeContext);
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
		return $this->client->request('APIEmailService.attachEmail', $contactId, $fromName, $fromAddress, $toAddress, $ccAddress, $bccAddress, $contentType, $subject, $htmlBody, $textBody, $header, $receivedDate, $sentDate, $emailSentType);
	}

	/**
	 * @param integer $templateId
	 * @return array
	 */
	public function getEmailTemplate($templateId)
	{
		return $this->client->request('APIEmailService.getEmailTemplate', $templateId);
	}

	/**
	 * @param string $email
	 * @return integer
	 */
	public function getOptStatus($email)
	{
		return $this->client->request('APIEmailService.getOptStatus', $email);
	}

	/**
	 * @param string $email
	 * @param string $optInReason
	 * @return bool
	 */
	public function optIn($email, $optInReason)
	{
		return $this->client->request('APIEmailService.optIn', $email, $optInReason);
	}

	/**
	 * @param string $email
	 * @param string $optOutReason
	 * @return bool
	 */
	public function optOut($email, $optOutReason)
	{
		return $this->client->request('APIEmailService.optOut', $email, $optOutReason);
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
	 * @return bool
	 */
	public function sendEmail($contactList, $fromAddress, $toAddress, $ccAddress, $bccAddress, $contentType, $subject, $htmlBody, $textBody)
	{
		return $this->client->request('APIEmailService.sendEmail', $contactList, $fromAddress, $toAddress, $ccAddress, $bccAddress, $contentType, $subject, $htmlBody, $textBody);
	}

	/**
	 * @param array $contactList
	 * @param integer $templateId
	 * @return bool
	 */
	public function sendTemplate($contactList, $templateId)
	{
		return $this->client->request('APIEmailService.sendEmail', $contactList, $templateId);
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
		return $this->client->request('APIEmailService.updateEmailTemplate', $templateId, $pieceTitle, $category, $fromAddress, $toAddress, $ccAddress, $bccAddress, $subject, $textBody, $htmlBody, $contentType, $mergeContext);
	}

}