<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\AsynchronousOperations\Model\ResourceModel\Operation;

use Magento\AsynchronousOperations\Api\Data\OperationInterface;
use Magento\AsynchronousOperations\Api\Data\OperationInterfaceFactory;
use Magento\Framework\MessageQueue\MessageValidator;
use Magento\Framework\MessageQueue\MessageEncoder;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\EntityManager\EntityManager;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Create operation for list of bulk operations.
 */
class OperationRepository
{
    /**
     * @var \Magento\AsynchronousOperations\Api\Data\OperationInterfaceFactory
     */
    private $operationFactory;

    /**
     * @var Json
     */
    private $jsonSerializer;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var MessageEncoder
     */
    private $messageEncoder;

    /**
     * @var MessageValidator
     */
    private $messageValidator;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param OperationInterfaceFactory $operationFactory
     * @param EntityManager $entityManager
     * @param MessageValidator $messageValidator
     * @param MessageEncoder $messageEncoder
     * @param Json $jsonSerializer
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        OperationInterfaceFactory $operationFactory,
        EntityManager $entityManager,
        MessageValidator $messageValidator,
        MessageEncoder $messageEncoder,
        Json $jsonSerializer,
        StoreManagerInterface $storeManager
    ) {
        $this->operationFactory = $operationFactory;
        $this->jsonSerializer = $jsonSerializer;
        $this->messageEncoder = $messageEncoder;
        $this->messageValidator = $messageValidator;
        $this->entityManager = $entityManager;
        $this->storeManager = $storeManager;
    }

    /**
     * @param $topicName
     * @param $entityParams
     * @param $groupId
     * @return mixed
     */
    public function createByTopic($topicName, $entityParams, $groupId)
    {
        $this->messageValidator->validate($topicName, $entityParams);
        $encodedMessage = $this->messageEncoder->encode($topicName, $entityParams);
        $storeId = $this->storeManager->getStore()->getId();
        $serializedData = [
            'entity_id'        => null,
            'entity_link'      => '',
            'meta_information' => $encodedMessage,
        ];
        $data = [
            'data' => [
                OperationInterface::BULK_ID         => $groupId,
                OperationInterface::TOPIC_NAME      => $topicName,
                OperationInterface::SERIALIZED_DATA => $this->jsonSerializer->serialize($serializedData),
                OperationInterface::STATUS          => OperationInterface::STATUS_TYPE_OPEN,
                OperationInterface::STORE_ID        => $storeId
            ],
        ];

        /** @var \Magento\AsynchronousOperations\Api\Data\OperationInterface $operation */
        $operation = $this->operationFactory->create($data);
        return $this->entityManager->save($operation);
    }
}
