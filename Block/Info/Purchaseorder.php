<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Sintra\POEmailAttachment\Block\Info;

use Sintra\POEmailAttachment\Api\Data\PoAttachmentRepositoryInterface;

class Purchaseorder extends \Magento\Payment\Block\Info
{
     /**
     * @var PoAttachmentRepositoryInterface
     */
    protected $poAttachmentRepository;

    /**
     * Data constructor.
     * @param PoAttachmentRepositoryInterface $poAttachmentRepository
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        PoAttachmentRepositoryInterface $poAttachmentRepository,
        array $data = [])
    {

        $this->poAttachmentRepository = $poAttachmentRepository;
        parent::__construct($context, $data);
    }

    /**
     * @var string
     */
    protected $_template = 'Sintra_POEmailAttachment::info/purchaseorder.phtml';

    /**
     * @return string
     */
    public function toPdf()
    {
        $this->setTemplate('Sintra_POEmailAttachment::info/pdf/purchaseorder.phtml');
        return $this->toHtml();
    }

    /**
     * @return string
     */
    public function getPoAttachment()
    {
        $info = $this->getInfo();
        $quoteID = $info->getData('entity_id');
        /** @var PoAttachmentInterface $poAttachment */
        $poAttachment = $this->poAttachmentRepository->getByOrderId($quoteID);
        return $poAttachment->getURL();
    }
}
