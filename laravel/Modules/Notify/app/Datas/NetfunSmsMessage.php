<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class NetfunSMSMessage extends Data
{
    public function __construct(
        public string $to,
        public string $text,
        public string $from,
        public ?string $reference = null,
        public ?string $scheduled_date = null
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            to: $data['to'],
            text: $data['text'],
            from: $data['from'],
            reference: $data['reference'] ?? null,
            scheduled_date: $data['scheduled_date'] ?? null
        );
    }
}
