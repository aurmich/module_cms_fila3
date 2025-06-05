<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Clusters\Test\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;
use Modules\Notify\Filament\Clusters\Test;

class SlackNotificationPage extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';

    protected static string $view = 'notify::filament.clusters.test.pages.slack-notification';

    protected static ?string $cluster = Test::class;
}
