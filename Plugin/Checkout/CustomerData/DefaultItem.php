<?php
declare(strict_types=1);

namespace Alpaca\ItGoesForwardHyva\Plugin\Checkout\CustomerData;

use Magento\Checkout\CustomerData\AbstractItem;
use Magento\Quote\Model\Quote\Item;

class DefaultItem
{
    /**
     * @param AbstractItem $subject
     * @param \Closure $proceed
     * @param Item $item
     * @return array
     */
    public function aroundGetItemData(
        AbstractItem $subject,
        \Closure $proceed,
        Item $item
    ): array
    {
        $data = $proceed($item);

        $igf = $item->getProduct()->getCustomOption('it_goes_forward');

        $result = [];

        if ($igf && $igf->getValue()) {
            $result['it_goes_forward'] = $igf->getValue();
        }

        return \array_merge(
            $result,
            $data
        );
    }
}
