<?php

namespace Sintra\POEmailAttachment\Api\Data;
//This is the service contract of the module.
//It provides a consistent API for handling Data Objects.
/**
 * Interface PoAttachmentRepositoryInterface
 * @package Sintra\POEmailAttachment\Api\Data
 */
interface PoAttachmentRepositoryInterface
{
    /**
     * @param PoAttachmentInterface $poAttachment
     * @return void
     */
    public function save(\Sintra\POEmailAttachment\Api\Data\PoAttachmentInterface $poAttachment);
    
    /**
     * @param int $id
     * @return \Sintra\POEmailAttachment\Api\Data\PoAttachmentInterface
     */
    public function getById($id);
    
    /**
     * @param int $id
     * @return \Sintra\POEmailAttachment\Api\Data\PoAttachmentInterface
     */
    public function getByQuoteId($id);
    
    /**
     * @param int $id
     * @return \Sintra\POEmailAttachment\Api\Data\PoAttachmentInterface
     */
    public function getByOrderId($id);
   
    /**
     * @param \Sintra\POEmailAttachment\Api\Data\PoAttachmentInterface $poAttachment
     * @return void
     */
    public function delete(\Sintra\POEmailAttachment\Api\Data\PoAttachmentInterface $poAttachment);

    /**
     * @param int $id
     * @return void
     */
    public function deleteById($id);
}
