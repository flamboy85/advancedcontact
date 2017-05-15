<?php
namespace Test\AdvancedContact\Block\Adminhtml\Contact\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Test\AdvancedContact\Model\ContactFactory;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var ContactFactory
     */
    protected $contactFactory;

    /**
     * @param Context $context
     * @param ContactFactory $contactFactory
     */
    public function __construct(
        Context $context,
        ContactFactory $contactFactory
    ) {
        $this->context = $context;
        $this->contactFactory = $contactFactory;
    }

    /**
     * Return Contact ID
     *
     * @return int|null
     */
    public function getContactId()
    {
        try {
            return $this->contactFactory->getById(
                $this->context->getRequest()->getParam('contact_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
