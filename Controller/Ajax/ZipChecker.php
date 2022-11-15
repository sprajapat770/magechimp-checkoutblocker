<?php

namespace MageChimp\CheckoutBlocker\Controller\Ajax;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Data\Form\FormKey\Validator as FormKeyValidator;

class ZipChecker implements ActionInterface
{
    const ZIP_XML_CODES = 'magechimp/zip/codes';
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var JsonFactory
     */
    private $jsonResultFactory;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var FormKeyValidator
     */
    private $formKeyValidator;


    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param JsonFactory $jsonResultFactory
     * @param RequestInterface $request
     * @param FormKeyValidator $formKeyValidator
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        JsonFactory          $jsonResultFactory,
        RequestInterface     $request,
        FormKeyValidator     $formKeyValidator
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->jsonResultFactory = $jsonResultFactory;
        $this->request = $request;
        $this->formKeyValidator = $formKeyValidator;
    }

    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        /** @var RequestInterface $zipCode */
        $zipCode = $this->request->getPost('zip_code');
        //$value = $this->getRequest()->getPost('comments');
        $isCheckout = $this->request->getPost('is_checkout');

        $data['zipCode'] = $zipCode;
        $data['error'] = true;
        $data['message'] = __('There was a problem with the Server.');
        $validFormKey = $this->formKeyValidator->validate($this->request);

        /** @var \Magento\Framework\Controller\Result\Json $result */
        $result = $this->jsonResultFactory->create();

        $configData = $this->scopeConfig->getValue(self::ZIP_XML_CODES);
        if (($validFormKey || $isCheckout ) && $this->request->isPost() && $zipCode && $configData) {
            $zipCodes = \explode(',', $configData);

            if (in_array($zipCode, $zipCodes)) {
                $data['error'] = false;
                $data['message'] = __('Available for delivery');
            }else{
                $data['error'] = true;
                $data['message'] = __('Not Available in your area');
            }
        }

        $result->setData($data);
        return $result;
    }
}
