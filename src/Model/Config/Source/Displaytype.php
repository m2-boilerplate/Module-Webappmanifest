<?php

namespace M2Boilerplate\WebAppManifest\Model\Config\Source;

class Displaytype implements \Magento\Framework\Data\OptionSourceInterface
{
    const BROWSER = 'browser';
    const MINIMAL_UI = 'minimal-ui';
    const STANDALONE = 'standalone';
    const FULL_SCREEN = 'fullscreen';

    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        $options = [];
        foreach ($this->toArray() as $value => $label) {
            $options[] = ["value" => $value, "label" => $label];
        }

        return $options;
    }

    /**
     * Get options in "key=>value" format.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            "browser"    => __("Web Page"),
            "minimal-ui" => __("Minimal UI"),
            "standalone" => __("Standalone App"),
            "fullscreen" => __("Fullscreen App"),
        ];
    }
}
