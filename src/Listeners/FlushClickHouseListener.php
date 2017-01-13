<?php
namespace InformikaClickHouse\Listeners;

use Doctrine\ORM\Event\OnFlushEventArgs;
use InformikaClickHouse\ChOperations\ChInsertOperation;
use InformikaClickHouse\Exception\AnnotationReaderException;
use InformikaClickHouse\Managers\ClickHouseClientManager;
use InformikaClickHouse\Mapping\Annotation\Column;
use InformikaClickHouse\Mapping\ClassMetadataFactory;
use InformikaClickHouse\Mapping\ClassMetadata;

/**
 * Class FlushClickHouseListener
 * @package InformikaClickHouse\Listeners
 */
class FlushClickHouseListener
{
    /** @var ClassMetadata[] */
    protected $chAnnotations = [];

    /** @var  ClassMetadataFactory */
    private $classMetadataFactory;

    /** @var  ClickHouseClientManager */
    private $clickHouseClientManager;

    /**
     * FlushClickHouseListener constructor.
     * @param ClassMetadataFactory $classMetadataFactory
     * @param ClickHouseClientManager $clickHouseClientManager
     */
    public function __construct(ClassMetadataFactory $classMetadataFactory, ClickHouseClientManager $clickHouseClientManager)
    {
        $this->setClassMetadataFactory($classMetadataFactory);
        $this->setClickHouseClientManager($clickHouseClientManager);
    }

    /**
     * @param OnFlushEventArgs $eventArgs
     * @throws AnnotationReaderException
     */
    public function onFlush(OnFlushEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();

        $chMetadataFactory = $this->getClassMetadataFactory();

        $chClient = $this->getClickHouseClientManager()->getClient();

        /** @var ChInsertOperation[] $chInsertOperations */
        $chInsertOperations = [];
        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            if ($chMetadata = $this->getEntityAnnotations($entity, $chMetadataFactory)) {
                $chTableName = $chMetadata->getTable()->name;
                if (!isset($chInsertOperations[$chTableName])) {
                    $chInsertOperation = new ChInsertOperation($chClient);
                    $chInsertOperation->setTable($chTableName);
                    $chInsertOperations[$chTableName] = $chInsertOperation;
                } else {
                    /** @var ChInsertOperation $chInsertOperation */
                    $chInsertOperation = $chInsertOperations[$chTableName];
                }
                $entityData = $uow->getOriginalEntityData($entity);
                $row = [];
                $columns = [];
                /** @var Column $column */
                foreach ($chMetadata->getColumns() as $column) {
                    $columns[] = $column->name;
                    $row[$column->name] = isset($entityData[$column->getProperty()]) ? $entityData[$column->getProperty()] : null;
                }
                $chInsertOperation->addRow($row);
                throw new AnnotationReaderException('Find CH annotations for entity ' . get_class($entity) . '. Table: ' . $chMetadata->getTable()->name . '. Columns: ' . implode(', ', $columns));
            }
        }

        /** @var ChInsertOperation $chInsertOperation */
        foreach ($chInsertOperations as $chInsertOperation) {
            $chInsertOperation->prepare();
            $chInsertOperation->execute();
        }

        foreach ($uow->getScheduledEntityUpdates() as $entity) {

        }

        foreach ($uow->getScheduledEntityDeletions() as $entity) {

        }

        foreach ($uow->getScheduledCollectionDeletions() as $col) {

        }

        foreach ($uow->getScheduledCollectionUpdates() as $col) {

        }
    }

    /**
     * @param $entity
     * @param ClassMetadataFactory $chMetadata
     * @return ClassMetadata
     */
    public function getEntityAnnotations($entity, ClassMetadataFactory $chMetadata)
    {
        $className = get_class($entity);

        if (!isset($this->chAnnotations[$className])) {
            $this->chAnnotations[$className] = $chMetadata->loadMetadata($className);
        }

        return $this->chAnnotations[$className];
    }

    /**
     * @return ClassMetadataFactory
     */
    public function getClassMetadataFactory(): ClassMetadataFactory
    {
        return $this->classMetadataFactory;
    }

    /**
     * @param ClassMetadataFactory $classMetadataFactory
     */
    public function setClassMetadataFactory(ClassMetadataFactory $classMetadataFactory)
    {
        $this->classMetadataFactory = $classMetadataFactory;
    }

    /**
     * @return ClickHouseClientManager
     */
    public function getClickHouseClientManager(): ClickHouseClientManager
    {
        return $this->clickHouseClientManager;
    }

    /**
     * @param ClickHouseClientManager $clickHouseClientManager
     */
    public function setClickHouseClientManager(ClickHouseClientManager $clickHouseClientManager)
    {
        $this->clickHouseClientManager = $clickHouseClientManager;
    }
}