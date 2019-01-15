<?php

namespace Sintra\POEmailAttachment\Api\Data;
//This is the data interface of the module.
//It provides consistent API for the model.
/**
 * Interface PoAttachmentInterface
 * @package Sintra\POEmailAttachment\Api\Data
 */
interface PoAttachmentInterface
{
    const ID = 'entity_id';
    const URL = 'url';
    const QUOTE_ID = 'quote_id';
    const ORDER_ID = 'order_id';

    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return void
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getURL(): string;

    /**
     * @param string $url
     * @return void
     */
    public function setURL(string $url): void;

    /**
     * @return int|null
     */
    public function getQuoteId();

    /**
     * @param int $id
     * @return void
     */
    public function setQuoteId($id);

    /**
     * @return int|null
     */
    public function getOrderId();

    /**
     * @param int $id
     * @return void
     */
    public function setOrderId($id);
}
