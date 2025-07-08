<?php

declare(strict_types=1);

namespace Modules\User\Console\Commands;

use Illuminate\Console\Command;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Illuminate\Support\Arr;
use Symfony\Component\Console\Input\InputOption;
use Webmozart\Assert\Assert;

use function Laravel\Prompts\text;
use function Laravel\Prompts\select;

/**
 * Command to change user type based on project configuration.
 *
 * This command allows administrators to change the type of a user
 * by selecting from available child types in the system.
 */
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
     *
     * @return void
     */
    public function handle(): void
    {
        $xot = XotData::make();
        $email = text('User email?');
        
        /** @var UserContract $user */
        $user = XotData::make()->getUserByEmail($email);

        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return;
        }
        if (!method_exists($user, 'getChildTypes')) {
            $this->error('User model does not have childTypes method.');
            return;
        }

        $childTypes = $xot->getUserChildTypes();
        /** @phpstan-ignore-next-line */
        $this->info("Current user type: {$user->type?->getLabel()}");
        
        $typeClass = $xot->getUserChildTypeClass();
        $options = Arr::mapWithKeys($childTypes, function ($item, int|string $key){
            //dddx($item->getLabel());
            //$val = $typeClass::tryFrom((string) $key)?->getLabel();
            //return [(string) $key => '['.$key.'] '.$val.''];
            return[$item->value => $item->getLabel()];
        });

        $newType = select('Select new user type:', $options);
        
        Assert::notNull($newTypeEnum = $typeClass::tryFrom($newType));
        
        $user->type = $newTypeEnum;
        $user->save();
        
        $this->info("User type changed to '{$user->type->getLabel()}' for {$email}");
    }
}
