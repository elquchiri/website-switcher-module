<?php
/*
 * MIT License
 *
 * Copyright (c) 2022 Mohamed EL QUCHIRI
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace ElQuchiri\WebsiteSwitcher\Block;


use Magento\Framework\View\Element\Template;

class Website extends Template
{

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var \Magento\Store\Api\StoreWebsiteRelationInterface
     */
    private $storeWebsiteRelation;

    public function __construct(
        Template\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Store\Api\StoreWebsiteRelationInterface $storeWebsiteRelation,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->storeManager = $storeManager;
        $this->storeWebsiteRelation = $storeWebsiteRelation;
    }

    public function getWebsites()
    {
        return $this->storeManager->getWebsites();
    }

    public function getCurrentWebsiteId()
    {
        try {
            return $this->_storeManager->getStore()->getWebsiteId();
        }catch(\Magento\Framework\Exception\NoSuchEntityException $e) {
            return null;
        }
    }

    public function getCurrentWebsiteName()
    {
        try {
            return $this->_storeManager->getWebsite(self::getCurrentWebsiteId())->getName();
        }catch(\Magento\Framework\Exception\NoSuchEntityException $e) {
            return null;
        }
    }

    public function getWebsiteUrl($websiteId)
    {
        $storeId = $this->storeWebsiteRelation->getStoreByWebsiteId($websiteId);
        return $this->storeManager->getStore($storeId[0])->getBaseUrl();
    }
}
