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
                Model\RSSTable::class => function($container) {
                    $tableGateway = $container->get(Model\RSSTableGateway::class);
                    return new Model\RSSTable($tableGateway);
                },
                Model\RSSTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\RSS());
                    return new TableGateway('rss', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    // Maps factories and controllers
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\RSSController::class => function($container) {
                    return new Controller\RSSController(
                        $container->get(Model\RSSTable::class)
                    );
                },
            ],
        ];
    }
}
