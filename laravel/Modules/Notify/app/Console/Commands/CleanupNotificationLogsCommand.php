<?php

declare(strict_types=1);

namespace Modules\Notify\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Notify\Models\NotificationLog;

class CleanupNotificationLogsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:cleanup-logs {--days=30 : Number of days to keep logs}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old notification logs';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $days = (int) $this->option('days');
        
        if ($days < 1) {
            $this->error('The --days option must be at least 1.');
            return 1;
        }

        $cutoffDate = Carbon::now()->subDays($days);
        
        $this->info("Deleting notification logs older than {$cutoffDate->format('Y-m-d')}...");
        
        $deleted = NotificationLog::query()
            ->where('created_at', '<', $cutoffDate)
            ->where('status', '!=', 'pending')
            ->delete();
            
        $this->info("Deleted {$deleted} notification logs.");
        
        return 0;
    }
}
