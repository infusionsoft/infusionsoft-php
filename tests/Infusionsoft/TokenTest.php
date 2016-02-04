<?php

namespace Infusionsoft;

class TokenTest extends \PHPUnit_Framework_TestCase
{

    public function testIsExpired()
    {
        $token = new Token(array( 'access_token' => '', 'refresh_token' => '', 'expires_in' => 5));
        $this->assertFalse($token->isExpired());

        $token = new Token(array( 'access_token' => '', 'refresh_token' => '', 'expires_in' => -5));
        $this->assertTrue($token->isExpired());
    }
}
