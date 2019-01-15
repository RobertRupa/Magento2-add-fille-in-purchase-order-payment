<?php
 
namespace Sintra\POEmailAttachment\Controller\File;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Sintra\POEmailAttachment\Helper\Data as Helper;
use Magento\Checkout\Model\Cart;

class Upload extends \Magento\Framework\App\Action\Action
{
    /**
     * @var Helper
     */
    protected $helper;

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;
    /**
     * @var Cart
     */
    protected $cart;

    /**
     * Save constructor.
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param Helper $helper
     * @param Cart $cart
     */

    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        Helper $helper,
        Cart $cart
        )
    {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->helper = $helper;
        $this->cart = $cart;
        parent::__construct($context);
    }
 
    public function execute()
    {
        $poAttachmentFile = $this->getRequest()->getFiles('files');
        
        if(!isset($poAttachmentFile['tmp_name']) ){
            $poAttachmentFile = $poAttachmentFile[0];
        }

        try{
            $uploadStatus =  $this->helper->saveFile($poAttachmentFile);
        } catch (\Exception $e) {
            $uploadStatus['error'] = $e->getMessage();
        } catch (\Magento\Framework\Exception\LocalizedException $e){
            $uploadStatus['error'] = $e->getMessage();
        } catch (\Error $e) {
            $uploadStatus['error'] = $e->getMessage();
        }

        if($uploadStatus['error']===0 || $uploadStatus['error']==='0'){
            $quoteID = intval($this->cart->getQuote()->getId());
            if(isset($quoteID)){
                $uploadStatus['error'] = $this->helper->addToPoAttachmentCollection($uploadStatus, $quoteID);
            } else {
                $uploadStatus['error'] = "No cart info";
            }
        }
        
        return  $this->resultJsonFactory->create()->setData($uploadStatus);
    }
}
