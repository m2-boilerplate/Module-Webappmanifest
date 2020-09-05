<?php

namespace M2Boilerplate\WebAppManifest\Helper;

use Magento\Store\Model\ScopeInterface;

class Config extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_ENABLE = "web/webappmanifest/enable";

    const XML_PATH_THEME_COLOR = 'web/webappmanifest/theme_color';

    const XML_PATH_BACKGROUND_COLOR = 'web/webappmanifest/background_color';

    const XML_PATH_ICON = 'web/webappmanifest/icon';

    const XML_PATH_SHORT_NAME = 'web/webappmanifest/short_store_name';

    const XML_PATH_DISPLAY_TYPE = 'web/webappmanifest/display_type';



    /**
     * Check if Web App Manifest is enabled.
     *
     * @param null|string $scope
     *
     * @return bool
     */
    public function isEnabled($scope = null): bool
    {
        return $this->scopeConfig->isSetFlag(static::XML_PATH_ENABLE, ScopeInterface::SCOPE_STORE, $scope);
    }

    public function getThemeColor($scope = null): ?string
    {
        return $this->scopeConfig->getValue(static::XML_PATH_THEME_COLOR, ScopeInterface::SCOPE_STORE, $scope);
    }

    public function getBackgroundColor($scope = null): ?string
    {
        return $this->scopeConfig->getValue(static::XML_PATH_BACKGROUND_COLOR, ScopeInterface::SCOPE_STORE, $scope);
    }

    public function getIcon($scope = null)
    {
        return $this->scopeConfig->getValue(static::XML_PATH_ICON, ScopeInterface::SCOPE_STORE, $scope);
    }

    public function getShortName($scope = null)
    {
        return $this->scopeConfig->getValue(static::XML_PATH_SHORT_NAME, ScopeInterface::SCOPE_STORE, $scope);
    }

    public function getDisplayType($scope = null)
    {
        return $this->scopeConfig->getValue(static::XML_PATH_DISPLAY_TYPE, ScopeInterface::SCOPE_STORE, $scope);
    }
}
