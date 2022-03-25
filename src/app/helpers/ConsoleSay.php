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
}