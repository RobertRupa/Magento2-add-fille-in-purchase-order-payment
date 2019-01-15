<?php

namespace Sintra\POEmailAttachment\Plugin\Checkout;

use Magento\Checkout\Block\Checkout\LayoutProcessor;
use Sintra\POEmailAttachment\Helper\Data as Helper;

class LayoutProcessorPlugin
{
    /**
     * @var Helper
     */
    protected $helper;

    /**
     * LayoutProcessor constructor.
     * @param Helper $helper
     */
    public function __construct(
        Helper $helper)
    {

        $this->helper = $helper;
    }

    /**
     * @param LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        LayoutProcessor $subject,
        array $jsLayout
    ) {
        $component = [
            'component' => 'Sintra_POEmailAttachment/js/upload',
            'config' => [
                'formElement' => 'fileUploader',
                'componentType' => 'fileUploader',
                'elementTmpl' => 'Sintra_POEmailAttachment/components/file-uploader',
                'template' => 'ui/form/field',
                'allowedExtensions' => $this->helper->GetAllowedExtensions(),
                'dataScope' => 'poattachment',
                'uploaderConfig' =>[
                    'url' => '/poemailattachment/file/upload'
                ]
            ],
            'visible' => false,
            'provider' => 'checkoutProvider',
            'dataScope' => 'PoAttachmentForm.upload',
            'label' => 'Additional documents',
            'validation' => [
                'required-entry' => true,
            ]
        ];
        $jsLayout['components']['checkout']['children']['steps']['children']
        ['billing-step']['children']['payment']['children']['afterMethods']['children']
        ['po_file_uploader'] = $component;
        return $jsLayout;
    }
}
