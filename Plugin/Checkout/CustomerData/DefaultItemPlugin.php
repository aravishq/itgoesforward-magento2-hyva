<?php
declare(strict_types=1);

namespace Aravis\ItGoesForwardHyva\Plugin\Checkout\CustomerData;

use Magento\Checkout\CustomerData\AbstractItem;
use Magento\Quote\Model\Quote\Item;

class DefaultItemPlugin
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
        $simple_id = $item->getOptionByCode('simple_product')->getProduct()->getId();

        $result = [];

        if ($igf && $igf->getValue()) {
            $result['it_goes_forward'] = $igf->getValue();
            $result['simple_id'] = $simple_id;
        }

        return \array_merge(
            $result,
            $data
        );
    }
}
