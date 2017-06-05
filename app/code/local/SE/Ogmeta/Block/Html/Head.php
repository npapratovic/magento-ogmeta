<?php
/**
 * Class StackExchange_Ogmeta_Block_Html_Head
 */
class SE_Ogmeta_Block_Html_Head extends Mage_Page_Block_Html_Head
{
    public function _construct()
    {
        $this->setTemplate('se_og_meta/meta.phtml');
    }

    protected function _prepareLayout()
    {
        try {
            $baseUrl          = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);
            $storeId          = $this->helper('core')->getStoreId();
            $coreStringHelper = Mage::helper('core/string');

            if ($currentProduct = Mage::registry('current_product')) {
                $title              = $currentProduct->getMetaTitle();
                $description        = $currentProduct->getMetaDescription();
                $productName        = $currentProduct->getName();
                $amount             = $currentProduct->getFinalPrice();
                $productDescription = $currentProduct->getDescription();
                $productImages      = $currentProduct->getMediaGalleryImages();
                $currency           = Mage::app()->getStore()->getCurrentCurrencyCode();

                if ($title) {
                    $this->setOgTitle($title);
                } else {
                    $this->setOgTitle($coreStringHelper->substr($productName, 0, 255));
                }

                if ($description) {
                    $this->setOgDescription($description);
                } else {
                    $this->setOgDescription(
                        $coreStringHelper->substr(
                            $coreStringHelper->stripTags($productDescription), 0, 255
                        )
                    );
                }

                foreach ($productImages->getItems() as $image) {
                    $images[] = $baseUrl . 'catalog/product' . $image->getFile();
                }

                if ($images) {
                    $this->setImages($images);
                }

                if ($amount) {
                    $this->setOgAmount($amount);
                }

                if ($currency) {
                    $this->setOgCurrency($currency);
                }
            } elseif ($currentCategory = Mage::registry('current_category')) {
                $title                   = $currentCategory->getMetaTitle();
                $categoryName            = $currentCategory->getName();
                $categoryMetaDescription = $currentCategory->getMetaDescription();
                $categoryDescription     = $currentCategory->getDescription();
                $categoryThumbnail       = $currentCategory->getThumbnail();

                if ($title) {
                    $this->setOgTitle($title);
                } else {
                    $this->setOgTitle($coreStringHelper->substr($categoryName, 0, 255));
                }

                if ($categoryMetaDescription) {
                    $this->setOgDescription($categoryMetaDescription);
                } else {
                    $this->setOgDescription($coreStringHelper->substr($coreStringHelper->stripTags($categoryDescription)), 0, 255);
                }

                if ($categoryThumbnail) {
                    $this->setImages([$baseUrl . 'catalog/category/' . $categoryThumbnail]);
                }
            }

            $this->setCurrentUrl($this->helper('core/url')->getCurrentUrl());

            $title = $this->getOgTitle();

            if (!$title) {
                $this->setOgTitle(Mage::getStoreConfig('design/og_meta_head/og_default_title', $storeId));
            }

            $description = $this->getOgDescription();

            if (!$description) {
                $this->setOgDescription(Mage::getStoreConfig('design/og_meta_head/og_default_description', $storeId));
            }

            $images = $this->getImages();

            if (!$images) {
                $this->setImages([$baseUrl . 'ogmeta/' . Mage::getStoreConfig('design/og_meta_head/og_default_image', $storeId)]);
            }
        } catch (Exception $e) {
            Mage::log($e->getMessage());
        }
    }
}