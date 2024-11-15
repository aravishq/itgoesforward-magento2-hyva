<?php
declare(strict_types=1);

namespace Alpaca\ItGoesForwardHyva\Block\Product\List;

use Magento\Catalog\Model\Product;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable as ConfigurableType;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class IGFListProduct extends Template
{
    private ConfigurableType $configurableProduct;

    public function __construct(
        Context $context,
        ConfigurableType $configurableProduct
    ) {
        $this->configurableProduct = $configurableProduct;
        parent::__construct($context);
    }

    /**
     * Retrieve associated simple products with size attribute value for a configurable product.
     *
     * @param Product $product
     * @return array
     */
    public function getAssociatedSizes(Product $product): array
    {
        if ($product->getTypeId() !== ConfigurableType::TYPE_CODE) {
            return [];
        }

        $simpleProducts = $this->configurableProduct->getUsedProducts($product);

        $sizes = [];
        foreach ($simpleProducts as $simple) {
            $label = $simple->getAttributeText('size');
            $value = $simple->getData('size');

            if ($label) {
                $sizes[$simple->getId()]['label'] = $label;
                $sizes[$simple->getId()]['value'] = $value;
            }
        }
        return $sizes;
    }
}
