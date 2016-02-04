<?php

namespace Infusionsoft;

use Infusionsoft\Http\ArrayLogger;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class Infusionsoft
{

    /**
     * @var string URL all XML-RPC requests are sent to
     */
    protected $url = 'https://api.infusionsoft.com/crm/xmlrpc/v1';

    /**
     * @var string URL a user visits to authorize an access token
     */
    protected $auth = 'https://signin.infusionsoft.com/app/oauth/authorize';

    /**
     * @var string URL used to request an access token
     */
    protected $tokenUri = 'https://api.infusionsoft.com/token';

    /**
     * @var string
     */
    protected $clientId;

    /**
     * @var string
     */
    protected $clientSecret;

    /**
     * @var string
     */
    protected $redirectUri;

    /**
     * @var array Cache for services so they aren't created multiple times
     */
    protected $apis = array();

    /**
     * @var boolean Determines if API calls should be logged
     */
    protected $debug = false;

    /**
     * @var Http\ClientInterface
     */
    protected $httpClient;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $httpLogAdapter;

    /**
     * @var Http\SerializerInterface
     */
    protected $serializer;

    /**
     * @var boolean
     */
    public $needsEmptyKey = true;

    /**
     * @var Token
     */
    protected $token;

    /**
     * @param array $config
     */
    public function __construct($config = array())
    {
        if (isset($config['clientId'])) $this->clientId = $config['clientId'];

        if (isset($config['clientSecret'])) $this->clientSecret = $config['clientSecret'];

        if (isset($config['redirectUri'])) $this->redirectUri = $config['redirectUri'];

        if (isset($config['debug'])) $this->debug = $config['debug'];
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return string
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * @param string $auth
     * @return string
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;

        return $this;
    }

    /**
     * @return string
     */
    public function getTokenUri()
    {
        return $this->tokenUri;
    }

    /**
     * @param string $tokenUri
     */
    public function setTokenUri($tokenUri)
    {
        $this->tokenUri = $tokenUri;
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param string $clientId
     * @return string
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * @return string
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * @param string $clientSecret
     * @return string
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;

        return $this;
    }

    /**
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * @param string $redirectUri
     * @return string
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthorizationUrl()
    {
        $params = array(
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'response_type' => 'code',
            'scope' => 'full'
        );

        return $this->auth . '?' . http_build_query($params);
    }

    /**
     * @param string $code
     * @return array
     * @throws InfusionsoftException
     */
    public function requestAccessToken($code)
    {
        $params = array(
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->redirectUri,
        );

        $client = $this->getHttpClient();

        $tokenInfo = $client->request('POST', $this->tokenUri, ['body' => http_build_query($params), 'headers' => ['Content-Type' => 'application/x-www-form-urlencoded']]);

        $this->setToken(new Token(json_decode($tokenInfo, true)));

        return $this->getToken();
    }

    /**
     * @return Http\ClientInterface
     */
    public function getHttpClient()
    {
        if (!$this->httpClient) {
            return new Http\GuzzleHttpClient($this->debug, $this->getHttpLogAdapter());
        }

        return $this->httpClient;
    }

    /**
     * @return array
     * @throws InfusionsoftException
     */
    public function refreshAccessToken()
    {
        $headers = array(
            'Authorization' => 'Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret),
            'Content-Type' => 'application/x-www-form-urlencoded'
        );

        $params = array(
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->getToken()->getRefreshToken(),
        );

        $client = $this->getHttpClient();

        $tokenInfo = $client->request('POST', $this->tokenUri, ['body' => http_build_query($params), 'headers' => $headers]);

        $this->setToken(new Token(json_decode($tokenInfo, true)));

        return $this->getToken();
    }

    /**
     * @return Token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param Token $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @param Http\ClientInterface $client
     */
    public function setHttpClient($client)
    {
        $this->httpClient = $client;
    }

    /**
     * @return Http\SerializerInterface
     */
    public function getSerializer()
    {
        if (!$this->serializer) {
            return new Http\InfusionsoftSerializer();
        }

        return $this->serializer;
    }

    /**
     * @param Http\SerializerInterface $serializer
     */
    public function setSerializer(Http\SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @return LoggerInterface
     */
    public function getHttpLogAdapter()
    {
        // If a log adapter hasn't been set, we default to the null adapter
        if (!$this->httpLogAdapter) {
            $this->httpLogAdapter = new ArrayLogger();
        }

        return $this->httpLogAdapter;
    }

    /**
     * @param LoggerInterface $httpLogAdapter
     * @return \Infusionsoft\Infusionsoft
     */
    public function setHttpLogAdapter(LoggerInterface $httpLogAdapter)
    {
        $this->httpLogAdapter = $httpLogAdapter;

        return $this;
    }

    /**
     * @return array
     */
    public function getLogs()
    {
        if (!$this->debug) return array();

        $logger = $this->getHttpLogAdapter();
        if (!$logger instanceof ArrayLogger) return array();

        return $logger->getLogs();
    }

    /**
     * Checks if the current token is null or expired
     *
     * @return boolean
     */
    public function isTokenExpired()
    {
        $token = $this->getToken();

        if ( ! is_object($token)) {
            return true;
        }

        return $token->isExpired();
    }

    /**
     * @throws InfusionsoftException
     * @return mixed
     */
    public function request()
    {
        // Before making the request, we can make sure that the token is still
        // valid by doing a check on the end of life.
        $token = $this->getToken();
        if ($this->isTokenExpired()) {
            throw new TokenExpiredException;
        }

        $url = $this->url . '?' . http_build_query(array('access_token' => $token->getAccessToken()));

        $params = func_get_args();
        $method = array_shift($params);

        // Some older methods in the API require a key parameter to be sent
        // even if OAuth is being used. This flag can be made false as it
        // will break some newer endpoints.
        if ($this->needsEmptyKey) {
            $params = array_merge(array('key' => $token->getAccessToken()), $params);
        }

        // Reset the empty key flag back to the default for the next request
        $this->needsEmptyKey = true;

        $client = $this->getSerializer();
        $response = $client->request($method, $url, $params, $this->getHttpClient());

        return $response;
    }

    /**
     * @param string $method
     * @param string $url
     * @param array  $params
     * @throws InfusionsoftException
     * @return mixed
     */
    public function restfulRequest($method, $url, $params = array())
    {
        // Before making the request, we can make sure that the token is still
        // valid by doing a check on the end of life.
        $token = $this->getToken();
        if ($this->isTokenExpired())
        {
            throw new TokenExpiredException;
        }

        $client = $this->getHttpClient();
        $full_params = [];

        if (strtolower($method) === 'get')
        {
            $params = array_merge(array('access_token' => $token->getAccessToken()), $params);
            $url = $url . '?' . http_build_query($params);
        }
        else
        {
            $url = $url . '?' . http_build_query(array('access_token' => $token->getAccessToken()));
            $full_params['body'] = json_encode($params);
        }

        $full_params['headers'] = array(
            'Content-Type'  => 'application/json',
        );

        $response = (string) $client->request($method, $url, $full_params);
        return json_decode($response, true);
    }

    /**
     * @param boolean $debug
     * @return \Infusionsoft\Infusionsoft
     */
    public function setDebug($debug)
    {
        $this->debug = (bool)$debug;

        return $this;
    }

    /**
     * @param \DateTime|string $datetime
     * @return string
     */
    public function formatDate($datetime = 'now')
    {
        if (!$datetime instanceof \DateTime) {
            $datetime = new \DateTime($datetime, new \DateTimeZone('America/New_York'));
        }
        return $datetime->format('Y-m-d\TH:i:s');
    }

    /**
     * @param $name
     * @throws \UnexpectedValueException
     * @return mixed
     */
    public function __get($name)
    {
        $services = array(
            'affiliatePrograms', 'affiliates', 'contacts', 'data', 'discounts',
            'emails', 'files', 'funnels', 'invoices', 'orders', 'products',
            'search', 'shipping', 'webForms', 'webTracking'
        );

        if (method_exists($this, $name) and in_array($name, $services)) {
            return $this->{$name}();
        }

        throw new \UnexpectedValueException(sprintf('Invalid property: %s', $name));
    }

    /**
     * @return \Infusionsoft\Api\AffiliateProgramService
     */
    public function affiliatePrograms()
    {
        return $this->getApi('AffiliateProgramService');
    }

    /**
     * @return \Infusionsoft\Api\AffiliateService
     */
    public function affiliates()
    {
        return $this->getApi('AffiliateService');
    }

    /**
     * @return \Infusionsoft\Api\ContactService
     */
    public function contacts()
    {
        return $this->getApi('ContactService');
    }

    /**
     * @return \Infusionsoft\Api\DataService
     */
    public function data()
    {
        return $this->getApi('DataService');
    }

    /**
     * @return \Infusionsoft\Api\DiscountService
     */
    public function discounts()
    {
        return $this->getApi('DiscountService');
    }

    /**
     * @return \Infusionsoft\Api\APIEmailService
     */
    public function emails()
    {
        return $this->getApi('APIEmailService');
    }

    /**
     * @return \Infusionsoft\Api\FileService
     */
    public function files()
    {
        return $this->getApi('FileService');
    }

    /**
     * @return \Infusionsoft\Api\FunnelService
     */
    public function funnels()
    {
        return $this->getApi('FunnelService');
    }

    /**
     * @return \Infusionsoft\Api\InvoiceService
     */
    public function invoices()
    {
        return $this->getApi('InvoiceService');
    }

    /**
     * @param string $api
     * @return mixed
     */
    public function orders($api = 'rest')
    {
        if($api == 'xml')
        {
            return $this->getApi('OrderService');
        }

        return $this->getRestApi('OrderService');
    }

    /**
     * @param string $api
     * @return mixed
     */
    public function products($api = 'rest')
    {
        if($api == 'xml')
        {
            return $this->getApi('ProductService');
        }

        return $this->getRestApi('ProductService');
    }

    /**
     * @return \Infusionsoft\Api\SearchService
     */
    public function search()
    {
        return $this->getApi('SearchService');
    }

    /**
     * @return \Infusionsoft\Api\ShippingService
     */
    public function shipping()
    {
        return $this->getApi('ShippingService');
    }

    /**
     * @return \Infusionsoft\Api\WebFormService
     */
    public function webForms()
    {
        return $this->getApi('WebFormService');
    }

    /**
     * @return \Infusionsoft\Api\WebTrackingService
     */
    public function webTracking()
    {
        return $this->getApi('WebTrackingService');
    }

    /**
     * @return \Infusionsoft\Api\Rest\TaskService
     */
    public function tasks()
    {
        return $this->getRestApi('TaskService');
    }

    /**
     * @return \Infusionsoft\Api\Rest\TransactionService
     */
    public function transactions()
    {
        return $this->getRestApi('TransactionService');
    }

    /**
     * Returns the requested class name, optionally using a cached array so no
     * object is instantiated more than once during a request.
     *
     * @param string $class
     * @return mixed
     */
    public function getApi($class)
    {
        $class = '\Infusionsoft\Api\\' . $class;

        if (!array_key_exists($class, $this->apis)) {
            $this->apis[$class] = new $class($this);
        }

        return $this->apis[$class];
    }

    /**
     * Returns the requested class name, optionally using a cached array so no
     * object is instantiated more than once during a request.
     *
     * @param string $class
     * @return mixed
     */
    public function getRestApi($class)
    {
        $class = '\Infusionsoft\Api\Rest\\' . $class;

        if ( ! array_key_exists($class, $this->apis))
        {
            $this->apis[$class] = new $class($this);
        }

        return $this->apis[$class];
    }

}

