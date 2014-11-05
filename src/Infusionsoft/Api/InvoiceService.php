<?php

namespace Infusionsoft\Api;

class InvoiceService extends AbstractApi {

	/**
	 * @param integer $contactId
	 * @param string $description
	 * @param string $orderDate
	 * @param integer $leadAffiliateId
	 * @param integer $saleAffiliateId
	 * @return mixed
	 */
	public function createBlankOrder($contactId, $description, $orderDate, $leadAffiliateId, $saleAffiliateId)
	{
		return $this->client->request('InvoiceService.createBlankOrder', $contactId, $description, $orderDate, $leadAffiliateId, $saleAffiliateId);
	}

	/**
	 * @param integer $invoiceId
	 * @param integer $productId
	 * @param integer $type
	 * @param float $price
	 * @param integer $quantity
	 * @param string $description
	 * @param string $notes
	 * @return mixed
	 */
	public function addOrderItem($invoiceId, $productId, $type, $price, $quantity, $description, $notes)
	{
		return $this->client->request('InvoiceService.addOrderItem', $invoiceId, $productId, $type, $price, $quantity, $description, $notes);
	}

	/**
	 * @param integer $invoiceId
	 * @param string $notes
	 * @param integer $creditCardId
	 * @param integer $merchantAccountId
	 * @param boolean $bypassCommissions
	 * @return mixed
	 */
	public function chargeInvoice($invoiceId, $notes, $creditCardId, $merchantAccountId, $bypassCommissions)
	{
		return $this->client->request('InvoiceService.chargeInvoice', $invoiceId, $notes, $creditCardId, $merchantAccountId, $bypassCommissions);
	}

	/**
	 * @param integer $recurringOrderId
	 * @return mixed
	 */
	public function deleteSubscription($recurringOrderId)
	{
		return $this->client->request('InvoiceService.deleteSubscription', $recurringOrderId);
	}

	/**
	 * @param integer $invoiceId
	 * @return mixed
	 */
	public function deleteInvoice($invoiceId)
	{
		return $this->client->request('InvoiceService.deleteInvoice', $invoiceId);
	}

	/**
	 * @param integer $contactId
	 * @param boolean $allowDuplicate
	 * @param integer $cProgramId
	 * @param integer $qty
	 * @param float $price
	 * @param boolean $taxable
	 * @param integer $merchantAccountId
	 * @param integer $creditCardId
	 * @param integer $affiliated
	 * @param integer $daysTillCharge
	 * @return mixed
	 */
	public function addRecurringOrder($contactId, $allowDuplicate, $cProgramId, $qty, $price, $taxable, $merchantAccountId, $creditCardId, $affiliated, $daysTillCharge)
	{
		return $this->client->request('InvoiceService.addRecurringOrder', $contactId, $allowDuplicate, $cProgramId, $qty, $price, $taxable, $merchantAccountId, $creditCardId, $affiliated, $daysTillCharge);
	}

	/**
	 * @param integer $recurringOrderId
	 * @param integer $affiliateId
	 * @param float $amount
	 * @param integer $payoutType
	 * @param string $description
	 * @return mixed
	 */
	public function addRecurringCommissionOverride($recurringOrderId, $affiliateId, $amount, $payoutType, $description)
	{
		return $this->client->request('InvoiceService.addRecurringCommissionOverride', $recurringOrderId, $affiliateId, $amount, $payoutType, $description);
	}

	/**
	 * @param integer $recurringOrderId
	 * @return mixed
	 */
	public function createInvoiceForRecurring($recurringOrderId)
	{
		return $this->client->request('InvoiceService.createInvoiceForRecurring', $recurringOrderId);
	}

	/**
	 * @param integer $invoiceId
	 * @param float $amt
	 * @param string $paymentDate
	 * @param string $paymentType
	 * @param string $paymentDescription
	 * @param boolean $bypassCommissions
	 * @return mixed
	 */
	public function addManualPayment($invoiceId, $amt, $paymentDate, $paymentType, $paymentDescription, $bypassCommissions)
	{
		return $this->client->request('InvoiceService.addManualPayment', $invoiceId, $amt, $paymentDate, $paymentType, $paymentDescription, $bypassCommissions);
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
	 * @param integer $numPayments
	 * @param integer $daysBetweenPayments
	 * @return mixed
	 */
	public function addPaymentPlan($invoiceId, $autoCharge, $creditCardId, $merchantAccountId, $daysBetweenRetry, $maxRetry, $initialPmtAmt, $initialPmtDate, $plantStartDate, $numPayments, $daysBetweenPayments)
	{
		return $this->client->request('InvoiceService.addPaymentPlan', $invoiceId, $autoCharge, $creditCardId, $merchantAccountId, $daysBetweenRetry, $maxRetry, $initialPmtAmt, $initialPmtDate, $plantStartDate, $numPayments, $daysBetweenPayments);
	}

	/**
	 * @param integer $invoiceId
	 * @return mixed
	 */
	public function calculateAmountOwed($invoiceId)
	{
		return $this->client->request('InvoiceService.calculateAmountOwed', $invoiceId);
	}

	/**
	 * @return mixed
	 */
	public function getAllPaymentOptions()
	{
		return $this->client->request('InvoiceService.getAllPaymentOptions');
	}

	/**
	 * @param integer $invoiceId
	 * @return mixed
	 */
	public function getPayments($invoiceId)
	{
		return $this->client->request('InvoiceService.getPayments', $invoiceId);
	}

	/**
	 * @param integer $contactId
	 * @param string $last4
	 * @return mixed
	 */
	public function locateExistingCard($contactId, $last4)
	{
		return $this->client->request('InvoiceService.locateExistingCard', $contactId, $last4);
	}

	/**
	 * @param integer $invoiceId
	 * @return mixed
	 */
	public function recalculateTax($invoiceId)
	{
		return $this->client->request('InvoiceService.recalculateTax', $invoiceId);
	}

	/**
	 * @param string $cardType
	 * @param integer $contactId
	 * @param string $cardNumber
	 * @param string $expirationMonth
	 * @param string $expirationYear
	 * @param string $cvv2
	 * @return array
	 */
	public function validateCreditCard($cardType, $contactId, $cardNumber, $expirationMonth, $expirationYear, $cvv2)
	{
		$data = array(
			'CardType' => $cardType,
			'ContactId' => $contactId,
			'CardNumber' => $cardNumber,
			'ExpirationMonth' => $expirationMonth,
			'ExpirationYear' => $expirationYear,
			'CVV2' => $cvv2
		);

		return $this->client->request('InvoiceService.validateCreditCard', $data);
	}

	/**
	 * @return mixed
	 */
	public function getAllShippingOptions()
	{
		return $this->client->request('InvoiceService.getAllShippingOptions');
	}

	/**
	 * @param integer $recurringOrderId
	 * @param string $nextBillDate
	 * @return mixed
	 */
	public function updateJobRecurringNextBillDate($recurringOrderId, $nextBillDate)
	{
		return $this->client->request('InvoiceService.updateJobRecurringNextBillDate', $recurringOrderId, $nextBillDate);
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
	 * @return mixed
	 */
	public function addOrderCommissionOverride($invoiceId, $affiliateId, $productId, $percentage, $amount, $payoutType, $description, $date)
	{
		return $this->client->request('InvoiceService.addOrderCommissionOverride', $invoiceId, $affiliateId, $productId, $percentage, $amount, $payoutType, $description, $date);
	}

}