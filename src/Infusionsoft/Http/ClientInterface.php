<?php

namespace Infusionsoft\Http;

interface ClientInterface {

	/**
	 * @return \fXmlRpc\Transport\TransportInterface
	 */
	public function getXmlRpcTransport();

}
