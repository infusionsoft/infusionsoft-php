<?php

namespace Infusionsoft\Api;

class ContactService extends AbstractApi {

	/**
	 * @param array $data
	 * @return integer
	 */
	public function add($data)
	{
		return $this->client->request('ContactService.add', $data);
	}

	/**
	 * @param integer $contactId
	 * @param integer $duplicateContactId
	 * @return bool
	 */
	public function merge($contactId, $duplicateContactId)
	{
		return $this->client->request('ContactService.merge', $contactId, $duplicateContactId);
	}

	/**
	 * @param integer $contactId
	 * @param integer $campaignId
	 * @return bool
	 */
	public function addToCampaign($contactId, $campaignId)
	{
		return $this->client->request('ContactService.addToCampaign', $contactId, $campaignId);
	}

	/**
	 * @param integer $contactId
	 * @param integer $groupId
	 * @return bool
	 */
	public function addToGroup($contactId, $groupId)
	{
		return $this->client->request('ContactService.addToGroup', $contactId, $groupId);
	}

	/**
	 * @param integer $contactId
	 * @param integer $followUpSequenceId
	 * @return integer
	 */
	public function getNextCampaignStep($contactId, $followUpSequenceId)
	{
		return $this->client->request('ContactService.getNextCampaignStep', $contactId, $followUpSequenceId);
	}

	/**
	 * @param string $email
	 * @param array $selectedFields
	 * @return array
	 */
	public function findByEmail($email, $selectedFields)
	{
		return $this->client->request('ContactService.findByEmail', $email, $selectedFields);
	}

	/**
	 * @param integer $contactId
	 * @param array $selectedFields
	 * @return array
	 */
	public function load($contactId, $selectedFields)
	{
		return $this->client->request('ContactService.load', $contactId, $selectedFields);
	}

	/**
	 * @param integer $contactId
	 * @param integer $sequenceId
	 * @return bool
	 */
	public function pauseCampaign($contactId, $sequenceId)
	{
		return $this->client->request('ContactService.pauseCampaign', $contactId, $sequenceId);
	}

	/**
	 * @param integer $contactId
	 * @param integer $followUpSequenceId
	 * @return bool
	 */
	public function removeFromCampaign($contactId, $followUpSequenceId)
	{
		return $this->client->request('ContactService.removeFromCampaign', $contactId, $followUpSequenceId);
	}

	/**
	 * @param integer $contactId
	 * @param integer $tagId
	 * @return bool
	 */
	public function removeFromGroup($contactId, $tagId)
	{
		return $this->client->request('ContactService.removeFromGroup', $contactId, $tagId);
	}

	/**
	 * @param integer $contactId
	 * @param integer $seqId
	 * @return integer
	 */
	public function resumeCampaignForContact($contactId, $seqId)
	{
		return $this->client->request('ContactService.resumeCampaignForContact', $contactId, $seqId);
	}

	/**
	 * @param array $contactIds
	 * @param integer $sequenceStepId
	 * @return integer
	 */
	public function rescheduleCampaignStep($contactIds, $sequenceStepId)
	{
		return $this->client->request('ContactService.rescheduleCampaignStep', $contactIds, $sequenceStepId);
	}

	/**
	 * @param integer $contactId
	 * @param integer $actionSetId
	 * @return array
	 */
	public function runActionSequence($contactId, $actionSetId)
	{
		return $this->client->request('ContactService.runActionSequence', $contactId, $actionSetId);
	}

	/**
	 * @param array $data
	 * @param string $dupCheckType
	 * @return integer
	 */
	public function addWithDupCheck($data, $dupCheckType)
	{
		return $this->client->request('ContactService.addWithDupCheck', $data, $dupCheckType);
	}

	/**
	 * @param integer $contactId
	 * @param array $data
	 * @return integer
	 */
	public function update($contactId, $data)
	{
		return $this->client->request('ContactService.update', $contactId, $data);
	}

}