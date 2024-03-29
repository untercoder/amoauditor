<?php

namespace Nosekpt\Amoauditor\App\Helpers;

use Shasoft\Console\Console;

class  ConsoleSay
{
    public static function errorConsole(array $errors) : void {
        Console::indent(0)->color('light_red')->write('Amoauditor error!:')->enter();
        Console::indent(1)->writeln('');
        foreach ($errors as $error) {
            Console::indent(0)->color('red')->bgcolor('light_gray')->write($error)->enter();
        }
        Console::indent(0)->writeln('');
    }

    public static function successConsole(array $message) {
        if(isset($message['header'])) {
            Console::indent(0)->color('yellow')->write($message['header'])->enter();
            Console::indent(1)->writeln('');
        }
        Console::indent(0)->color('light_green')->write($message['body'])->enter();
        Console::indent(0)->writeln('');
    }

    public static function commentConsole(array $message) {
        Console::indent(0)->color('yellow')->write($message['body'])->enter();
        Console::indent(0)->writeln('');
    }

    public static function newLineConsole() {
        Console::indent(0)->writeln('');
    }

    public static function searchConsole(array $message) {
        $array = explode($message['param'], $message['body']);
        for ($i = 0; $i < count($array) - 1; $i++) {
            Console::indent(0)->color('white')->write($array[$i]);
            Console::indent(0)->color('light_blue')->write($message['param']);
        }
        Console::indent(0)->color('white')->write($array[count($array) - 1])->enter();
    }

    public static function borderConsole( int $auditCount = 0 ) {
        Console::indent(0)->color('purple')->write("++++++++++++++++++++++++++++++++++++")->enter();
        Console::indent(0)->color('purple')->write("Сесиия аудита №".$auditCount." Время загрузки виджета: ".date("Y-m-d H:i:s"))->enter();
        Console::indent(0)->color('purple')->write("++++++++++++++++++++++++++++++++++++")->enter();
        Console::indent(0)->writeln('');
    }
}