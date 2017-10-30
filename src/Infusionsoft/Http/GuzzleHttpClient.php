<?php

namespace Infusionsoft\Http;

use fXmlRpc\Transport\HttpAdapterTransport;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Psr7\Request;
use Ivory\HttpAdapter\Configuration;
use Ivory\HttpAdapter\Guzzle6HttpAdapter;
use GuzzleHttp\Middleware;
use Psr\Log\LoggerInterface;

class GuzzleHttpClient extends Client implements ClientInterface
{

    public $debug;
    public $httpLogAdapter;

    public function __construct($debug, LoggerInterface $httpLogAdapter)
    {
        $this->debug = $debug;
        $this->httpLogAdapter = $httpLogAdapter;

        $config = [];
        if($this->debug){
            $config['handler'] = HandlerStack::create();
            $config['handler']->push(
                Middleware::log($this->httpLogAdapter, new MessageFormatter(MessageFormatter::DEBUG))
            );
        }

        parent::__construct($config);
    }

    /**
     * @return \fXmlRpc\Transport\TransportInterface
     */
    public function getXmlRpcTransport()
    {
	    $config = new Configuration();
	    $config->setTimeout( 60 );

	    return new HttpAdapterTransport(new Guzzle6HttpAdapter($this, $config));
    }

    /**
     * Sends a request to the given URI and returns the raw response.
     *
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return mixed
     * @throws HttpException
     */
    public function request($method, $uri = NULL, array $options = [])
    {
        if(!isset($options['headers'])){
            $options['headers'] = [];
        }

        if(!isset($options['body'])){
            $options['body'] = null;
        }

        try
        {
            $request = new Request($method, $uri, $options['headers'], $options['body']);
            $response = $this->send($request);

            return $response->getBody();
        }
        catch (BadResponseException $e)
        {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
