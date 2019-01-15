<?php
 
namespace Sintra\POEmailAttachment\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use Sintra\POEmailAttachment\Api\Data\PoAttachmentInterface;
use Sintra\POEmailAttachment\Api\Data\PoAttachmentInterfaceFactory;
use Sintra\POEmailAttachment\Api\Data\PoAttachmentRepositoryInterface;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

class Data extends AbstractHelper
{
    const UPLOAD_DIR = 'po_documents';
    const ALLOWED_EXTENSIONS = [
        'jpg',
        'jpeg',
        'png',
        'tif',
        'pdf'
    ];
    
    /**
     * @var PoAttachmentRepositoryInterface
     */
    private $poAttachmentRepository;

    /**
     * @var PoAttachmentInterfaceFactory
     */
    private $poAttachmentFactory;

    /**
     * @var UploaderFactory
     */
    protected $fileUploaderFactory;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManagerInterface;

 
    /**
     * Data constructor.
     * @param Context $context
     * @param PoAttachmentRepositoryInterface $poAttachmentRepository
     * @param PoAttachmentInterfaceFactory $poAttachmentFactory
     * @param PoAttachmentRepositoryInterface $poAttachmentRepository
     * @param StoreManagerInterface $storeManagerInterface
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        Filesystem $filesystem,
        UploaderFactory $fileUploaderFactory,
        PoAttachmentRepositoryInterface $poAttachmentRepository,
        PoAttachmentInterfaceFactory $poAttachmentFactory,
        StoreManagerInterface $storeManagerInterface)
    {
        $this->fileUploaderFactory = $fileUploaderFactory;
        $this->filesystem = $filesystem;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::UPLOAD);
        $this->poAttachmentRepository = $poAttachmentRepository;
        $this->poAttachmentFactory = $poAttachmentFactory;
        $this->storeManagerInterface = $storeManagerInterface;
    }

    /**
     * Retrive allowed extensions
     * @return string
     */
    public function GetAllowedExtensions(){
        return $allowedExtensions = implode(" ", self::ALLOWED_EXTENSIONS);
    }
    
    /**
     * Add record to PoAttachment table
     *
     * @param array $uploadStatus
     * @param int $quoteID
     * @return int
     */
    public function addToPoAttachmentCollection($uploadStatus, $quoteID){
        try{
            /** @var PoAttachmentInterface $poAttachment */
            $poAttachment = $this->poAttachmentRepository->getByQuoteId($quoteID);
        } catch (NoSuchEntityException $e) {
            /** @var PoAttachmentInterface $poAttachment */
            $poAttachment = $this->poAttachmentFactory->create();
        }
        $uploadDirPath = $this->storeManagerInterface
        ->getStore()
        ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        //= $this->filesystem->getDirectoryRead(DirectoryList::UPLOAD);
        $url = $uploadDirPath . DirectoryList::UPLOAD . '/' . self::UPLOAD_DIR . '/' . $uploadStatus['file'];
 
        $poAttachment->setId($poAttachment->getId());
        $poAttachment->setQuoteId($quoteID);
        $poAttachment->setUrl($url);
        
        $this->poAttachmentRepository->save($poAttachment);
        
        return 0;
    }

     /**
     * Save uploaded file
     *
     * @param string $fileId
     * @return string[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function saveFile($fileId)
    {
        /** @var \Magento\MediaStorage\Model\File\Uploader $uploader */
        $uploader = $this->fileUploaderFactory->create(['fileId' => $fileId]);
        $uploader->setFilesDispersion(false);
        $uploader->setFilenamesCaseSensitivity(false);
        $uploader->setAllowRenameFiles(true);
        $uploader->setAllowedExtensions(self::ALLOWED_EXTENSIONS);

        $uploadDirPath = $this->filesystem->getDirectoryRead(DirectoryList::UPLOAD)->getAbsolutePath();
        $path = $uploadDirPath . '/' . self::UPLOAD_DIR;       
        

        $result = $uploader->save($path);
        unset($result['path']);
        if (!$result) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('File can not be saved to the destination folder.')
            );
        }

        return $result;
    }
    /**
     * Assign order to PoAttachment
     *
     * @param int $quoteID
     * @param int $orderID
     * @return void
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function saveOrderIdToPoAttachment($quoteID, $orderID)
    {
        try{
            /** @var PoAttachmentInterface $poAttachment */
            $poAttachment = $this->poAttachmentRepository->getByQuoteId($quoteID);
            $poAttachment->setOrderId($orderID);
            $this->poAttachmentRepository->save($poAttachment);
        } catch (NoSuchEntityException $e) {
        }
    }
}
