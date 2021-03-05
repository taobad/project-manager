<?php

namespace App\Traits;

/**
 * Credits to https://github.com/orobogenius/sansdaemon
 */

trait DaemonWorkerTrait
{
    /**
     * Number of jobs processed.
     *
     * @var int
     */
    protected $jobsProcessed = 0;

    /**
     * Process the queue sans-daemon mode.
     *
     * @param string $connection
     * @param string $queue
     *
     * @return void
     */
    protected function runWorkiceDaemon($connection, $queue)
    {
        return $this->processJobs($connection, $queue);
    }

    /**
     * Process jobs from the queue.
     *
     * @param string $connectionName
     * @param string $queue
     *
     * @throws \Throwable
     *
     * @return void
     */
    public function processJobs($connectionName, $queue)
    {
        foreach (explode(',', $queue) as $queue) {
            while ($this->jobShouldProcess($connectionName, $queue, $this->gatherWorkerOptions())) {
                $this->worker->runNextJob($connectionName, $queue, parent::gatherWorkerOptions());

                if ($this->option('jobs')) {
                    $this->jobsProcessed += 1;
                }
            }
        }
    }

    /**
     * Determine if the next job on the queue should be processed.
     *
     * @param string                           $connectionName
     * @param string                           $queue
     * @param \Illuminate\Queue\WorkerOptions  $options
     *
     * @return bool
     */
    protected function jobShouldProcess($connectionName, $queue, $options)
    {
        if ($this->isOverMaxExecutionTime($options)) {
            return false;
        }

        if ($options->jobs) {
            return $this->getSize($connectionName, $queue) != 0
            && $this->jobsProcessed != (int) $options->jobs;
        }

        return $this->getSize($connectionName, $queue) != 0;
    }

    /**
     * Check if worker is running longer, than set max execution time.
     *
     * @param \Illuminate\Queue\WorkerOptions $options
     *
     * @return bool
     */
    protected function isOverMaxExecutionTime($options)
    {
        if ($options->maxExecutionTime <= 0) {
            return false;
        }

        $elapsedTime = microtime(true) - LARAVEL_START;

        return $elapsedTime > $options->maxExecutionTime;
    }

    /**
     * Get the size of the queue.
     *
     * @param string $connectionName
     * @param string $queue
     *
     * @return int
     */
    protected function getSize($connectionName, $queue)
    {
        return $this->worker->getManager()->connection($connectionName)->size($queue);
    }
}
