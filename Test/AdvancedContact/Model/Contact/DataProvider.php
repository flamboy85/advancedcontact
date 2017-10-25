<?php
namespace Test\AdvancedContact\Model\Contact;

use Magento\Framework\App\Request\DataPersistorInterface;
use Test\AdvancedContact\Model\ResourceModel\Contact\CollectionFactory;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Test\AdvancedContact\Model\ResourceModel\Contact\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $contactCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $contactCollectionFactory,
        DataPersistorInterface $dataPersistor,
        \Test\AdvancedContact\Helper\Data $helper,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $contactCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Test\AdvancedContact\Model\Contact $contact */
        foreach ($items as $contact) {
            $this->loadedData[$contact->getId()] = $contact->getData();
        }
        $data = $this->dataPersistor->get('advanced_contact');
        if (!empty($data)) {
            $contact = $this->collection->getNewEmptyItem();
            $contact->setData($data);
            $this->loadedData[$contact->getId()] = $contact->getData();
            $this->dataPersistor->clear('advanced_contact');
        }

        return $this->loadedData;
    }
}
