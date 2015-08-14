<?php

namespace Infusionsoft\Http;

use fXmlRpc\Transport\HttpAdapterTransport;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Request;
use Ivory\HttpAdapter\Guzzle6HttpAdapter;

class GuzzleHttpClient extends Client implements ClientInterface
{

    public $debug;
    public $httpLogAdapter;

    public function __construct($debug, $httpLogAdapter, callable $requestWrapper = null)
    {
        parent::__construct();
        $this->debug = $debug;
        $this->httpLogAdapter = $httpLogAdapter;
        $this->requestWrapper = $requestWrapper;
    }

    /**
     * @return \fXmlRpc\Transport\TransportInterface
     */
    public function getXmlRpcTransport()
    {
        return new HttpAdapterTransport(new Guzzle6HttpAdapter($this));
    }

    /**
     * Sends a request to the given URI and returns the raw response.
     *
     * @param string $uri
     * @param array $body
     * @param array $headers
     * @param string $method
     * @return mixed
     * @throws HttpException
     */
    public function request($method, $uri, array $options = [])
    {
        try
        {
            if ($this->debug)
            {
                // TODO: add guzzle logging
            }

            $request = new Request($method, $uri, $options['headers'], $options['body']);

            if ($this->requestWrapper) {
                $response = call_user_func($this->requestWrapper, $request);
            } else {
                $response = $this->send($request);
            }

            return $response->getBody()->getContents();
        }
        catch (BadResponseException $e)
        {
            throw new HttpException($e);
        }
    }
}