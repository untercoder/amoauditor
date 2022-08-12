<?php
return [
    'AMOCRM' => 'Проверить на редактирование суперглобальной переменной AMOCRM!',
    'amohash' => 'Использования amohash запрещено',
    'eval' => 'Проверка на eval()',
    'async' => "Проверка на async=false",
    'сonsole.log' => "Проверка на логи в консоль браузера",
    'console.error' => "Проверка на error",
    'alert' => "Проверка на alert",
    '"$\.ajax"' => "Запрещено использовать ajax в циклах.",
    '"$\.post"' => "Запрещено использовать в циклах $.post",
    '"$\.get"' => "Запрещено использовать в циклах $.get ",
    'crm_post' => "Запрещено использовать в циклах crm_post",
    '//' => "Не должно быть закомментированного кода, чек возможные cdn",
    '.switcher' => 'Код виджета не должен опираться на стили switchera (switcher__on, switcher__off) - .switcher' ,
    'switcher__on' => 'Код виджета не должен опираться на стили switchera (switcher__on, switcher__off) - switcher__on',
    'switcher__off' => 'Код виджета не должен опираться на стили switchera (switcher__on, switcher__off) - switcher__off',
    '.widget-rating-box__rating-count' => 'Запрещено, присваивается новое значение рейтинга виджета в маркете',
    'upl/' => 'Дополнительные плагины виджета не должны ссылаться на временную папку виджета (upl)',
    'moment' => 'Если есть использование библиотеки moment, то она должна быть проинициализирована в шапке скрипта:',
    'cdn' => 'Больше нельзя юзать cdn',
];
