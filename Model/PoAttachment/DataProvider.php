<?php

namespace Sintra\POEmailAttachment\Model\PoAttachment;

use Sintra\POEmailAttachment\Model\ResourceModel\PoAttachment\CollectionFactory;
use Sintra\POEmailAttachment\Model\ResourceModel\PoAttachment\Collection;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class DataProvider
 * @package Sintra\POEmailAttachment\Model\PoAttachment
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        /** @var Collection collection */
        $this->collection = $collectionFactory->create();
    }
    /**
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $poAttachments = $this->collection->getItems();
        $this->loadedData = [];
        foreach ($poAttachments as $sample) {
            $this->loadedData[$sample->getId()]['poAttachment'] = $poAttachment->getData();
        }
        return $this->loadedData;
    }
}
