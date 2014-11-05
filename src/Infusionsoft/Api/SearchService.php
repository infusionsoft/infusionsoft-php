<?php

namespace Infusionsoft\Api;

class SearchService extends AbstractApi {

	/**
	 * @param integer $savedSearchId
	 * @param integer $userId
	 * @return mixed
	 */
	public function getAllReportColumns($savedSearchId, $userId)
	{
		return $this->client->request('SearchService.getAllReportColumns', $savedSearchId, $userId);
	}

	/**
	 * @param integer $savedSearchId
	 * @param integer $userId
	 * @param integer $pageNumber
	 * @return mixed
	 */
	public function getSavedSearchResultsAllFields($savedSearchId, $userId, $pageNumber)
	{
		return $this->client->request('SearchService.getSavedSearchResultsAllFields', $savedSearchId, $userId, $pageNumber);
	}

	/**
	 * @param integer $savedSearchId
	 * @param integer $userId
	 * @param integer $pageNumber
	 * @param array $returnFields
	 * @return mixed
	 */
	public function getSavedSearchResults($savedSearchId, $userId, $pageNumber, $returnFields)
	{
		return $this->client->request('SearchService.getSavedSearchResults', $savedSearchId, $userId, $pageNumber, $returnFields);
	}

	/**
	 * @param integer $userId
	 * @return mixed
	 */
	public function getAvailableQuickSearches($userId)
	{
		return $this->client->request('SearchService.getAvailableQuickSearches', $userId);
	}

	/**
	 * @param integer $quickSearchType
	 * @param integer $userId
	 * @param integer $searchData
	 * @param integer $page
	 * @param integer $returnLimit
	 * @return mixed
	 */
	public function quickSearch($quickSearchType, $userId, $searchData, $page, $returnLimit)
	{
		return $this->client->request('SearchService.quickSearch', $quickSearchType, $userId, $searchData, $page, $returnLimit);
	}

	/**
	 * @param integer $userId
	 * @return mixed
	 */
	public function getDefaultQuickSearch($userId)
	{
		return $this->client->request('SearchService.getDefaultQuickSearch', $userId);
	}

}