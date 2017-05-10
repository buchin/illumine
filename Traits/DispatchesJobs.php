<?php
namespace Illumine\Framework\Traits;
trait DispatchesJobs
{
    /**
     * Dispatch a job to its appropriate handler.
     *
     * @param  mixed  $job
     * @return mixed
     */
    protected function dispatch($job)
    {
        return $this->plugin->make(Dispatcher::class)->dispatch($job);
    }
    /**
     * Dispatch a command to its appropriate handler in the current process.
     *
     * @param  mixed  $job
     * @return mixed
     */
    public function dispatchNow($job)
    {
        return $this->plugin->make(Dispatcher::class)->dispatchNow($job);
    }
}