<?php

declare(strict_types=1);

namespace App\Tests\Unit\Utils\DropShipping\Client\BigBuy;

use App\Utils\DropShipping\Client\BigBuy\Client;
use App\Utils\DropShipping\Client\BigBuy\RequestFailureException;
use Doctrine\Common\Collections\ArrayCollection;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class ClientTest extends TestCase
{
    /** @var Client */
    private $client;

    public function setUp()
    {
        parent::setUp();
        $parameterBag = new ParameterBag([
            'BIG_BUY_API_KEY' => 'somekey',
            'BIG_BUY_ENDPOINT' => 'https://api.sandbox.bigbuy.eu',
            'BIG_BUY_LIMIT' => 3,
        ]);
        $this->client = new Client($parameterBag);
    }

    public function testItGetsProductsByCategory()
    {
        $mock = $this->getProductsMock();
        $fakeClient = $this->getFakeGuzzleClient($mock);
        $this->client->setHttpClient($fakeClient);
        $products = $this->client->getProductsByCategory(2627);
        $this->assertInstanceOf(ArrayCollection::class, $products);
        foreach ($products as $product) {
            $this->assertObjectHasAttribute('id', $product);
            $this->assertObjectHasAttribute('retailPrice', $product);
        }
    }

    public function testItThrowsErrorWhenUnauthorized()
    {
        $mock = $this->getCodeResponseMock(401);
        $fakeClient = $this->getFakeGuzzleClient($mock);
        $this->client->setHttpClient($fakeClient);
        $this->expectException(RequestFailureException::class);
        $this->client->getProductsByCategory(2627);
        $this->expectException(RequestFailureException::class);
        $this->client->getProductDetails(15647);
    }

    public function testItGetsProductDetails()
    {
        $productId = 15647;
        $mock = $this->getProductDetailsMock();
        $fakeClient = $this->getFakeGuzzleClient($mock);
        $this->client->setHttpClient($fakeClient);
        $product = $this->client->getProductDetails($productId);
        $this->assertTrue(is_array($product));
        $this->assertEquals($productId, $product['id']);
        $this->assertArrayHasKey('images', $product);
    }

    private function getFakeGuzzleClient($mock)
    {
        $handlerStack = HandlerStack::create($mock);
        return new GuzzleClient(['handler' => $handlerStack]);
    }

    private function getProductsMock()
    {
        return new MockHandler([
            new Response(200, [], file_get_contents(
                __DIR__ . '/mocks/big_buy_products.json')
            ),
        ]);
    }

    private function getProductDetailsMock()
    {
        return new MockHandler([
            new Response(200, [], file_get_contents(
                __DIR__ . '/mocks/big_buy_product_details.json')
            ),
        ]);
    }

    private function getCodeResponseMock($code)
    {
        return new MockHandler([
            new Response($code),
        ]);
    }
}
