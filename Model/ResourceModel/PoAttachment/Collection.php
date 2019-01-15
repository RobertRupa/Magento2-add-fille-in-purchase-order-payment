<?php

namespace Sintra\POEmailAttachment\Model\ResourceModel\PoAttachment;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Sintra\POEmailAttachment\Model\ResourceModel
 */
class Collection extends AbstractCollection
{
    /**
     * This function is responsible for telling Magento about the model
     * and resource model for the collection class.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Sintra\POEmailAttachment\Model\PoAttachment',
            'Sintra\POEmailAttachment\Model\ResourceModel\PoAttachment'
        );
    }
}
