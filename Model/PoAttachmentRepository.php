<?php

namespace Sintra\POEmailAttachment\Model;

use Sintra\POEmailAttachment\Api\Data\PoAttachmentInterface;
use Sintra\POEmailAttachment\Api\Data\PoAttachmentRepositoryInterface;
use Sintra\POEmailAttachment\Model\ResourceModel\PoAttachment as PoAttachmentResource;
use Sintra\POEmailAttachment\Model\ResourceModel\PoAttachment\CollectionFactory;
use Sintra\POEmailAttachment\Model\PoAttachmentFactory;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class PoAttachmentRepository
 * @package Sintra\PoAttachment\Model
 */
class PoAttachmentRepository implements PoAttachmentRepositoryInterface
{
    /**
     * @var PoAttachmentResource
     */
    private $poAttachmentResource;

    /**
     * @var PoAttachmentFactory
     */
    private $poAttachmentFactory;

    /**
     * @var CollectionFactory
     */
    private $poAttachmentCollectionFactory;

    /**
     * PoAttachmentRepository constructor.
     * @param PoAttachmentResource $poAttachmentResource
     * @param PoAttachmentFactory $poAttachmentFactory
     * @param CollectionFactory $poAttachmentCollectionFactory
     */
    public function __construct(
        PoAttachmentResource $poAttachmentResource,
        PoAttachmentFactory $poAttachmentFactory,
        CollectionFactory $poAttachmentCollectionFactory
    ) {
        $this->poAttachmentResource = $poAttachmentResource;
        $this->poAttachmentFactory = $poAttachmentFactory;
        $this->poAttachmentCollectionFactory = $poAttachmentCollectionFactory;
    }
    /**
     * @param \Sintra\POEmailAttachment\Api\Data\PoAttachmentInterface $poAttachment
     * @return void
     * @throws \Exception
     */
    public function save(\Sintra\POEmailAttachment\Api\Data\PoAttachmentInterface $poAttachment)
    {
        /** @var PoAttachment $poAttachmentModel */
        $poAttachmentModel = $this->poAttachmentFactory->create();
        if ($poAttachment->getId()) {
            $this->poAttachmentResource->load($poAttachmentModel, $poAttachment->getId());
        }
        $poAttachmentModel->setQuoteId($poAttachment->getQuoteId());
        $poAttachmentModel->setURL($poAttachment->getURL());
        $this->poAttachmentResource->save($poAttachment);
    }

    /**
     * @param int $id
     * @return \Sintra\POEmailAttachment\Api\Data\PoAttachmentInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id): \Sintra\POEmailAttachment\Api\Data\PoAttachmentInterface
    {
        /** @var PoAttachment $poAttachmentModel */
        $poAttachmentModel = $this->poAttachmentFactory->create();
        $this->poAttachmentResource->load($poAttachmentModel, $id);
        if (!$poAttachmentModel->getId()) {
            throw new NoSuchEntityException();
        }
        return $poAttachmentModel;
    }

    /**
     * @param \Sintra\POEmailAttachment\Api\Data\PoAttachmentInterface $poAttachment
     * @return void
     * @throws \Exception
     */
    public function delete(\Sintra\POEmailAttachment\Api\Data\PoAttachmentInterface $poAttachment)
    {
        $this->deleteById($poAttachment->getId());
    }

    /**
     * @param int $id
     * @return void
     * @throws \Exception
     */
    public function deleteById($id)
    {
        /** @var PoAttachment $poAttachmentModel */
        $poAttachmentModel = $this->poAttachmentFactory->create();
        $this->poAttachmentResource->load($poAttachmentModel, $id);
        $this->poAttachmentResource->delete($poAttachmentModel);
    }

    /**
     * @param int $id
     * @return \Sintra\POEmailAttachment\Api\Data\PoAttachmentInterface
     * @throws NoSuchEntityException
     */
    public function getByQuoteId($id)
    {
        /** @var PoAttachment $poAttachmentModel */
        $poAttachmentModel = $this->poAttachmentFactory->create();
        $this->poAttachmentResource->load($poAttachmentModel, $id, PoAttachmentInterface::QUOTE_ID);
        if (!$poAttachmentModel->getId()) {
            throw new NoSuchEntityException();
        }
        return $poAttachmentModel;
    }

    /**
     * @param int $id
     * @return \Sintra\POEmailAttachment\Api\Data\PoAttachmentInterface
     * @throws NoSuchEntityException
     */
    public function getByOrderId($id)
    {
        /** @var PoAttachment $poAttachmentModel */
        $poAttachmentModel = $this->poAttachmentFactory->create();
        $this->poAttachmentResource->load($poAttachmentModel, $id, PoAttachmentInterface::ORDER_ID);
        if (!$poAttachmentModel->getId()) {
            throw new NoSuchEntityException();
        }
        return $poAttachmentModel;
    }
}
