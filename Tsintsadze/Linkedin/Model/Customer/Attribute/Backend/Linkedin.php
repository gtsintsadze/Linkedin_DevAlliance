<?php

namespace Tsintsadze\Linkedin\Model\Customer\Attribute\Backend;

use Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Linkedin extends AbstractBackend
{

    private ScopeConfigInterface $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param $object
     * @return \Magento\Framework\DataObject|Linkedin
     * @throws LocalizedException
     */
    public function beforeSave($object)
    {
        $linkedinUrl = $object->getData('linkedin');

        $linkedinConfigVal = $this->scopeConfig->getValue('customer/create_account/linkedin');

        if ($linkedinConfigVal === 'invisible' || $linkedinConfigVal === "optional") {
            return $object;
        }

        if (!$this->validateLinkedinUrl($linkedinUrl)) {
            throw new LocalizedException(
                __('Linkedin profile URL seems to be incorrect')
            );
        }

        $this->validate($object);

        return $object;
    }

    private function validateLinkedinUrl(string $profileUrl): bool
    {
        $pattern = '/^(http(s)?:\/\/)?([\w]+\.)?linkedin\.com\/(pub|in|profile)/m';
        return preg_match($pattern, $profileUrl);
    }
}
