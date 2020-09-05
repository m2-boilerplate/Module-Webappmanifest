<?php

namespace M2Boilerplate\WebAppManifest\Block\Adminhtml\Cache;

use Magento\Backend\Block\Cache\Additional as MagentoCacheAdditional;

class Additional extends MagentoCacheAdditional
{
    /**
     * Clean resized images url
     *
     * @return string
     */
    public function getCleanResizedImagesUrl()
    {
        return $this->getUrl('m2bp/webAppManifest/cleanResizedImages');
    }
}