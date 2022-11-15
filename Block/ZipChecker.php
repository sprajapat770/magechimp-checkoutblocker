<?php

namespace MageChimp\CheckoutBlocker\Block;

use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;

class ZipChecker extends Template
{
    /**
     * @var FormKey
     */
    protected $formKey;

    public function __construct(
        Template\Context $context,
        FormKey $formKey,
        array $data = []
    )
    {
        $this->formKey = $formKey;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     * @throws LocalizedException
     */
    public function getFormKey(): string
    {
        return $this->formKey->getFormKey();
    }


    /**
     * Subscription pref save url.
     *
     * @return string
     */
    public function getZipUrl()
    {
        return $this->getUrl('magechimp/ajax/zipchecker');
    }
}
