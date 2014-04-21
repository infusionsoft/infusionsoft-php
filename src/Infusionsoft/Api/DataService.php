<?php

namespace Infusionsoft\Api;

class DataService extends AbstractApi {

	/**
	 * @param string $table
	 * @param array $values
	 * @return integer
	 */
	public function add($table, $values)
	{
		return $this->client->request($this->method(), $table, $values);
	}

	/**
	 * @param string $table
	 * @param integer $recordId
	 * @param array $wantedFields
	 * @return array
	 */
	public function load($table, $recordId, $wantedFields)
	{
		return $this->client->request($this->method(), $table, $recordId, $wantedFields);
	}

	/**
	 * @param string $table
	 * @param integer $Id
	 * @param array $values
	 * @return array
	 */
	public function update($table, $Id, $values)
	{
		return $this->client->request($this->method(), $table, $Id, $values);
	}

	/**
	 * @param string $table
	 * @param integer $Id
	 * @return bool
	 */
	public function delete($table, $Id)
	{
		return $this->client->request($this->method(), $table, $Id);
	}

	/**
	 * @param string $table
	 * @param integer $limt
	 * @param integer $page
	 * @param string $fieldName
	 * @param string $fieldValue
	 * @param array $returnFields
	 * @return array
	 */
	public function findByField($table, $limt, $page, $fieldName, $fieldValue, $returnFields)
	{
		return $this->client->request($this->method(), $table, $limt, $page, $fieldName, $fieldValue, $returnFields);
	}

	/**
	 * @param string $table
	 * @param integer $limit
	 * @param integer $page
	 * @param array $queryData
	 * @param array $selectedFields
	 * @param string $orderBy
	 * @param boolean $ascending
	 * @return array
	 */
	public function query($table, $limit, $page, $queryData, $selectedFields, $orderBy, $ascending)
	{
		return $this->client->request($this->method(), $table, $limit, $page, $queryData, $selectedFields, $orderBy, $ascending);
	}

	/**
	 * @param string $customFieldType
	 * @param string $displayName
	 * @param string $dataType
	 * @param integer $headerId
	 * @return integer
	 */
	public function addCustomField($customFieldType, $displayName, $dataType, $headerId)
	{
		return $this->client->request($this->method(), $customFieldType, $displayName, $dataType, $headerId);
	}

	/**
	 * @param string $username
	 * @param string $passwordHash
	 * @return integer
	 */
	public function authenticateUser($username, $passwordHash)
	{
		return $this->client->request($this->method(), $username, $passwordHash);
	}

	/**
	 * @param string $module
	 * @param string $setting
	 * @return string
	 */
	public function getAppSetting($module, $setting)
	{
		return $this->client->request($this->method(), $module, $setting);
	}

	/**
	 * @param integer $appointmentId
	 * @return string
	 */
	public function getAppointmentCal($appointmentId)
	{
		return $this->client->request($this->method(), $appointmentId);
	}

	/**
	 * @param string $username
	 * @param string $passwordHash
	 * @return string
	 */
	public function getTemporaryKey($username, $passwordHash)
	{
		return $this->client->request($this->method(), $username, $passwordHash);
	}

	/**
	 * @param integer $customFieldId
	 * @param array $values
	 * @return bool
	 */
	public function updateCustomField($customFieldId, $values)
	{
		return $this->client->request($this->method(), $customFieldId, $values);
	}

}