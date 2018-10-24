<?php

namespace Tests\Yousign;

use PHPUnit\Framework\TestCase;
use Yousign\Client;
use Yousign\ClientFactory;
use Yousign\Environment;
use Yousign\Exception\NotFoundServiceException;
use Yousign\Exception\UnknownClientException;
use Yousign\Services;

class ClientTest extends TestCase
{
    /**
     * @var Client
     */
    private $client;

    protected function setUp()
    {
        $this->client = new Client();
    }

    public function testAddSoapClientShouldThrowExceptionIfNameIsEmpty()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Please given name to your Soap client');

        $this->client->addSoapClient(null, $this->prophesize(\SoapClient::class)->reveal());
    }

    public function testAddSoapClientStoreSuccessfully()
    {
        $result = $this->client->addSoapClient('test', $this->prophesize(\SoapClient::class)->reveal());

        $this->assertInstanceOf(Client::class, $result);
        $this->assertTrue($this->client->hasSoapClient('test'));
    }

    public function testRemoveSoapClient()
    {
        $this->client->addSoapClient('test1', $this->prophesize(\SoapClient::class)->reveal());
        $this->client->addSoapClient('test2', $this->prophesize(\SoapClient::class)->reveal());
        $this->client->addSoapClient('test3', $this->prophesize(\SoapClient::class)->reveal());

        $this->client->removeSoapClient('test2');

        $this->assertTrue($this->client->hasSoapClient('test1'));
        $this->assertTrue($this->client->hasSoapClient('test3'));
        $this->assertFalse($this->client->hasSoapClient('test2'));
    }

    public function testGetSoapClient()
    {
        $this->assertNull($this->client->getSoapClient('test'));

        $this->client->addSoapClient('test', $this->prophesize(\SoapClient::class)->reveal());

        $this->assertInstanceOf(\SoapClient::class, $this->client->getSoapClient('test'));
    }

    public function testHasSoapClient()
    {
        $this->assertFalse($this->client->hasSoapClient('test'));

        $this->client->addSoapClient('test', $this->prophesize(\SoapClient::class)->reveal());

        $this->assertTrue($this->client->hasSoapClient('test'));
    }

    public function testGetLastClient()
    {
        $this->assertNull($this->client->getLastClient());

        $host = (new Environment(Environment::DEMO))->getHost();

        $resultSoap = new \stdClass();
        $resultSoap->return = true;

        $soapClient = $this->getMockFromWsdl(ClientFactory::buildWsdlUrl($host, Services::AUTHENTICATION));
        $soapClient
            ->method('__call')
            ->with('connect', array())
            ->willReturn($resultSoap);

        $this->client->addSoapClient(Services::AUTHENTICATION, $soapClient);

        $this->client->__call('connect', array());

        $this->assertInstanceOf(\SoapClient::class, $this->client->getLastClient());
    }

    public function testMagicCallFunctionShouldExceptionIfServiceNotFound()
    {
        $this->expectException(NotFoundServiceException::class);
        $this->expectExceptionMessage('The called service "test" does not exist');

        $this->client->__call('test', array());
    }

    public function testMagicCallFunctionShouldExceptionIfFoundClientIsNotCorrect()
    {
        $this->expectException(UnknownClientException::class);
        $this->expectExceptionMessage('The soap client for "connect" does not exist');

        $this->client->addSoapClient('test', $this->prophesize(\SoapClient::class)->reveal());

        $this->client->__call('connect', array());
    }

    public function testMagicCallFunctionShouldCallTheGivenFunction()
    {
        $host = (new Environment(Environment::DEMO))->getHost();

        $resultSoap = new \stdClass();
        $resultSoap->return = true;

        $soapClient = $this->getMockFromWsdl(ClientFactory::buildWsdlUrl($host, Services::AUTHENTICATION));
        $soapClient
            ->method('__call')
            ->with('connect', array())
            ->willReturn($resultSoap);

        $this->client->addSoapClient(Services::AUTHENTICATION, $soapClient);

        $result = $this->client->__call('connect', array());

        $this->assertTrue($result);
    }
}
