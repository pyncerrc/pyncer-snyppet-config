<?php
namespace Pyncer\Snyppet\Config\Install;

use Pyncer\Database\Value;
use Pyncer\Snyppet\AbstractInstall;

class Install extends AbstractInstall
{
    protected function safeInstall(): bool
    {
        $this->connection->createTable('config')
            ->serial('id')
            ->string('key', 50)->index()
            ->text('value')
            ->bool('preload')->default(false)->index()
            ->execute();

        return true;
    }

    protected function safeUninstall(): bool
    {
        if ($this->connection->hasTable('config')) {
            $this->connection->dropTable('config');
        }

        return true;
    }
}
