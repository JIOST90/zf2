<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Authorization\Controller\Authorization' => 'Authorization\Controller\AuthorizationController',
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'authorization' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/authorization[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Authorization\Controller\Authorization',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'authorization' => __DIR__ . '/../view',
        ),
    ),
);