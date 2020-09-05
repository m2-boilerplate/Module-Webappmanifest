<?php

namespace M2Boilerplate\WebAppManifest\Service;


use M2Boilerplate\WebAppManifest\Helper\Config;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

class Image
{
    const CACHE_DIRECTORY = 'webappmanifest/icons/_cache';

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var AdapterFactory
     */
    protected $imageFactory;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var UrlInterface
     */
    protected $url;

    public function __construct(
        UrlInterface $url,
        Config $config,
        Filesystem $filesystem,
        AdapterFactory $imageFactory
    ) {
        $this->filesystem = $filesystem;
        $this->imageFactory = $imageFactory;
        $this->config = $config;
        $this->url = $url;
    }

    public function resize(int $width, int $height): ?string
    {
        $image = $this->config->getIcon();
        if (!$image) {
            return null;
        }
        $directory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
        $path = 'webappmanifest/icons/'.$image;

        if (!$directory->isFile($path)) {
            return null;
        }
        $absolutePath = $directory->getAbsolutePath($path);

        $resizedImage = sprintf('%s/%sx%s/%s', self::CACHE_DIRECTORY, $width, $height, $image);

        if (!$directory->isFile($resizedImage) || !$directory->isReadable($resizedImage)) {
            try {
                // Only resize image if not already exists.
                $imageResize = $this->imageFactory->create();
                $imageResize->open($absolutePath);
                $imageResize->constrainOnly(false);
                $imageResize->keepTransparency(true);
                $imageResize->keepFrame(false);
                $imageResize->keepAspectRatio(true);
                $imageResize->resize($width, $height);
                //destination folder
                //save image
                $imageResize->save($directory->getAbsolutePath($resizedImage));
            }
            catch (\Exception $e) {
                return null;
            }
        }
        return $this->url->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]).$resizedImage;
    }

    public function resizeSplashScreen(int $width, int $height)
    {
        $url = $this->resize(round($height*0.2), round($height*0.2));
        if (!$url) {
            return null;
        }
        $baseUrl = $this->url->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]);
        $logoPath = str_replace($baseUrl,'', $url);
        $image = $this->config->getIcon();

        $directory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
        $absolutePath = $directory->getAbsolutePath($logoPath);
        $resizedImage = sprintf('%s/splash_%sx%s/%s', self::CACHE_DIRECTORY, $width, $height, $image);
        if (!$directory->isFile($resizedImage) || !$directory->isReadable($resizedImage)) {
            try {
                // Only resize image if not already exists.
                $imageResize = $this->imageFactory->create();
                $imageResize->open($absolutePath);
                $imageResize->constrainOnly(true);
                $imageResize->keepTransparency(false);
                $imageResize->keepFrame(true);
                $imageResize->keepAspectRatio(true);
                $backgroundColor = $this->config->getBackgroundColor();
                if ($backgroundColor && strpos($backgroundColor, '#') === 0) {
                    $backgroundColor = substr($backgroundColor, 1);
                    $r = null;
                    $g = null;
                    $b = null;
                    if ( strlen( $backgroundColor ) == 6 ) {
                        list($r, $g, $b ) = [$backgroundColor[0] . $backgroundColor[1], $backgroundColor[2] . $backgroundColor[3], $backgroundColor[4] . $backgroundColor[5]];
                    } elseif ( strlen( $backgroundColor ) == 3 ) {
                        list($r, $g, $b ) = [$backgroundColor[0] . $backgroundColor[0], $backgroundColor[1] . $backgroundColor[1], $backgroundColor[2] . $backgroundColor[2]];
                    }

                    if ($r && $g && $b) {
                        $r = hexdec( $r );
                        $g = hexdec( $g );
                        $b = hexdec( $b );
                        $imageResize->backgroundColor([$r, $g, $b]);
                    }
                }


                $imageResize->resize($width, $height);
                //destination folder
                //save image
                $imageResize->save($directory->getAbsolutePath($resizedImage));
            }
            catch (\Exception $e) {
                return null;
            }
        }
        return $this->url->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]).$resizedImage;
    }
}