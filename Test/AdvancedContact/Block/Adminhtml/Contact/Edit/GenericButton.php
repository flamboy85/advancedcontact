<?php
namespace Test\AdvancedContact\Block\Adminhtml\Contact\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Test\AdvancedContact\Api\ContactRepositoryInterface;

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
     * @var ContactRepositoryInterface
     */
    protected $contactRepository;

    /**
     * @param Context $context
     * @param ContactRepositoryInterface $contactRepository
     */
    public function __construct(
        Context $context,
        ContactRepositoryInterface $contactRepository
    ) {
        $this->context = $context;
        $this->contactRepository = $contactRepository;
    }

    /**
     * Return Contact ID
     *
     * @return int|null
     */
    public function getContactId()
    {
        try {
            return $this->contactRepository->getById(
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
