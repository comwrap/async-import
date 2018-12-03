<?php 

namespace Magento\ImportService\Model;

class ImportResponse extends \Magento\Framework\Model\AbstractModel
    implements \Magento\ImportService\Api\Data\ImportResponseInterface
{   
    /**
     *
     * Get file ID
     *
     * @return int
     */
    public function getFileId()
    {
        return $this->getData(self::FILE_ID);
    }
    
    /**
     *
     * Get file status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }
    
    /**
     *
     * Get error
     * @return string
     */
    public function getError()
    {
        return $this->getData(self::ERROR);
    }

    /**
     * @param $fileId
     * @return ImportResponse|mixed
     */
    public function setFileId($fileId)
    {
        return $this->setData(self::FILE_ID, $fileId);
    }

    /**
     * @param $status
     * @return ImportResponse|mixed
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @param $error
     * @return ImportResponse|mixed
     */
    public function setError($error)
    {
        return $this->setData(self::ERROR, $error);
    }
    
    public function setCompleted()
    {
        $this->setStatus(self::STATUS_COMPLETED);
        return $this;
    }
    
    public function setFailed()
    {
        $this->setStatus(self::STATUS_FAILED);
        return $this;
    }
}