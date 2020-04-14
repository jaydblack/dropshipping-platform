<?php

declare(strict_types=1);

namespace App\Utils\DropShipping\Client\EBay;

use App\Utils\DropShipping\Client\DropShippingClientInterface;
use Doctrine\Common\Collections\ArrayCollection;
use DTS\eBaySDK\Constants\GlobalIds;
use DTS\eBaySDK\Finding\Services\FindingService;
use DTS\eBaySDK\Finding\Types\FindItemsAdvancedRequest;
use DTS\eBaySDK\Finding\Types\ItemFilter;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class Client implements DropShippingClientInterface
{
    const FILTER_LISTING = 'ListingType';
    const FILTER_BIN_AUCTION = 'AuctionWithBIN';
    const ORDER_LOWEST_PRICE = 'CurrentPriceLowest';
    const RESPONSE_FAILURE = 'Failure';

    /** @var FindingService */
    private $findingService;

    public function __construct(
      ParameterBagInterface $params
    ) {
        $this->findingService = new FindingService([
            'credentials' => $params->get('EBAY_CREDENTIALS'),
            'globalId' => GlobalIds::US,
        ]);
    }

    public function findProductByKeyword(
        string $keyword,
        array $categoryIds = []
    ): ArrayCollection {
        $itemFilter = new ItemFilter();
        $itemFilter->name = self::FILTER_LISTING;
        $itemFilter->value[] = self::FILTER_BIN_AUCTION;

        $request = new FindItemsAdvancedRequest();
        $request->categoryId = $categoryIds;
        $request->itemFilter[] = $itemFilter;
        $request->sortOrder = self::ORDER_LOWEST_PRICE;

        $response = $this->findingService->findItemsAdvanced($request);

        if ($response->errorMessage) {
            foreach ($response->errorMessage->error as $error) {
                throw new WrongResponseException($error->message);
            }
        }

        if ($response->ack === self::RESPONSE_FAILURE) {
            throw new RequestFailureException();
        }

        return new ArrayCollection($response->searchResult->item);
    }
}
