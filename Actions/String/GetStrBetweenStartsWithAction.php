<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\String;

use Spatie\QueueableAction\QueueableAction;

class GetStrBetweenStartsWithAction
{
    use QueueableAction;

    public function execute(string $body, string $start, string $open, string $close): string
    {
        $pos = strpos($body, $start);
<<<<<<< HEAD
        if ($pos === false) {
=======
        if (false === $pos) {
>>>>>>> 35d9347 (.)
            throw new \Exception("Cannot find $start in $body [".__LINE__.']['.__FILE__.']');
        }
        $pos1 = strpos($body, $close, $pos);

        $length = $pos1 - $pos;
        do {
            $body1 = substr($body, $pos, $length);
            $open_count = substr_count($body1, $open);
            $close_count = substr_count($body1, $close);
<<<<<<< HEAD
            $length++;
=======
            ++$length;
>>>>>>> 35d9347 (.)
        } while ($open_count !== $close_count);

        return $body1;
    }
}
