<?php
namespace InformikaDoctrineClickHouse\Listeners;

use Doctrine\ORM\Event\OnFlushEventArgs;
use InformikaDoctrineClickHouse\ChFields\ChBaseFiled;
use InformikaDoctrineClickHouse\ChOperations\ChInsertOperation;
use InformikaDoctrineClickHouse\ChRows\ChBaseRow;
use InformikaDoctrineClickHouse\Driver\DBAL\Connection;
use InformikaDoctrineClickHouse\Exception\AnnotationReaderException;
use InformikaDoctrineClickHouse\Managers\ClickHouseClientManager;
use InformikaDoctrineClickHouse\Mapping\Annotation\Column;
use InformikaDoctrineClickHouse\Mapping\ClassMetadataFactory;
use InformikaDoctrineClickHouse\Mapping\ClassMetadata;

/**
 * Class FlushClickHouseListener
 * @package InformikaDoctrineClickHouse\Listeners
 */
class FlushClickHouseListener
{
    /** @var ClassMetadata[] */
    protected $chAnnotations = [];

    /** @var  ClassMetadataFactory */
    private $classMetadataFactory;

    /** @var  ClickHouseClientManager */
    private $clickHouseClientManager;

    /** @var  Connection */
    private $connection;

    /**
     * FlushClickHouseListener constructor.
     * @param ClassMetadataFactory $classMetadataFactory
     * @param ClickHouseClientManager $clickHouseClientManager
     * @param Connection $connection
     */
    public function __construct(ClassMetadataFactory $classMetadataFactory, ClickHouseClientManager $clickHouseClientManager, Connection $connection)
    {
        $this->setClassMetadataFactory($classMetadataFactory);
        $this->setClickHouseClientManager($clickHouseClientManager);
        $this->setConnection($connection);
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

        $connection = $this->getConnection();

        /** @var ChInsertOperation[] $chInsertOperations */
        $chInsertOperations = [];
        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            if ($chMetadata = $this->getEntityAnnotations($entity, $chMetadataFactory)) {
                $chTableName = $chMetadata->getTable()->name;
                if (!isset($chInsertOperations[$chTableName])) {
                    $chInsertOperation = new ChInsertOperation($connection);
                    $chInsertOperation->setTable($chMetadata->getTable());
                    $chInsertOperations[$chTableName] = $chInsertOperation;
                } else {
                    /** @var ChInsertOperation $chInsertOperation */
                    $chInsertOperation = $chInsertOperations[$chTableName];
                }
                $entityData = $uow->getOriginalEntityData($entity);
                $chInsertRow = new ChBaseRow();
                /** @var Column $column */
                foreach ($chMetadata->getColumns() as $column) {
                    $chInsertRow->addField(new ChBaseFiled($column, isset($entityData[$column->getPropertyName()]) ? $entityData[$column->getPropertyName()] : null));
                }
                $chInsertOperation->addRow($chInsertRow);
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
    public function getClassMetadataFactory()
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
    public function getClickHouseClientManager()
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

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param Connection $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }
}