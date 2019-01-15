<?php

namespace Sintra\POEmailAttachment\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class PoAttachment
 * @package Sintra\POEmailAttachment\Model\ResourceModel
 */
class PoAttachment extends AbstractDb
{
    /**
     * This method is responsible for telling Magento which table should be used
     * for model persistence and which column is the ID.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('sintra_po_attachment', 'entity_id');
    }
}
