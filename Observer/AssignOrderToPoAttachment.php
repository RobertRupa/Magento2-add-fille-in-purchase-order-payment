<?php

namespace Sintra\POEmailAttachment\Observer;

use Sintra\POEmailAttachment\Helper\Data as Helper;
use Magento\Sales\Model\OrderRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;

class AssignOrderToPoAttachment implements \Magento\Framework\Event\ObserverInterface
{
  /**
   * @var Helper
   */
  protected $helper;

  /**
   * @var OrderRepository
   */
  protected $orderRepository;

  /**
   * @var SearchCriteriaBuilder
   */
  protected $searchCriteriaBuilder;

  /**
    * AssignOrderToPoAttachment constructor.
    * @param Helper $helper
    */

  public function __construct(
    Helper $helper,
    OrderRepository $orderRepository,
    SearchCriteriaBuilder $searchCriteriaBuilder
  )
  {
    $this->helper = $helper;
    $this->orderRepository = $orderRepository;
    $this->searchCriteriaBuilder = $searchCriteriaBuilder;
  }
  /**
   * @param \Magento\Framework\Event\Observer $observer
   * @return $this
   */
  public function execute(\Magento\Framework\Event\Observer $observer)
  {
    $order = $observer->getEvent()->getOrder();
    $quote = $observer->getEvent()->getQuote();
    $quoteId = $order->getQuoteId();
    $orderId = $order->getId();//$moirmg->fef();
    $payment = $order->getPayment();
    $method = $payment->getMethodInstance();
    $methodTitle = $method->getTitle();
    if($methodTitle === "Purchase Order"){
      $this->helper->saveOrderIdToPoAttachment($quoteId, $orderId);
    }
    return $this;
  }
}
