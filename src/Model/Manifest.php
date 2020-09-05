<?php

namespace M2Boilerplate\WebAppManifest\Model;

use M2Boilerplate\WebAppManifest\Service\Image;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\ScopeInterface;

class Manifest implements \M2Boilerplate\WebAppManifest\Api\Data\ManifestInterface
{

    const XML_PATH_STORE_INFO_SHORT_NAME = 'web/webappmanifest/short_store_name';
    const XML_PATH_STORE_INFO_NAME = 'web/webappmanifest/store_name';
    const XML_PATH_STORE_INFO_DESCRIPTION = 'web/webappmanifest/description';
    const XML_PATH_STORE_INFO_START_URL = 'web/webappmanifest/start_url';
    const XML_PATH_DISPLAY_THEME_COLOR = 'web/webappmanifest/theme_color';
    const XML_PATH_DISPLAY_BACKGROUND_COLOR = 'web/webappmanifest/background_color';
    const XML_PATH_DISPLAY_DISPLAY_TYPE = 'web/webappmanifest/display_type';
    const XML_PATH_DISPLAY_ORIENTATION = 'web/webappmanifest/orientation';
    const XML_PATH_ICONS_ICON = 'web/webappmanifest/icon';
    const XML_PATH_ICONS_SIZES = 'web/webappmanifest/icon_sizes';

    /**
     * @var ScopeConfigInterface $scopeConfig
     */
    protected $scopeConfig;

    /**
     * @var UrlInterface $urlBuilder
     */
    protected $urlBuilder;

    /** @var array $data */
    protected $data;

    /**
     * @var Image
     */
    protected $imageService;

    public function __construct(
        Image $imageService,
        ScopeConfigInterface $scopeConfig,
        UrlInterface $urlBuilder
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->urlBuilder = $urlBuilder;
        $this->imageService = $imageService;
        $this->data = [];

        $this->populate();
    }

    /**
     * @inheritdoc
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Populate the Manifest data from configuration.
     *
     * @return $this
     */
    public function populate()
    {
        $this->populateStoreInformation();
        $this->populateDisplayOptions();
        $this->populateIcons();

        return $this;
    }

    /**
     * Populate the manifest with store information.
     *
     * @return $this
     */
    protected function populateStoreInformation()
    {
        $this->populateFromConfig('short_name', static::XML_PATH_STORE_INFO_SHORT_NAME);
        $this->populateFromConfig('name', static::XML_PATH_STORE_INFO_NAME);
        $this->populateFromConfig('description', static::XML_PATH_STORE_INFO_DESCRIPTION, true);

        if ($path = $this->scopeConfig->getValue(static::XML_PATH_STORE_INFO_START_URL, ScopeInterface::SCOPE_STORE)) {
            $start_url = $this->urlBuilder->getDirectUrl($path);
        } else {
            $start_url = $this->urlBuilder->getBaseUrl();
        }
        $this->data['start_url'] = $start_url;

        return $this;
    }

    /**
     * Populate the manifest with display settings.
     *
     * @return $this
     */
    protected function populateDisplayOptions()
    {
        $this->populateFromConfig('theme_color', static::XML_PATH_DISPLAY_THEME_COLOR, true);
        $this->populateFromConfig('background_color', static::XML_PATH_DISPLAY_BACKGROUND_COLOR, true);
        $this->populateFromConfig('display', static::XML_PATH_DISPLAY_DISPLAY_TYPE);
        $this->populateFromConfig('orientation', static::XML_PATH_DISPLAY_ORIENTATION);

        return $this;
    }

    /**
     * Populate the manifest with app icon definitions.
     *
     * @return $this
     */
    protected function populateIcons()
    {
        $icon = $this->scopeConfig->getValue(static::XML_PATH_ICONS_ICON, ScopeInterface::SCOPE_STORE);
        if (!$icon) {
            return $this;
        }

        $this->data['icons'] = [];
        $sizes = $this->scopeConfig->getValue(static::XML_PATH_ICONS_SIZES, ScopeInterface::SCOPE_STORE);
        $sizes = explode(' ', $sizes);
        $sizes = array_map('trim', $sizes);
        $sizes = array_filter($sizes);
        foreach ($sizes as $size) {
            $withAndHeight = explode('x', $size);
            if (count($withAndHeight) !== 2) {
                continue;
            }
            list($with, $height) = $withAndHeight;
            $url = $this->imageService->resize((int) $with, (int) $height);
            if (!$url) {
                continue;
            }
            $this->data['icons'][] = ['src' => $url, 'sizes' => $size, 'purpose' => 'any maskable'];
        }

        return $this;
    }

    /**
     * Populate a manifest value from System Configration.
     *
     * @param      $key
     * @param      $config_path
     * @param bool $if_exists Only populate the value if it's not empty (default: false)
     *
     * @return $this
     */
    protected function populateFromConfig($key, $config_path, $if_exists = false)
    {
        $value = $this->scopeConfig->getValue($config_path, ScopeInterface::SCOPE_STORE);

        if (!$if_exists || !empty($value)) {
            $this->data[$key] = $value;
        }

        return $this;
    }
}
