<?php

namespace Infusionsoft\Api;

class ContactService extends AbstractApi {

	/**
	 * @param array $data
	 * @return integer
	 */
	public function add($data)
	{
		return $this->client->request($this->method(), $data);
	}

	/**
	 * @param integer $contactId
	 * @param integer $duplicateContactId
	 * @return bool
	 */
	public function merge($contactId, $duplicateContactId)
	{
		return $this->client->request($this->method(), $contactId, $duplicateContactId);
	}

	/**
	 * @param integer $contactId
	 * @param integer $campaignId
	 * @return bool
	 */
	public function addToCampaign($contactId, $campaignId)
	{
		return $this->client->request($this->method(), $contactId, $campaignId);
	}

	/**
	 * @param integer $contactId
	 * @param integer $groupId
	 * @return bool
	 */
	public function addToGroup($contactId, $groupId)
	{
		return $this->client->request($this->method(), $contactId, $groupId);
	}

	/**
	 * @param integer $contactId
	 * @param integer $followUpSequenceId
	 * @return integer
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
	 * @param integer $contactId
	 * @param array $selectedFields
	 * @return array
	 */
	public function load($contactId, $selectedFields)
	{
		return $this->client->request($this->method(), $contactId, $selectedFields);
	}

	/**
	 * @param integer $contactId
	 * @param integer $sequenceId
	 * @return bool
	 */
	public function pauseCampaign($contactId, $sequenceId)
	{
		return $this->client->request($this->method(), $contactId, $sequenceId);
	}

	/**
	 * @param integer $contactId
	 * @param integer $followUpSequenceId
	 * @return bool
	 */
	public function removeFromCampaign($contactId, $followUpSequenceId)
	{
		return $this->client->request($this->method(), $contactId, $followUpSequenceId);
	}

	/**
	 * @param integer $contactId
	 * @param integer $tagId
	 * @return bool
	 */
	public function removeFromGroup($contactId, $tagId)
	{
		return $this->client->request($this->method(), $contactId, $tagId);
	}

	/**
	 * @param integer $contactId
	 * @param integer $seqId
	 * @return integer
	 */
	public function resumeCampaignForContact($contactId, $seqId)
	{
		return $this->client->request($this->method(), $contactId, $seqId);
	}

	/**
	 * @param array $contactIds
	 * @param integer $sequenceStepId
	 * @return integer
	 */
	public function rescheduleCampaignStep($contactIds, $sequenceStepId)
	{
		return $this->client->request($this->method(), $contactIds, $sequenceStepId);
	}

	/**
	 * @param integer $contactId
	 * @param integer $actionSetId
	 * @return array
	 */
	public function runActionSequence($contactId, $actionSetId)
	{
		return $this->client->request($this->method(), $contactId, $actionSetId);
	}

	/**
	 * @param array $data
	 * @param string $dupCheckType
	 * @return integer
	 */
	public function addWithDupCheck($data, $dupCheckType)
	{
		return $this->client->request($this->method(), $data, $dupCheckType);
	}

	/**
	 * @param integer $contactId
	 * @param array $data
	 * @return integer
	 */
	public function update($contactId, $data)
	{
		return $this->client->request($this->method(), $contactId, $data);
	}

}