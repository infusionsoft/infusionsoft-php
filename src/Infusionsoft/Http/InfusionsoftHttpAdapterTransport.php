<?php

namespace Infusionsoft\Http;

use fXmlRpc\Exception\HttpException;
use fXmlRpc\Exception\TransportException;
use fXmlRpc\Transport\TransportInterface;
use Http\Client\Exception as ClientException;
use Http\Client\Exception\HttpException as PsrHttpException;
use Http\Message\MessageFactory;
use Psr\Http\Client\ClientInterface;

class InfusionsoftHttpAdapterTransport implements TransportInterface
{

    private $messageFactory;

    private $client;

    private $defaultOptions;

    public function __construct(MessageFactory $messageFactory, ClientInterface $client, array $options = null)
    {
        $this->client = $client;
        $this->messageFactory = $messageFactory;
        $this->defaultOptions = $options;
    }

    /**
     * @param $endpoint
     * @param $payload
     * @return string
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function send($endpoint, $payload)
    {
        $headers = [];
        if(isset($this->defaultOptions['headers'])) {
            $headers = $this->defaultOptions['headers'];
        }
        $headers['Content-Type'] = 'text/xml; charset=UTF-8';

        try {
            $request = $this->messageFactory->createRequest(
                'POST',
                $endpoint,
                $headers,
                $payload
            );

            $response = $this->client->sendRequest($request);
            if ($response->getStatusCode() !== 200) {
                throw HttpException::httpError($response->getReasonPhrase(), $response->getStatusCode());
            }

            return (string) $response->getBody();

        } catch (PsrHttpException $e) {
            $response = $e->getResponse();
            throw HttpException::httpError($response->getReasonPhrase(), $response->getStatusCode());
        } catch (ClientException $e) {
            throw TransportException::transportError($e);
        }
    }

}
