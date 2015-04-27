<?php
namespace Authorization;
 
use Authorization\Model\Authorization;
use Authorization\Model\AuthorizationTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

// use Zend\Mvc\ModuleRouteListener;
// use Zend\Mvc\MvcEvent;

class Module
{
    public function getAutoloaderConfig()
	{
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
	public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'AuthorizationModelAuthorizationTable' =>  function($sm) {
                    $tableGateway = $sm->get('AuthorizationTableGateway');
                    $table = new AuthorizationTable($tableGateway);
                    return $table;
                },
                'AuthorizationTableGateway' => function($sm) {
                    $dbAdapter = $sm->get('ZendDbAdapterAdapter');				
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Authorization());
                    return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}