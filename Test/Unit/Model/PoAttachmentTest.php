<?php

namespace Sintra\POEmailAttachment\Test\Unit\Model;
use Sintra\POEmailAttachment\Api\Data\PoAttachmentInterface;
use Sintra\POEmailAttachment\Model\PoAttachmentFactory;
use Sintra\POEmailAttachment\Model\ResourceModel\PoAttachment as PoAttachmentResource;
use Sintra\POEmailAttachment\Model\PoAttachment;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
/**
 * Class PoAttachmentTest
 * @package Sintra\POEmailAttachment\Test\Unit\Model
 */
class PoAttachmentTest extends TestCase
{
    private $poAttachmentFactory;
    private $context;
    private $registry;
    private $abstractResource;
    private $abstractDB;
    private $PoAttachment;
    private $objectManager;
    protected function setUp()
    {
        $this->poAttachmentFactory = $this->getMockBuilder(PoAttachmentFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->context = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->registry = $this->getMockBuilder(Registry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->abstractResource = $this->getMockBuilder(PoAttachmentResource::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->abstractDB = $this->getMockBuilder(AbstractDb::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $this->objectManager = new ObjectManager($this);
        $this->poAttachment = $this->objectManager->getObject(
            PoAttachment::class,
            [
                'poAttachmentDataFactory' => $this->poAttachmentFactory,
                'context' => $this->context,
                'registry' => $this->registry,
                'resource' => $this->abstractResource,
                'resourceCollection' => $this->abstractDB,
                'data' => []
            ]
        );
    }
    /**
     * @test
     */
    public function testGetIdentities()
    {
        $id = 1;
        $this->poAttachment->setId($id);
        $expectedIdentity = 'sintra_po_attachment_' . $id;
        $this->assertEquals(
            [$expectedIdentity],
            $this->poAttachment->getIdentities()
        );
    }
}