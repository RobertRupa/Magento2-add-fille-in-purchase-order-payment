<?php

namespace Sintra\POEmailAttachment\Model;

use Sintra\POEmailAttachment\Api\Data\PoAttachmentInterface;
use Sintra\POEmailAttachment\Model\PoAttachmentFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
//This is the CRUD Model
/**
 * Class PoAttachment
 * @package Sintra\POEmailAttachment\Model
 */
class PoAttachment extends AbstractModel implements 
    IdentityInterface, PoAttachmentInterface
{
    const CACHE_TAG = 'sintra_po_attachment';

    /**
     * @var PoAttachmentFactory
     */
    private $poAttachmentDataFactory;

    /**
     * PoAttachment constructor.
     * @param PoAttachmentFactory $poAttachmentDataFactory
     * @param Context $context
     * @param Registry $registry
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        PoAttachmentFactory $poAttachmentDataFactory,
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->poAttachmentDataFactory = $poAttachmentDataFactory;
    }
    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init('Sintra\POEmailAttachment\Model\ResourceModel\PoAttachment');
    }
    /**
     * @return string|null
     */
    public function getURL() : string
    {
        return $this->getData(self::URL);
    }
    /**
     * @param int|null $url
     * @return void
     */
    public function setURL(string $url): void
    {
        $this->setData(self::URL, $url);
    }

    /**
     * @return int|null
     */
    public function getQuoteId()
    {
        return $this->getData(self::QUOTE_ID);
    }
    /**
     * @param int|null $id
     * @return void
     */
    public function setQuoteId($id): void
    {
        $this->setData(self::QUOTE_ID, $id);
    }

    /**
     * @return int|null
     */
    public function getOrderId()
    {
        return $this->getData(self::ORDER_ID);
    }
    /**
     * @param int|null $id
     * @return void
     */
    public function setOrderId($id): void
    {
        $this->setData(self::ORDER_ID, $id);
    }

    /**
     * This method is required by implementing IdentityInterface
     * which is meant for caching the model data.
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
