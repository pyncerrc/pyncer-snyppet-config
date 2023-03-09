<?php
namespace Pyncer\Snyppet\Config;

use Pyncer\Snyppet\Config\Table\Config\ConfigMapper;
use Pyncer\Snyppet\Config\Table\Config\ConfigModel;
use Pyncer\Database\ConnectionInterface;
use Pyncer\Database\ConnectionTrait;
use Pyncer\Utility\Params;

use function iterator_to_array;
use function Pyncer\Array\data_explode as pyncer_data_explode;
use function Pyncer\Array\data_implode as pyncer_data_implode;

class ConfigManager extends Params
{
    use ConnectionTrait;

    private array $preload = [];

    public function __construct(ConnectionInterface $connection)
    {
        $this->setConnection($connection);
    }

    public function getArray(string $key, $empty = []): ?Array
    {
        $value = $this->get($key);
        if ($value !== null) {
            $value = pyncer_data_explode(',', $value);
        }

        if ($value === null || $value === []) {
            $value = $empty;
        }

        return $value;
    }

    public function setArray(string $key, ?iterable $value): static
    {
        if ($value === null) {
            $this->set($key, null);
            return $this;
        }

        $this->set($key, pyncer_data_implode(',', iterator_to_array($value)));
        return $this;
    }

    public function getPreload(string $key): bool
    {
        return $this->preload[$key] ?? false;
    }

    public function setPreload(string $key, bool $value): static
    {
        $this->preload[$key] = $value;
        return $this;
    }

    public function preload(): static
    {
        $mapper = new ConfigMapper($this->getConnection());
        $result = $mapper->selectAllPreloaded();

        foreach ($result as $configModel) {
            $this->set($configModel->getKey(), $configModel->getValue());
            $this->preload[$configModel->getKey()] = true;
        }

        return $this;
    }

    public function load(string ...$keys): static
    {
        $configMapper = new ConfigMapper($this->getConnection());
        $result = $configMapper->selectAllByKeys($keys);

        foreach ($result as $configModel) {
            $this->set($configModel->getKey(), $configModel->getValue());
        }

        return $this;
    }
    public function save(string ...$keys): static
    {
        $configMapper = new ConfigMapper($this->getConnection());

        foreach ($keys as $key) {
            $value = $this->get($key);

            if ($value === null) {
                if ($configModel) {
                    $configMapper->delete($configModel);
                }

                continue;
            }

            $configModel = $configMapper->selectByKey($key);

            if (!$configModel) {
                $configModel = new ConfigModel();
                $configModel->setKey($key);
            }

            $value = match ($value) {
                true => '1',
                false => '0',
                default => strval($value),
            };

            $configModel->setValue($value);

            $configModel->setPreload($this->preload[$key] ?? false);

            $configMapper->replace($configModel);
        }

        return $this;
    }
}
