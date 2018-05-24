<?php

namespace Typed;

use TypeError;

final class WrongType extends TypeError
{
    public function __construct($message)
    {
        parent::__construct($this->wrapMessage($message));
    }

    public static function wrap(TypeError $typeError): WrongType
    {
        return new self($typeError->getMessage());
    }

    public static function fromMessage(string $message): WrongType
    {
        return new self($message);
    }

    private function wrapMessage(string $message): string
    {
        $messageParts = explode('must be', $message);

        $location = debug_backtrace()[4] ?? null;

        return 'Argument passed must be' . end($messageParts) . " in {$location['file']}:{$location['line']}\n";
    }
}
