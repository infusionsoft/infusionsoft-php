<?php

namespace Infusionsoft\Api;

class InvoiceService extends AbstractApi {

	/**
	 * @param integer $contactId
	 * @param string $description
	 * @param string $orderDate
	 * @param integer $leadAffiliateId
	 * @param integer $saleAffiliateId
	 * @return {{return}}
	 */
	public function createBlankOrder($contactId, $description, $orderDate, $leadAffiliateId, $saleAffiliateId)
	{
		return $this->client->request($this->method(), $contactId, $description, $orderDate, $leadAffiliateId, $saleAffiliateId);
	}

	/**
	 * @param integer $invoiceId
	 * @param integer $productId
	 * @param integer $type
	 * @param float $price
	 * @param integer $quantity
	 * @param string $description
	 * @param string $notes
	 * @return {{return}}
	 */
	public function addOrderItem($invoiceId, $productId, $type, $price, $quantity, $description, $notes)
	{
		return $this->client->request($this->method(), $invoiceId, $productId, $type, $price, $quantity, $description, $notes);
	}

	/**
	 * @param integer $invoiceId
	 * @param string $notes
	 * @param integer $creditCardId
	 * @param integer $merchantAccountId
	 * @param boolean $bypassCommissions
	 * @return {{return}}
	 */
	public function chargeInvoice($invoiceId, $notes, $creditCardId, $merchantAccountId, $bypassCommissions)
	{
		return $this->client->request($this->method(), $invoiceId, $notes, $creditCardId, $merchantAccountId, $bypassCommissions);
	}

	/**
	 * @param integer $recurringOrderId
	 * @return {{return}}
	 */
	public function deleteSubscription($recurringOrderId)
	{
		return $this->client->request($this->method(), $recurringOrderId);
	}

	/**
	 * @param integer $invoiceId
	 * @return {{return}}
	 */
	public function deleteInvoice($invoiceId)
	{
		return $this->client->request($this->method(), $invoiceId);
	}

	/**
	 * @param integer $contactId
	 * @param boolean $allowDuplicate
	 * @param integer $cProgramId
	 * @param integer $qty
	 * @param float $price
	 * @param boolean $taxable
	 * @param integer $merchabtAccountId
	 * @param integer $creditCardId
	 * @param integer $affiliated
	 * @param integer $daysTillCharge
	 * @return {{return}}
	 */
	public function addRecurringOrder($contactId, $allowDuplicate, $cProgramId, $qty, $price, $taxable, $merchabtAccountId, $creditCardId, $affiliated, $daysTillCharge)
	{
		return $this->client->request($this->method(), $contactId, $allowDuplicate, $cProgramId, $qty, $price, $taxable, $merchabtAccountId, $creditCardId, $affiliated, $daysTillCharge);
	}

	/**
	 * @param integer $recurringOrderId
	 * @param integer $affiliateId
	 * @param float $amount
	 * @param integer $payoutType
	 * @param string $description
	 * @return {{return}}
	 */
	public function addRecurringCommissionOverride($recurringOrderId, $affiliateId, $amount, $payoutType, $description)
	{
		return $this->client->request($this->method(), $recurringOrderId, $affiliateId, $amount, $payoutType, $description);
	}

	/**
	 * @param integer $recurringOrderId
	 * @return {{return}}
	 */
	public function createInvoiceForRecurring($recurringOrderId)
	{
		return $this->client->request($this->method(), $recurringOrderId);
	}

	/**
	 * @param integer $invoiceId
	 * @param float $amt
	 * @param string $paymentDate
	 * @param string $paymentType
	 * @param string $paymentDescription
	 * @param boolean $bypassCommissions
	 * @return {{return}}
	 */
	public function addManualPayment($invoiceId, $amt, $paymentDate, $paymentType, $paymentDescription, $bypassCommissions)
	{
		return $this->client->request($this->method(), $invoiceId, $amt, $paymentDate, $paymentType, $paymentDescription, $bypassCommissions);
	}

	/**
	 * @param integer $invoiceId
	 * @param boolean $autoCharge
	 * @param integer $creditCardId
	 * @param integer $merchantAccountId
	 * @param integer $daysBetweenRetry
	 * @param integer $maxRetry
	 * @param float $initialPmtAmt
	 * @param string $initialPmtDate
	 * @param string $plantStartDate
	 * @param integer $numPmts
	 * @param integer $daysBetweenPmts
	 * @return {{return}}
	 */
	public function addPaymentPlan($invoiceId, $autoCharge, $creditCardId, $merchantAccountId, $daysBetweenRetry, $maxRetry, $initialPmtAmt, $initialPmtDate, $plantStartDate, $numPmts, $daysBetweenPmts)
	{
		return $this->client->request($this->method(), $invoiceId, $autoCharge, $creditCardId, $merchantAccountId, $daysBetweenRetry, $maxRetry, $initialPmtAmt, $initialPmtDate, $plantStartDate, $numPmts, $daysBetweenPmts);
	}

	/**
	 * @param integer $invoiceId
	 * @return {{return}}
	 */
	public function calculateAmountOwed($invoiceId)
	{
		return $this->client->request($this->method(), $invoiceId);
	}

	/**
	 * @return {{return}}
	 */
	public function getAllPaymentOptions()
	{
		return $this->client->request($this->method());
	}

	/**
	 * @param integer $invoiceId
	 * @return {{return}}
	 */
	public function getPayments($invoiceId)
	{
		return $this->client->request($this->method(), $invoiceId);
	}

	/**
	 * @param integer $contactId
	 * @param string $last4
	 * @return {{return}}
	 */
	public function locateExistingCard($contactId, $last4)
	{
		return $this->client->request($this->method(), $contactId, $last4);
	}

	/**
	 * @param integer $invoiceId
	 * @return {{return}}
	 */
	public function recalculateTax($invoiceId)
	{
		return $this->client->request($this->method(), $invoiceId);
	}

	/**
	 * @param string $CardType
	 * @param integer $contactId
	 * @param string $CardNumber
	 * @param string $ExpirationMonth
	 * @param string $ExpirationYear
	 * @param string $CVV2
	 * @return {{return}}
	 */
	public function validateCreditCard($CardType, $contactId, $CardNumber, $ExpirationMonth, $ExpirationYear, $CVV2)
	{
		return $this->client->request($this->method(), $CardType, $contactId, $CardNumber, $ExpirationMonth, $ExpirationYear, $CVV2);
	}

	/**
	 * @return {{return}}
	 */
	public function getAllShippingOptions()
	{
		return $this->client->request($this->method());
	}

	/**
	 * @param integer $recurringOrderId
	 * @param string $nextBillDate
	 * @return {{return}}
	 */
	public function updateJobRecurringNextBillDate($recurringOrderId, $nextBillDate)
	{
		return $this->client->request($this->method(), $recurringOrderId, $nextBillDate);
	}

	/**
	 * @param integer $invoiceId
	 * @param integer $affiliateId
	 * @param integer $productId
	 * @param integer $percentage
	 * @param float $amount
	 * @param integer $payoutType
	 * @param string $description
	 * @param string $date
	 * @return {{return}}
	 */
	public function addOrderCommissionOverride($invoiceId, $affiliateId, $productId, $percentage, $amount, $payoutType, $description, $date)
	{
		return $this->client->request($this->method(), $invoiceId, $affiliateId, $productId, $percentage, $amount, $payoutType, $description, $date);
	}

}