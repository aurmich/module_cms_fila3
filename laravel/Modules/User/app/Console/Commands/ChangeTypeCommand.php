<?php

declare(strict_types=1);

namespace Modules\User\Console\Commands;

use Illuminate\Support\Arr;
use Webmozart\Assert\Assert;
use Modules\Xot\Datas\XotData;
use Illuminate\Console\Command;
use function Laravel\Prompts\text;

use function Laravel\Prompts\select;
use Modules\Xot\Contracts\UserContract;
use Symfony\Component\Console\Input\InputOption;

class ChangeTypeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'user:change-type';

    /**
     * The console command description.
     *
     * @var string|null
     */
    protected $description = 'Change user type based on project configuration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $email = text('User email?');

        /** @var UserContract */
        $user = XotData::make()->getUserByEmail($email);

        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return;
        }
        if(!method_exists($user,'getChildTypes')){
            $this->error('User model does not have childTypes method.');
            return;
        }
        $childTypes = $user->getChildTypes();

        $this->info("Current user type: {$user->type->getLabel()}");
        $typeClass = get_class($user->type);
        $options=Arr::mapWithKeys($childTypes,
            function ($item, string $key) use($typeClass) {
                $val=$typeClass::tryFrom($key)?->getLabel();
                return [$key => $val];
            }
        );
        // Selezione del nuovo tipo

        $newType = select('Select new user type:', $options);

        // Salva il tipo precedente per il log
        //$oldType = $this->getCurrentTypeValue($user);

        // Aggiorna il tipo utente
        //$user->type = $newType;
        Assert::notNull($newTypeEnum=$typeClass::tryFrom($newType));

        $user->type = $newTypeEnum;
        $user->save();

        $this->info("User type changed to '{$user->type->getLabel()}' for {$email}");

        // Log dell'attività se disponibile
        //$this->logActivity($user, $oldType, $newType);
    }


}
