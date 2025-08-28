<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Feature;

use Modules\Job\Models\Job;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

class JobBusinessLogicTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_job_with_basic_information(): void
    {
        $jobData = [
            'queue' => 'default',
            'payload' => json_encode([
                'displayName' => 'App\Jobs\ProcessUserJob',
                'job' => 'Illuminate\Queue\CallQueuedHandler@call',
                'maxTries' => 3,
                'maxExceptions' => 0,
                'timeout' => 120,
                'data' => ['user_id' => 123],
            ]),
            'attempts' => 0,
            'available_at' => now()->timestamp,
        ];

        $job = Job::create($jobData);

        $this->assertDatabaseHas('jobs', [
            'id' => $job->id,
            'queue' => 'default',
            'attempts' => 0,
        ]);

        $this->assertEquals('default', $job->queue);
        $this->assertEquals(0, $job->attempts);
        $this->assertNull($job->reserved_at);
    }

    /** @test */
    public function it_can_manage_job_status_correctly(): void
    {
        // Job in attesa
        $waitingJob = Job::create([
            'queue' => 'high',
            'payload' => json_encode(['displayName' => 'TestJob']),
            'attempts' => 0,
            'available_at' => now()->timestamp,
        ]);

        $this->assertEquals('waiting', $waitingJob->status);

        // Job in esecuzione
        $runningJob = Job::create([
            'queue' => 'high',
            'payload' => json_encode(['displayName' => 'TestJob']),
            'attempts' => 1,
            'reserved_at' => now()->timestamp,
            'available_at' => now()->timestamp,
        ]);

        $this->assertEquals('running', $runningJob->status);
    }

    /** @test */
    public function it_can_handle_job_attempts_and_retries(): void
    {
        $job = Job::create([
            'queue' => 'emails',
            'payload' => json_encode(['displayName' => 'SendEmailJob']),
            'attempts' => 0,
            'available_at' => now()->timestamp,
        ]);

        // Primo tentativo
        $job->update([
            'attempts' => 1,
            'reserved_at' => now()->timestamp,
        ]);

        $this->assertEquals(1, $job->attempts);
        $this->assertEquals('running', $job->status);

        // Secondo tentativo
        $job->update([
            'attempts' => 2,
            'reserved_at' => null,
            'available_at' => now()->addMinutes(5)->timestamp,
        ]);

        $this->assertEquals(2, $job->attempts);
        $this->assertEquals('waiting', $job->status);
    }

    /** @test */
    public function it_can_extract_display_name_from_payload(): void
    {
        $job = Job::create([
            'queue' => 'notifications',
            'payload' => json_encode([
                'displayName' => 'App\Jobs\SendNotificationJob',
                'job' => 'Illuminate\Queue\CallQueuedHandler@call',
                'data' => ['user_id' => 456],
            ]),
            'attempts' => 0,
            'available_at' => now()->timestamp,
        ]);

        $this->assertEquals('App\Jobs\SendNotificationJob', $job->display_name);
    }

    /** @test */
    public function it_can_handle_complex_payload_structures(): void
    {
        $complexPayload = [
            'displayName' => 'App\Jobs\ComplexProcessingJob',
            'job' => 'Illuminate\Queue\CallQueuedHandler@call',
            'maxTries' => 5,
            'maxExceptions' => 1,
            'timeout' => 300,
            'data' => [
                'user_id' => 789,
                'process_type' => 'batch_processing',
                'options' => [
                    'priority' => 'high',
                    'notify_on_completion' => true,
                    'retry_strategy' => 'exponential_backoff',
                ],
                'metadata' => [
                    'source' => 'user_upload',
                    'file_size' => 1024000,
                    'processing_requirements' => ['validation', 'transformation', 'storage'],
                ],
            ],
            'tags' => ['user_processing', 'batch', 'high_priority'],
        ];

        $job = Job::create([
            'queue' => 'processing',
            'payload' => json_encode($complexPayload),
            'attempts' => 0,
            'available_at' => now()->timestamp,
        ]);

        $this->assertEquals('App\Jobs\ComplexProcessingJob', $job->display_name);
        $this->assertEquals('processing', $job->queue);
    }

    /** @test */
    public function it_can_handle_job_scheduling_and_delays(): void
    {
        $futureTime = now()->addHours(2);
        
        $job = Job::create([
            'queue' => 'scheduled',
            'payload' => json_encode(['displayName' => 'ScheduledJob']),
            'attempts' => 0,
            'available_at' => $futureTime->timestamp,
        ]);

        $this->assertTrue($job->available_at > now()->timestamp);
        $this->assertEquals('waiting', $job->status);
    }

    /** @test */
    public function it_can_manage_job_reservation_and_processing(): void
    {
        $job = Job::create([
            'queue' => 'high',
            'payload' => json_encode(['displayName' => 'PriorityJob']),
            'attempts' => 0,
            'available_at' => now()->timestamp,
        ]);

        // Riserva il job per l'elaborazione
        $reservationTime = now();
        $job->update([
            'reserved_at' => $reservationTime->timestamp,
            'attempts' => 1,
        ]);

        $this->assertEquals('running', $job->status);
        $this->assertEquals(1, $job->attempts);
        $this->assertNotNull($job->reserved_at);

        // Rilascia il job (fallimento o completamento)
        $job->update([
            'reserved_at' => null,
            'attempts' => 2,
            'available_at' => now()->addMinutes(10)->timestamp, // Delay per retry
        ]);

        $this->assertEquals('waiting', $job->status);
        $this->assertEquals(2, $job->attempts);
        $this->assertNull($job->reserved_at);
    }

    /** @test */
    public function it_can_handle_job_priority_queues(): void
    {
        $highPriorityJob = Job::create([
            'queue' => 'high',
            'payload' => json_encode(['displayName' => 'HighPriorityJob']),
            'attempts' => 0,
            'available_at' => now()->timestamp,
        ]);

        $lowPriorityJob = Job::create([
            'queue' => 'low',
            'payload' => json_encode(['displayName' => 'LowPriorityJob']),
            'attempts' => 0,
            'available_at' => now()->timestamp,
        ]);

        $defaultJob = Job::create([
            'queue' => 'default',
            'payload' => json_encode(['displayName' => 'DefaultJob']),
            'attempts' => 0,
            'available_at' => now()->timestamp,
        ]);

        $this->assertEquals('high', $highPriorityJob->queue);
        $this->assertEquals('low', $lowPriorityJob->queue);
        $this->assertEquals('default', $defaultJob->queue);
    }

    /** @test */
    public function it_can_handle_job_cleanup_and_maintenance(): void
    {
        // Job completato (reserved_at impostato ma job non più attivo)
        $completedJob = Job::create([
            'queue' => 'default',
            'payload' => json_encode(['displayName' => 'CompletedJob']),
            'attempts' => 1,
            'reserved_at' => now()->subHours(1)->timestamp,
            'available_at' => now()->subHours(1)->timestamp,
        ]);

        // Job fallito con troppi tentativi
        $failedJob = Job::create([
            'queue' => 'emails',
            'payload' => json_encode(['displayName' => 'FailedJob']),
            'attempts' => 5,
            'available_at' => now()->subMinutes(30)->timestamp,
        ]);

        // Verifica che i job siano gestibili per la pulizia
        $this->assertTrue($completedJob->reserved_at < now()->subMinutes(30)->timestamp);
        $this->assertTrue($failedJob->attempts >= 5);
    }

    /** @test */
    public function it_can_validate_job_payload_integrity(): void
    {
        // Payload valido
        $validJob = Job::create([
            'queue' => 'default',
            'payload' => json_encode(['displayName' => 'ValidJob']),
            'attempts' => 0,
            'available_at' => now()->timestamp,
        ]);

        $this->assertNotNull($validJob->display_name);

        // Payload non valido (non JSON)
        $invalidJob = Job::create([
            'queue' => 'default',
            'payload' => 'invalid-json-payload',
            'attempts' => 0,
            'available_at' => now()->timestamp,
        ]);

        $this->assertNull($invalidJob->display_name);
    }

    /** @test */
    public function it_can_handle_job_batch_operations(): void
    {
        // Crea un batch di job
        $batchJobs = [];
        for ($i = 1; $i <= 5; $i++) {
            $batchJobs[] = Job::create([
                'queue' => 'batch',
                'payload' => json_encode([
                    'displayName' => 'BatchJob',
                    'data' => ['batch_id' => 1, 'item_id' => $i],
                ]),
                'attempts' => 0,
                'available_at' => now()->timestamp,
            ]);
        }

        $this->assertCount(5, $batchJobs);
        
        foreach ($batchJobs as $job) {
            $this->assertEquals('batch', $job->queue);
            $this->assertEquals('BatchJob', $job->display_name);
            $this->assertEquals('waiting', $job->status);
        }
    }
}
