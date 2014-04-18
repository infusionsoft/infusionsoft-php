<?php

namespace Infusionsoft\Api;

class ContactService extends AbstractApi {

	/**
	 * @param array $data
	 * @return int
	 */
	public function add($data)
	{
		return $this->client->request($this->method(), $data);
	}

	/**
	 * @param int $contactId
	 * @param int $duplicateContactId
	 * @return boolean
	 */
	public function merge($contactId, $duplicateContactId)
	{
		return $this->client->request($this->method(), $contactId, $duplicateContactId);
	}

	/**
	 * @param int $contactId
	 * @param int $campaignId
	 * @return boolean
	 */
	public function addToCampaign($contactId, $campaignId)
	{
		return $this->client->request($this->method(), $contactId, $campaignId);
	}

	/**
	 * @param int $contactId
	 * @param int $groupId
	 * @return boolean
	 */
	public function addToGroup($contactId, $groupId)
	{
		return $this->client->request($this->method(), $contactId, $groupId);
	}

	/**
	 * @param int $contactId
	 * @param int $followUpSequenceId
	 * @return int
	 */
	public function getNextCampaignStep($contactId, $followUpSequenceId)
	{
		return $this->client->request($this->method(), $contactId, $followUpSequenceId);
	}

	/**
	 * @param string $email
	 * @param array $selectedFields
	 * @return array
	 */
	public function findByEmail($email, $selectedFields)
	{
		return $this->client->request($this->method(), $email, $selectedFields);
	}

	/**
	 * @param int $contactId
	 * @param array $selectedFields
	 * @return array
	 */
	public function load($contactId, $selectedFields)
	{
		return $this->client->request($this->method(), $contactId, $selectedFields);
	}

	/**
	 * @param int $contactId
	 * @param int $sequenceId
	 * @return boolean
	 */
	public function pauseCampaign($contactId, $sequenceId)
	{
		return $this->client->request($this->method(), $contactId, $sequenceId);
	}

	/**
	 * @param int $contactId
	 * @param int $followUpSequenceId
	 * @return boolean
	 */
	public function removeFromCampaign($contactId, $followUpSequenceId)
	{
		return $this->client->request($this->method(), $contactId, $followUpSequenceId);
	}

	/**
	 * @param int $contactId
	 * @param int $groupId
	 * @return boolean
	 */
	public function removeFromGroup($contactId, $groupId)
	{
		return $this->client->request($this->method(), $contactId, $groupId);
	}

	/**
	 * @param int $contactId
	 * @param int $sequenceId
	 * @return boolean
	 */
	public function resumeCampaignForContact($contactId, $sequenceId)
	{
		return $this->client->request($this->method(), $contactId, $sequenceId);
	}

	/**
	 * @param array $contactIds
	 * @param int $sequenceStepId
	 * @return int
	 */
	public function rescheduleCampaignStep($contactIds, $sequenceStepId)
	{
		return $this->client->request($this->method(), $contactIds, $sequenceStepId);
	}

	/**
	 * @param int $contactId
	 * @param int $actionSetId
	 * @return array
	 */
	public function runActionSequence($contactId, $actionSetId)
	{
		return $this->client->request($this->method(), $contactId, $actionSetId);
	}

	/**
	 * @param array $data
	 * @param string $checkType
	 * @return int
	 */
	public function addWithDupCheck($data, $checkType)
	{
		return $this->client->request($this->method(), $data, $checkType);
	}

	/**
	 * @param int $contactId
	 * @param array $data
	 * @return int
	 */
	public function update($contactId, $data)
	{
		return $this->client->request($this->method(), $contactId, $data);
	}

}