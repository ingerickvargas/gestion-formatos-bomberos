<?php

return [
    [
        'key' => 'dashboard',
        'label' => 'Dashboard',
        'route' => 'dashboard',
        'icon' => 'home',
        'roles' => ['admin', 'operativo'],
    ],
    [
        'key' => 'preoperacional',
        'label' => 'Preoperacional Vehículos',
        'route' => 'preoperacional.index',
        'icon' => 'truck',
        'roles' => ['admin', 'operativo'],
    ],
    [
        'key' => 'inventario',
        'label' => 'Inventario de Insumos',
        'route' => 'inventario.index',
        'icon' => 'box',
        'roles' => ['admin', 'operativo'],
    ],
    [
        'key' => 'formatos',
        'label' => 'Formatos',
        'route' => 'formatos.index',
        'icon' => 'file',
        'roles' => ['admin', 'operativo'],
    ],
    [
        'key' => 'users',
        'label' => 'Usuarios',
        'route' => 'admin.users.index',
        'icon' => 'users',
        'roles' => ['admin'],
    ],
    [
        'key' => 'access_logs',
        'label' => 'Logs de Acceso',
        'route' => 'admin.access-logs.index',
        'icon' => 'shield',
        'roles' => ['admin'],
    ],
];
