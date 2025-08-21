<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Contracts\UserContract;

class RecordNotificationData extends Data
{
    public UserContract $record;
    public string $channel;

    public function getChannel(): string
    {
        return $this->channel;
    }

    public function getRoute(): string
    {
        switch($this->channel){
            case 'mail':
                return $this->record->email;
            case 'sms':
                return $this->record->phone;
        }
        throw new \Exception('Channel ['.$this->channel.'] not supported');
    }


}
