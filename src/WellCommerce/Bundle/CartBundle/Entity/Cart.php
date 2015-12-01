<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */
namespace WellCommerce\Bundle\AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\AppBundle\Entity\ClientAwareTrait;
use WellCommerce\Bundle\AppBundle\Entity\ClientBillingAddressInterface;
use WellCommerce\Bundle\AppBundle\Entity\ClientContactDetailsInterface;
use WellCommerce\Bundle\AppBundle\Entity\ClientShippingAddressInterface;
use WellCommerce\Bundle\ShopBundle\Entity\ShopAwareTrait;
use WellCommerce\Bundle\AppBundle\Doctrine\ORM\Behaviours\Timestampable\TimestampableTrait;
use WellCommerce\Bundle\AppBundle\Entity\CouponAwareTrait;
use WellCommerce\Bundle\AppBundle\Service\Cart\Visitor\CartVisitorInterface;

/**
 * Class Cart
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Cart implements CartInterface
{
    use TimestampableTrait;
    use ShopAwareTrait;
    use PaymentMethodAwareTrait;
    use ClientAwareTrait;
    use CouponAwareTrait;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var Collection
     */
    protected $products;

    /**
     * @var string
     */
    protected $sessionId;

    /**
     * @var bool
     */
    protected $copyAddress;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var CartTotals
     */
    protected $totals;

    /**
     * @var ClientContactDetailsInterface
     */
    protected $contactDetails;

    /**
     * @var ClientBillingAddressInterface
     */
    protected $billingAddress;

    /**
     * @var ClientShippingAddressInterface
     */
    protected $shippingAddress;

    /**
     * @var ShippingMethodCostInterface
     */
    protected $shippingMethodCost;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * {@inheritdoc}
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
    }

    /**
     * {@inheritdoc}
     */
    public function getCopyAddress()
    {
        return $this->copyAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function setCopyAddress($copyAddress)
    {
        $this->copyAddress = $copyAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function addProduct(CartProductInterface $cartProduct)
    {
        $this->products->add($cartProduct);
    }

    /**
     * {@inheritdoc}
     */
    public function removeProduct(CartProductInterface $cartProduct)
    {
        $this->products->removeElement($cartProduct);
    }

    /**
     * {@inheritdoc}
     */
    public function getTotals()
    {
        return $this->totals;
    }

    /**
     * {@inheritdoc}
     */
    public function setTotals(CartTotalsInterface $cartTotals)
    {
        $this->totals = $cartTotals;
    }

    /**
     * {@inheritdoc}
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * {@inheritdoc}
     */
    public function setProducts(Collection $products)
    {
        $this->products = $products;
    }

    /**
     * {@inheritdoc}
     */
    public function getContactDetails()
    {
        return $this->contactDetails;
    }

    /**
     * {@inheritdoc}
     */
    public function setContactDetails(ClientContactDetailsInterface $contactDetails)
    {
        $this->contactDetails = $contactDetails;
    }

    /**
     * {@inheritdoc}
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function setBillingAddress(ClientBillingAddressInterface $billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function setShippingAddress(ClientShippingAddressInterface $shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function acceptVisitor(CartVisitorInterface $visitor)
    {
        $visitor->visitCart($this);
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingMethodCost()
    {
        return $this->shippingMethodCost;
    }

    /**
     * {@inheritdoc}
     */
    public function setShippingMethodCost(ShippingMethodCostInterface $shippingMethodCost = null)
    {
        $this->shippingMethodCost = $shippingMethodCost;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingCostQuantity()
    {
        return $this->totals->getQuantity();
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingCostWeight()
    {
        return $this->totals->getWeight();
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingCostGrossPrice()
    {
        return $this->totals->getGrossPrice();
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingCostCurrency()
    {
        return $this->getCurrency();
    }

    /**
     * {@inheritdoc}
     */
    public function hasMethods()
    {
        return (bool)($this->getShippingMethodCost() instanceof ShippingMethodCostInterface
            && $this->getPaymentMethod() instanceof PaymentMethodInterface);
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingCost()
    {
        if (null !== $this->getShippingMethodCost()) {
            return $this->getShippingMethodCost()->getCost();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty()
    {
        return 0 === $this->products->count();
    }
}
