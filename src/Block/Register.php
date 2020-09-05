<?php

namespace M2Boilerplate\WebAppManifest\Block;

use M2Boilerplate\WebAppManifest\Controller\Router;
use M2Boilerplate\WebAppManifest\Model\Config\Source\Displaytype;
use M2Boilerplate\WebAppManifest\Service\Image;
use Magento\Framework\View\Element\Context;
use Magento\Framework\View\Page\Config;

class Register extends \Magento\Framework\View\Element\AbstractBlock
{

    /**
     * @var \M2Boilerplate\WebAppManifest\Helper\Config $config
     */
    protected $config;

    /**
     * The template for the Web App Manifest registration HTML.
     *
     * @var string $template
     */
    protected $template;
    /**
     * @var Config
     */
    protected $pageConfig;
    /**
     * @var Image
     */
    protected $imageService;

    public function __construct(
        Image $imageService,
        Config $pageConfig,
        Context $context,
        \M2Boilerplate\WebAppManifest\Helper\Config $config,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->config = $config;
        $this->pageConfig = $pageConfig;
        $this->imageService = $imageService;
    }

    protected function _prepareLayout()
    {
        // add theme color
        if ($this->config->isEnabled()) {
            if ($title = $this->config->getShortName()) {
                $this->pageConfig->setMetadata('apple-mobile-web-app-title', $title);
            }

            $displayType = $this->config->getDisplayType();
            if (in_array($displayType, [Displaytype::FULL_SCREEN, Displaytype::STANDALONE])) {
                $this->pageConfig->setMetadata('mobile-web-app-capable', 'yes');
                $this->pageConfig->setMetadata('apple-touch-fullscreen', 'yes');
                $this->pageConfig->setMetadata('apple-mobile-web-app-capable', 'yes');
                $this->pageConfig->setMetadata('apple-mobile-web-app-status-bar-style', 'default');
                $this->generateSplashScreens();
            }

            if ($themeColor = $this->config->getThemeColor()) {
                $this->pageConfig->setMetadata('theme-color', $themeColor);
            }
            if ($icon = $this->config->getIcon()) {
                $url = $this->imageService->resize(180, 180);
                if ($url) {
                    $this->pageConfig->addRemotePageAsset($url, '', ['attributes' => ['rel' => 'apple-touch-icon', 'sizes' => '180x180']]);
                }
            }
            $manifestUrl = $this->_urlBuilder->getDirectUrl(Router::MANIFEST_ENDPOINT);
            $this->pageConfig->addRemotePageAsset($manifestUrl, '', ['attributes' => ['rel' => 'manifest']]);
        }

        return parent::_prepareLayout();
    }

