<?php

declare(strict_types=1);

namespace Spatie\Typed\Exceptions;

use TypeError;

final class WrongType extends TypeError
{
    public function __construct($message)
    {
        parent::__construct($this->wrapMessage($message));
    }

    public static function wrap(TypeError $typeError): self
    {
        return new self($typeError->getMessage());
    }

    public static function withMessage(string $message): self
    {
        return new self($message);
    }

    private function wrapMessage(string $message): string
    {
        $messageParts = explode('must be', $message);

        $location = debug_backtrace()[4] ?? null;

        return 'Argument passed must be '.end($messageParts)." in {$location['file']}:{$location['line']}\n";
    }
}
