<?php

namespace App\Domain\Factory\MyModelFactory;

use App\Domain\Model\MyModelInterface;

/**
 * Class MyModelFactory
 */
final class MyModelFactory implements MyModelFactoryInterface
{
    /**
     * @var MyModelInterface
     */
    private MyModelInterface $myModel;

    /**
     * MyModelFactory constructor
     * @param string $myClass
     */
    public function __construct(string $myClass) {
        $this->myModel = new $myClass();
    }

    /**
     * @param string $uuid
     * @return MyModelInterface
     */
    public function generate(string $uuid): MyModelInterface
    {
        return $this->myModel->setUuid($uuid);
    }
}
