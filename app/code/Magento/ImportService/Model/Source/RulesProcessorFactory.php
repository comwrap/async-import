<?php
namespace Magento\ImportService\Model\Source;

use Magento\ImportService\Model\Source;

/**
 * Factory class for @see \Magento\ImportService\Model\Source
 */
class RulesProcessorFactory
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager = null;

    /**
     * Instance name to create
     *
     * @var string
     */
    private $instanceName = null;

    /**
     * List of shared instances
     *
     * @var array
     */
    private $sharedInstances = [];

    /**
     * @var array
     */
    private $rules;

    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        $rules = []
    ) {
        $this->objectManager = $objectManager;
        $this->rules = $rules;
    }

    /**
     * @param $ruleName
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function create($ruleName, array $data = [])
    {
        foreach ($this->rules as $name => $ruleData) {
            if ($ruleName == $name) {
                if (is_array($ruleData)) {
                    $class = $ruleData['class'];
                    $method = (isset($ruleData['method'])) ? $ruleData['method'] : 'execute';
                    $shared = (boolean)(isset($ruleData['shared'])) ? $ruleData['shared'] : false;
                    if ($shared) {
                        if (!isset($this->sharedInstances[$class])) {
                            $this->sharedInstances[$class] = $this->objectManager->create($class, $data);
                        }
                        return $this->sharedInstances[$class];
                    }
                    return $this->objectManager->create($class, $data);
                } else {
                    $class = $ruleData;
                    return $this->objectManager->create($class, $data);
                }
            }
        }
        throw new \Exception(
            __('Specified processing rule "%1" is wrong or does not exist.', $ruleName)
        );
    }
}
