<?php

namespace Infusionsoft\Api;

class WebTrackingService extends AbstractApi {

    /**
     * @return mixed
     */
    public function getWebTrackingScriptTag()
    {
        return $this->client->request('WebTrackingService.getWebTrackingScriptTag');
    }

    /**
     * @param integer $webFormId
     * @return mixed
     */
    public function getWebTrackingScriptUrl($webFormId)
    {
        return $this->client->request('WebTrackingService.getWebTrackingScriptUrl');
    }

}