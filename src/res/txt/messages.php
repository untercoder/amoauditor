<?php
return [
    'Nosekpt\Amoauditor\App\Core\CommandFactory' => [
        'command-not-found' => 'Комманда не найдена!',
    ],
    'Nosekpt\Amoauditor\App\Core\Commands\HelpCommand' => [
      'server-off' => "Для корректной работы аудитора не забудь запустить локальный сервер. php -S localhost:80 /report"
    ],
    'Nosekpt\Amoauditor\App\Core\Commands\InitCommand' => [
        'work-dir-created' => "Рабочии директории уже созданы",
        'work-dir-success' => "Все прошло успешно. Рабочии директории созданы!"
    ]
];