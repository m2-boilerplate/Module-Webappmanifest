<?php

namespace M2Boilerplate\WebAppManifest\Controller\Adminhtml\WebAppManifest;

use M2Boilerplate\WebAppManifest\Service\Image;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Controller\Adminhtml\Cache as MagentoAdminCache;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Cache\Frontend\Pool;
use Magento\Framework\App\Cache\StateInterface;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;

class CleanResizedImages extends MagentoAdminCache
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * CleanResizedImages constructor.
     *
     * @param Filesystem        $filesystem
     * @param Context           $context
     * @param TypeListInterface $cacheTypeList
     * @param StateInterface    $cacheState
     * @param Pool              $cacheFrontendPool
     * @param PageFactory       $resultPageFactory
     */
    public function __construct(
        Filesystem $filesystem,
        Context $context,
        TypeListInterface $cacheTypeList,
        StateInterface $cacheState,
        Pool $cacheFrontendPool,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context, $cacheTypeList, $cacheState, $cacheFrontendPool, $resultPageFactory);
        $this->filesystem = $filesystem;
    }

    /**
     * Clean JS/css files cache
     *
     * @return Redirect
     */
    public function execute()
    {
        try {
            $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA)->delete(Image::CACHE_DIRECTORY);
            $this->_eventManager->dispatch('m2bp_web_app_manifest_clean_images_cache_after');
            $this->messageManager->addSuccessMessage(__('The resized images cache was cleaned.'));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('An error occurred while clearing the resized images cache.'));
        }

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('adminhtml/cache');
    }
}