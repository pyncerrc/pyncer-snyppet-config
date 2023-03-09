<?php
namespace Pyncer\Snyppet\Config\Table\Config;

use Pyncer\Data\Mapper\AbstractMapper;
use Pyncer\Data\Mapper\MapperResultInterface;
use Pyncer\Data\MapperQuery\MapperQueryInterface;
use Pyncer\Data\Model\ModelInterface;
use Pyncer\Snyppet\Config\Table\Config\ConfigModel;

class ConfigMapper extends AbstractMapper
{
    public function getTable(): string
    {
        return 'config';
    }

    public function forgeModel(iterable $data = []): ModelInterface
    {
        return new ConfigModel($data);
    }

    public function isValidModel(ModelInterface $model): bool
    {
        return ($model instanceof ConfigModel);
    }

    public function selectAllPreloaded(
        ?MapperQueryInterface $mapperQuery = null
    ): MapperResultInterface
    {
        return $this->selectAllByColumns(
            ['preload' => true],
            $mapperQuery
        );
    }

    public function selectByKey(
        string $key,
        ?MapperQueryInterface $mapperQuery = null
    ): ?ModelInterface
    {
        return $this->selectByColumns(
            ['key' => $key],
            $mapperQuery
        );
    }

    public function selectAllByKeys(
        array $keys,
        ?MapperQueryInterface $mapperQuery = null
    ): MapperResultInterface
    {
        return $this->selectAllByColumns(
            ['key' => $keys],
            $mapperQuery
        );
    }
}
