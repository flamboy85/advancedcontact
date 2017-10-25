<?php

namespace Test\AdvancedContact\Model\Contact\Source;

class StatusOptions implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Contact not notified status
     */
    const STATUS_NOT_NOTIFIED = 0;
    /**
     * Contact notified status
     */
    const STATUS_NOTIFIED = 1;
    /**
     * to option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            [
                'value' => self::STATUS_NOT_NOTIFIED,
                'label' => __('Not Notified')
            ],
            [
                'value' => self::STATUS_NOTIFIED,
                'label' => __('Notified')
            ],
        ];
        return $options;

    }
}
