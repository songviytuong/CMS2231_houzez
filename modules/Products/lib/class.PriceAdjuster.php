<?php
namespace Products;

abstract class PriceAdjuster
{
    abstract public function get_adjusted_price(\Products\Product $product, $in_price );
    abstract public function unadjust_price(\Products\Product $product, $in_price );
}