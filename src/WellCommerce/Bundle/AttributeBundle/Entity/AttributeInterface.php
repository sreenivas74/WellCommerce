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
use WellCommerce\Bundle\AppBundle\Entity\Attribute\GroupInterface;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;

/**
 * Interface AttributeInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AttributeInterface extends TimestampableInterface, TranslatableInterface, BlameableInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return GroupInterface
     */
    public function getAttributeGroup();

    /**
     * @param GroupInterface $attributeGroup
     */
    public function setAttributeGroup(GroupInterface $attributeGroup);

    /**
     * @return Collection
     */
    public function getValues();

    /**
     * @param Collection $collection
     */
    public function setValues(Collection $collection);
}
