<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('my_cine_mania', 'pgsql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'dsn' => 'pgsql:host=127.0.1.1;port=5432;dbname=my_cine_mania;user=postgres;password=123456',
  'user' => 'postgres',
  'password' => '123456',
  'attributes' =>
  array (
    'ATTR_EMULATE_PREPARES' => false,
  ),
  'classname' => '\\Propel\\Runtime\\Connection\\ConnectionWrapper',
));
$manager->setName('my_cine_mania');
$serviceContainer->setConnectionManager('my_cine_mania', $manager);
$serviceContainer->setDefaultDatasource('my_cine_mania');