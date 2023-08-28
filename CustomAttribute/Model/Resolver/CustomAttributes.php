<?php

namespace AHT\CustomAttribute\Model\Resolver;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;

class CustomAttributes implements ResolverInterface
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    public function resolve($field, $context, ResolveInfo $info, $value = null, $args = null)
    {
        $fieldName = $info->fieldName;
        if (method_exists($this, $fieldName)) {
            return $this->$fieldName($value, $args, $context, $info);
        }
        return null;
    }

    private function specifications($value, $args, $context, $info)
    {
        $product = $value;
        $attributeValue = $product->getAttribute('specifications')->getFrontend()->getValue($product);
        return $attributeValue;
    }

}
