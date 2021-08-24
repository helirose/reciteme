<?php

namespace RSS;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig(): array
    {
        /** @var array $config */
        return include __DIR__ . '/../config/module.config.php';
    }

    // Maps factories and models
    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\ItemTable::class => function($container) {
                    $tableGateway = $container->get(Model\ItemTableGateway::class);
                    return new Model\ItemTable($tableGateway);
                },
                Model\ItemTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Item());
                    return new TableGateway('item', $dbAdapter, null, $resultSetPrototype);
                },
                Model\ChannelTable::class => function($container) {
                    $tableGateway = $container->get(Model\ChannelTableGateway::class);
                    return new Model\ChannelTable($tableGateway);
                },
                Model\ChannelTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Channel());
                    return new TableGateway('channel', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    // Maps factories and controllers
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\ItemController::class => function($container) {
                    return new Controller\ItemController(
                        $container->get(Model\ItemTable::class)
                    );
                },
                Controller\ChannelController::class => function($container) {
                    return new Controller\ChannelController(
                        $container->get(Model\ChannelTable::class)
                    );
                },
            ],
        ];
    }
}
