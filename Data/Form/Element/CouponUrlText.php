<?php

namespace Dotdigitalgroup\Email\Data\Form\Element;

use Magento\Framework\Data\Form\Element\Text;

class CouponUrlText extends Text
{
    /**
     * @return array|string[]
     */
    public function getHtmlAttributes()
    {
        return array_merge(parent::getHtmlAttributes(), [
            'data-baseurl',
            'data-email-merge-field',
        ]);
    }
}
