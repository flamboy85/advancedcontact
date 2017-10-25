<?php
namespace Test\AdvancedContact\Controller\Adminhtml;

use Test\AdvancedContact\Api\ContactRepositoryInterface;

/**
 * Class Contact
 * @package Test\AdvancedContact\Controller\Adminhtml
 */
abstract class Contact extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Test_AdvancedContact::contact';

    /**
     * @var ContactRepositoryInterface
     */
    protected $contactRepository;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        ContactRepositoryInterface $contactRepository,
        \Magento\Framework\Registry $coreRegistry)
    {
        $this->_coreRegistry = $coreRegistry;
        $this->contactRepository = $contactRepository;
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function initPage($resultPage)
    {
        $resultPage->setActiveMenu('Test_AdvancedContact::contact')
            ->addBreadcrumb(__('Test'), __('Test'))
            ->addBreadcrumb(__('Advanced Contacts'), __('Advanced Contacts'));
        return $resultPage;
    }
}
