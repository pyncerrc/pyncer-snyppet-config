<?php
namespace Pyncer\Snyppet\Config\Table\Config;

use Pyncer\Data\Model\AbstractModel;

class ConfigModel extends AbstractModel
{
    public function getKey(): string
    {
        return $this->get('key');
    }
    public function setKey(string $value): static
    {
        $this->set('key', $value);
        return $this;
    }

    public function getValue(): string
    {
        return $this->get('value');
    }
    public function setValue(string $value): static
    {
        $this->set('value', $value);
        return $this;
    }

    public function getPreload(): bool
    {
        return $this->get('preload');
    }
    public function setPreload(bool $value): static
    {
        $this->set('preload', $value);
        return $this;
    }

    public static function getDefaultData(): array
    {
        return [
            'id' => 0,
            'key' => '',
            'value' => '',
            'preload' => false
        ];
    }
}
