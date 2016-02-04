<?php

namespace Infusionsoft;

class Token {

	/**
	 * @var string
	 */
	public $accessToken;

	/**
	 * @var string
	 */
	public $refreshToken;

	/**
	 * @var int
	 */
	public $endOfLife;

	/**
	 * @var array
	 */
	public $extraInfo;

	/**
	 * @param array $data
	 */
	function __construct($data = array())
	{
		if (isset($data['access_token']))
		{
			$this->setAccessToken($data['access_token']);
			unset($data['access_token']);
		}

		if (isset($data['refresh_token']))
		{
			$this->setRefreshToken($data['refresh_token']);
			unset($data['refresh_token']);
		}

		if (isset($data['expires_in']))
		{
			$this->setEndOfLife(time() + $data['expires_in']);
			unset($data['expires_in']);
		}

		if (count($data) > 0)
		{
			$this->setExtraInfo($data);
		}
	}

	/**
	 * @return string
	 */
	public function getAccessToken()
	{
		return $this->accessToken;
	}

	/**
	 * @param string $accessToken
	 */
	public function setAccessToken($accessToken)
	{
		$this->accessToken = $accessToken;
	}

	/**
	 * @return int
	 */
	public function getEndOfLife()
	{
		return $this->endOfLife;
	}

	/**
	 * @param int $endOfLife
	 */
	public function setEndOfLife($endOfLife)
	{
		$this->endOfLife = $endOfLife;
	}

	/**
	 * @return string
	 */
	public function getRefreshToken()
	{
		return $this->refreshToken;
	}

	/**
	 * @param string $refreshToken
	 */
	public function setRefreshToken($refreshToken)
	{
		$this->refreshToken = $refreshToken;
	}

	/**
	 * @return array
	 */
	public function getExtraInfo()
	{
		return $this->extraInfo;
	}

	/**
	 * @param array $extraInfo
	 */
	public function setExtraInfo($extraInfo)
	{
		$this->extraInfo = $extraInfo;
	}

    /**
     * Checks if the token is expired
     *
     * @return boolean
     */
    public function isExpired()
    {
        return ($this->getEndOfLife() < time());
    }
}
