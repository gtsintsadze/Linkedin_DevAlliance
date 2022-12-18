<?php

namespace Giorgi\Tsignadze\Model\Config\Backend;

namespace Tsintsadze\Linkedin\Model\Config\Backend;

use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Value;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class Linkedin extends Value
{
    private CustomerSetup $CustomerSetup;

    public function __construct(
        Context $context,
        Registry $registry,
        CustomerSetup $customerSetup,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $config,
            $cacheTypeList,
            $resource,
            $resourceCollection,
            $data
        );
        $this->CustomerSetup=$customerSetup;
    }

    public function updateAttr($required, $attributeCode): void
    {
    }

    public function afterSave()
    {
        $value = $this->getValue();

        if ($value === 'optional' || $value === 'invisible') {
            $required = false;
            $this->updateAttr(false, 'linkedin');
        } else {
            $required = true;
            $this->updateAttr(true, 'linkedin');
        }

        $attr = $this->CustomerSetup->getEavConfig()->getAttribute(CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER, 'linkedin');

        if ($attr->getIsRequired() !== $required) {
            $this->CustomerSetup->updateAttribute(
                CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER,
                'linkedin',
                'is_required',
                $required
            );
        }

        return parent::afterSave();
    }
}
