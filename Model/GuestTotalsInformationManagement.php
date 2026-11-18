<?php
declare(strict_types=1);

namespace Punchout2Go\Punchout\Model;

/**
 * Class GuestTotalsInformationManagement
 * @package Punchout2Go\Punchout\Model
 */
class GuestTotalsInformationManagement implements \Punchout2Go\Punchout\Api\GuestTotalsInformationManagementInterface
{
    /**
     * @var \Magento\Quote\Model\QuoteIdMaskFactory
     */
    protected $quoteIdMaskFactory;

    /**
     * @var \Magento\Quote\Model\ResourceModel\Quote\QuoteIdMask
     */
    protected $quoteIdMaskResource;

    /**
     * @var \Magento\Checkout\Api\TotalsInformationManagementInterface
     */
    protected $totalsInformationManagement;

    /**
     * GuestTotalsInformationManagement constructor.
     * @param \Magento\Quote\Model\QuoteIdMaskFactory $quoteIdMaskFactory
     * @param \Punchout2Go\Punchout\Api\TotalsInformationManagementInterface $totalsInformationManagement
     * @param \Magento\Quote\Model\ResourceModel\Quote\QuoteIdMask $quoteIdMaskResource
     */
    public function __construct(
        \Magento\Quote\Model\QuoteIdMaskFactory $quoteIdMaskFactory,
        \Punchout2Go\Punchout\Api\TotalsInformationManagementInterface $totalsInformationManagement,
        \Magento\Quote\Model\ResourceModel\Quote\QuoteIdMask $quoteIdMaskResource
    ) {
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->totalsInformationManagement = $totalsInformationManagement;
        $this->quoteIdMaskResource = $quoteIdMaskResource;
    }

    /**
     * @param string $cartId
     * @param \Magento\Checkout\Api\Data\TotalsInformationInterface $addressInformation
     * @return string
     */
    public function save(
        string $cartId,
        \Magento\Checkout\Api\Data\TotalsInformationInterface $addressInformation
    ): string {
        /** @var $quoteIdMask \Magento\Quote\Model\QuoteIdMask */
        $quoteIdMask = $this->quoteIdMaskFactory->create();
        $this->quoteIdMaskResource->load($quoteIdMask, $cartId, 'masked_id');
        $this->totalsInformationManagement->save(
            (int) $quoteIdMask->getQuoteId(),
            $addressInformation
        );
        return $cartId;
    }
}
