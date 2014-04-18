<?php

namespace Infusionsoft\Api;

class ContactService extends AbstractApi {

	/**
	 * @param struct $data
	 * @return {{return}}
	 */
	public function add($data)
	{
		return $this->client->request($this->method(), $data);
	}

	/**
	 * @param integer $contactId
	 * @param integer $duplicateContactId
	 * @return {{return}}
	 */
	public function merge($contactId, $duplicateContactId)
	{
		return $this->client->request($this->method(), $contactId, $duplicateContactId);
	}

	/**
	 * @param integer $contactId
	 * @param integer $campaingId
	 * @return {{return}}
	 */
	public function addToCampaign($contactId, $campaingId)
	{
		return $this->client->request($this->method(), $contactId, $campaingId);
	}

	/**
	 * @param integer $contactId
	 * @param integer $groupId
	 * @return {{return}}
	 */
	public function addToGroup($contactId, $groupId)
	{
		return $this->client->request($this->method(), $contactId, $groupId);
	}

	/**
	 * @param integer $contactId
	 * @param integer $followUpSequenceId
	 * @return {{return}}
	 */
	public function getNextCampaignStep($contactId, $followUpSequenceId)
	{
		return $this->client->request($this->method(), $contactId, $followUpSequenceId);
	}

	/**
	 * @param string $email
	 * @param array $selectedFields
	 * @return {{return}}
	 */
	public function findByEmail($email, $selectedFields)
	{
		return $this->client->request($this->method(), $email, $selectedFields);
	}

	/**
	 * @param integer $contactId
	 * @param array $selectedFields
	 * @return {{return}}
	 */
	public function load($contactId, $selectedFields)
	{
		return $this->client->request($this->method(), $contactId, $selectedFields);
	}

	/**
	 * @param integer $contactId
	 * @param integer $sequenceId
	 * @return {{return}}
	 */
	public function pauseCampaign($contactId, $sequenceId)
	{
		return $this->client->request($this->method(), $contactId, $sequenceId);
	}

	/**
	 * @param integer $contactId
	 * @param integer $followUpSequenceId
	 * @return {{return}}
	 */
	public function removeFromCampaign($contactId, $followUpSequenceId)
	{
		return $this->client->request($this->method(), $contactId, $followUpSequenceId);
	}

	/**
	 * @param integer $contactId
	 * @param integer $tagId
	 * @return {{return}}
	 */
	public function removeFromGroup($contactId, $tagId)
	{
		return $this->client->request($this->method(), $contactId, $tagId);
	}

	/**
	 * @param integer $contactId
	 * @param integer $seqId
	 * @return {{return}}
	 */
	public function resumeCampaignForContact($contactId, $seqId)
	{
		return $this->client->request($this->method(), $contactId, $seqId);
	}

	/**
	 * @param array $contactIds
	 * @param integer $sequenceStepId
	 * @return {{return}}
	 */
	public function rescheduleCampaignStep($contactIds, $sequenceStepId)
	{
		return $this->client->request($this->method(), $contactIds, $sequenceStepId);
	}

	/**
	 * @param integer $contactId
	 * @param integer $actionSetId
	 * @return {{return}}
	 */
	public function runActionSequence($contactId, $actionSetId)
	{
		return $this->client->request($this->method(), $contactId, $actionSetId);
	}

	/**
	 * @param struct $data
	 * @param string $dupCheckType
	 * @return {{return}}
	 */
	public function addWithDupCheck($data, $dupCheckType)
	{
		return $this->client->request($this->method(), $data, $dupCheckType);
	}

	/**
	 * @param integer $contactId
	 * @param struct $data
	 * @return {{return}}
	 */
	public function update($contactId, $data)
	{
		return $this->client->request($this->method(), $contactId, $data);
	}

}