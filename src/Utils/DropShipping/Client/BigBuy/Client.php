<?php

declare(strict_types=1);

namespace App\Utils\DropShipping\Client\BigBuy;

use App\Utils\DropShipping\Client\DropShippingClientInterface;
use Doctrine\Common\Collections\ArrayCollection;
use GuzzleHttp\Client as GuzzleClient;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class Client implements DropShippingClientInterface
{
    public const GET_PRODUCTS_ENDPOINT = '/rest/catalog/products';
    public const GET_PRODUCT_ENDPOINT = '/rest/catalog/product/%s';

    /** @var GuzzleClient */
    private $client;

    /** @var int */
    private $limit;

    /** @var string */
    private $apiKey;

    public function __construct(
      ParameterBagInterface $params
    ) {
        $this->client = new GuzzleClient(['base_uri' => $params->get('BIG_BUY_ENDPOINT')]);
        $this->limit = $params->get('BIG_BUY_LIMIT') ? $params->get('BIG_BUY_LIMIT') : 3;
        $this->apiKey = $params->get('BIG_BUY_API_KEY');
    }

    public function getProductsByCategory(int $categoryId): ArrayCollection
    {
        try {
            $response = $this->client->request(
                'GET',
                self::GET_PRODUCTS_ENDPOINT,
                [
                    'headers' => $this->getRequestHeaders(),
                    'query' => [
                        'isoCode' => 'en',
                        'category' => $categoryId,
                        'pageSize' => $this->limit,
                    ],
                ]);

            if (200 !== $response->getStatusCode()) {
                throw new RequestFailureException();
            }

            return new ArrayCollection(json_decode($response->getBody()->getContents()));
        } catch (\Exception $e) {
            throw new RequestFailureException($e->getMessage());
        }
    }

    public function getProductDetails(int $productId): array
    {
        try {
            $response = $this->client->request(
                'GET',
                sprintf(self::GET_PRODUCT_ENDPOINT, $productId),
                [
                    'headers' => $this->getRequestHeaders(),
                    'query' => [
                        'isoCode' => 'en',
                    ],
                ]);

            if (200 !== $response->getStatusCode()) {
                throw new RequestFailureException();
            }

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            throw new RequestFailureException($e->getMessage());
        }
    }

    public function setHttpClient(GuzzleClient $client): void
    {
        $this->client = $client;
    }

    private function getRequestHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Accept' => 'application/json',
        ];
    }
}