    protected function generateSplashScreens()
    {
        $splashScreen = $this->imageService->resizeSplashScreen(1136, 640);
        $this->pageConfig->addRemotePageAsset($splashScreen, '', ['attributes' => [
            'rel' => 'apple-touch-startup-image',
            'media' => 'screen and (device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)'
        ]]);
        $splashScreen = $this->imageService->resizeSplashScreen(2436, 1125);
        $this->pageConfig->addRemotePageAsset($splashScreen, '', ['attributes' => [
            'rel' => 'apple-touch-startup-image',
            'media' => 'screen and (device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)'
        ]]);
        $splashScreen = $this->imageService->resizeSplashScreen(1792,828);
        $this->pageConfig->addRemotePageAsset($splashScreen, '', ['attributes' => [
            'rel' => 'apple-touch-startup-image',
            'media' => 'screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)'
        ]]);
        $splashScreen = $this->imageService->resizeSplashScreen(828,1792);
        $this->pageConfig->addRemotePageAsset($splashScreen, '', ['attributes' => [
            'rel' => 'apple-touch-startup-image',
            'media' => 'screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)'
        ]]);
        $splashScreen = $this->imageService->resizeSplashScreen(1334,750);
        $this->pageConfig->addRemotePageAsset($splashScreen, '', ['attributes' => [
            'rel' => 'apple-touch-startup-image',
            'media' => 'screen and (device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)'
        ]]);
        $splashScreen = $this->imageService->resizeSplashScreen(1242,2688);
        $this->pageConfig->addRemotePageAsset($splashScreen, '', ['attributes' => [
            'rel' => 'apple-touch-startup-image',
            'media' => 'screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)'
        ]]);
        $splashScreen = $this->imageService->resizeSplashScreen(2208, 1242);
        $this->pageConfig->addRemotePageAsset($splashScreen, '', ['attributes' => [
            'rel' => 'apple-touch-startup-image',
            'media' => 'screen and (device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)'
        ]]);
        $splashScreen = $this->imageService->resizeSplashScreen(1125, 2436);
        $this->pageConfig->addRemotePageAsset($splashScreen, '', ['attributes' => [
            'rel' => 'apple-touch-startup-image',
            'media' => 'screen and (device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)'
        ]]);
        $splashScreen = $this->imageService->resizeSplashScreen(1242,2208);
        $this->pageConfig->addRemotePageAsset($splashScreen, '', ['attributes' => [
            'rel' => 'apple-touch-startup-image',
            'media' => 'screen and (device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)'
        ]]);
        $splashScreen = $this->imageService->resizeSplashScreen(2732,2048);
        $this->pageConfig->addRemotePageAsset($splashScreen, '', ['attributes' => [
            'rel' => 'apple-touch-startup-image',
            'media' => 'screen and (device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)'
        ]]);
        $splashScreen = $this->imageService->resizeSplashScreen(2688,1242);
        $this->pageConfig->addRemotePageAsset($splashScreen, '', ['attributes' => [
            'rel' => 'apple-touch-startup-image',
            'media' => 'screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)'
        ]]);
        $splashScreen = $this->imageService->resizeSplashScreen(2224,1668);
        $this->pageConfig->addRemotePageAsset($splashScreen, '', ['attributes' => [
            'rel' => 'apple-touch-startup-image',
            'media' => 'screen and (device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)'
        ]]);
        $splashScreen = $this->imageService->resizeSplashScreen(750,1334);
        $this->pageConfig->addRemotePageAsset($splashScreen, '', ['attributes' => [
            'rel' => 'apple-touch-startup-image',
            'media' => 'screen and (device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)'
        ]]);
        $splashScreen = $this->imageService->resizeSplashScreen(2048,2732);
        $this->pageConfig->addRemotePageAsset($splashScreen, '', ['attributes' => [
            'rel' => 'apple-touch-startup-image',
            'media' => 'screen and (device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)'
        ]]);
        $splashScreen = $this->imageService->resizeSplashScreen(2388,1668);
        $this->pageConfig->addRemotePageAsset($splashScreen, '', ['attributes' => [
            'rel' => 'apple-touch-startup-image',
            'media' => 'screen and (device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)'
        ]]);
        $splashScreen = $this->imageService->resizeSplashScreen(1668,2224);
        $this->pageConfig->addRemotePageAsset($splashScreen, '', ['attributes' => [
            'rel' => 'apple-touch-startup-image',
            'media' => 'screen and (device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)'
        ]]);
        $splashScreen = $this->imageService->resizeSplashScreen(640,1136);
        $this->pageConfig->addRemotePageAsset($splashScreen, '', ['attributes' => [
            'rel' => 'apple-touch-startup-image',
            'media' => 'screen and (device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)'
        ]]);
        $splashScreen = $this->imageService->resizeSplashScreen(1668,2388);
        $this->pageConfig->addRemotePageAsset($splashScreen, '', ['attributes' => [
            'rel' => 'apple-touch-startup-image',
            'media' => 'screen and (device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)'
        ]]);
        $splashScreen = $this->imageService->resizeSplashScreen(2048,1536);
        $this->pageConfig->addRemotePageAsset($splashScreen, '', ['attributes' => [
            'rel' => 'apple-touch-startup-image',
            'media' => 'screen and (device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)'
        ]]);
        $splashScreen = $this->imageService->resizeSplashScreen(1536,2048);
        $this->pageConfig->addRemotePageAsset($splashScreen, '', ['attributes' => [
            'rel' => 'apple-touch-startup-image',
            'media' => 'screen and (device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)'
        ]]);
    }

}
