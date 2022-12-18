<?php

namespace Tsintsadze\Linkedin\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class LinkedinValue implements ArrayInterface
{

    public function toOptionArray(): array
    {
        return [
            ['value' => 'invisible', 'label' => __('invisible')],
            ['value' => 'optional', 'label' => __('optional')],
            ['value' => 'required', 'label' => __('required')],
        ];
    }
}
