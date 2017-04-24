<?php

namespace Infusionsoft\Api;

class CreditCardSubmissionService extends AbstractApi
{

    /**
     * @return mixed
     */
    public function requestCcSubmissionToken($contactId, $successUrl, $failureURL)
    {
        return $this->client->request('CreditCardSubmissionService.requestSubmissionToken', $contactId, $successUrl,
            $failureURL);
    }

    /**
     * @param integer $webFormId
     * @return mixed
     */
    public function requestCreditCardId($token)
    {
        return $this->client->request('CreditCardSubmissionService.requestCreditCardId', $token);
    }

}