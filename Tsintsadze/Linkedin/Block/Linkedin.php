<?php

namespace Tsintsadze\Linkedin\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Customer\Block\Account\Dashboard;

class Linkedin extends Template
{
    protected $scopeConfig;

    protected $Dashboard;

    public function __construct(
        Template\Context $context,
        ScopeConfigInterface $scopeConfig,
        Dashboard $Dashboard,
        array $data = []
    )
    {
        $this->Dashboard=$Dashboard;
        $this->scopeConfig=$scopeConfig;
        parent::__construct($context, $data);
    }

    public function getLinkedinConfigValue()
    {
        return $this->scopeConfig->getValue('customer/create_account/linkedin');
    }

    public function getLinkedin()
    {
        if ($_SERVER['REQUEST_URI'] === '/customer/account/edit/') {
            return $this->Dashboard->getCustomer()->getCustomAttribute('linkedin')->getValue();
        }
        return null;
    }
}
