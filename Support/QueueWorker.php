<?php namespace Illumine\Framework\Support;
use Illuminate\Queue\WorkerOptions;

class QueueWorker
{
    public $plugin, $worker, $options, $connection, $startTime, $currentTime, $itemProcessed, $items;

    public function __construct($plugin)
    {
        $this->plugin = $plugin;
        $this->worker = $this->plugin['queue.worker'];
        $this->startTime = microtime(true);
        $this->currentTime = $this->startTime;
        $this->itemProcessed = 0;
        $this->showConsole = false;
        $this->items = array();
        $this->options('database');
    }

    public function options($connection, $delay = 0, $memory = 128, $timeout = 2, $sleep = 1, $maxTries = 0, $force = false)
    {
        $this->connection = $connection;
        $this->options = new WorkerOptions($delay, $memory, $timeout, $sleep, $maxTries, $force);
        return $this;
    }


    public function queueSize()
    {
        return $this->worker->getManager()->connection($this->connection)->size();
    }

    public function showConsole()
    {
        $this->showConsole = true;
        return $this;
    }

    public function run()
    {
        if($this->showConsole == true){
            echo '<p><em>QueueWorker()</em> Starting...</p> ';
        }
        $this->process();

        if($this->showConsole == true) {

            ?>
            <style type="text/css">

                body {
                    background: #000;
                    padding: 10px;
                    font-family: courier, serif;
                    font-size: 14px;
                    color: #fff;

                }

                span {
                    color: #0fBA06
                }
                span#countdown {
                    color: yellow
                }
                em {
                    color: lime;
                }

                p {
                    color: white;
                }

                p:before {
                    content: "$illumine ";
                    color: #1cc9e9;
                }

                p:after {
                    content: ".";
                    color: white;
                }

                p:last-of-type:after {
                    content: " █";
                    color: #1cc9e9;
                    -webkit-animation: glowing 1s infinite;
                    -moz-animation: glowing 1s infinite;
                    -ms-animation: glowing 1s infinite;
                }

                /* First, create the keyframes behavior */

                @-webkit-keyframes glowing {
                    0% {
                        color: #1cc9e9;
                    }
                    50% {
                        color: transparent;
                    }
                    100% {
                        color: #1cc9e9;
                    }
                }

                @-moz-keyframes glowing {
                    0% {
                        color: #1cc9e9;
                    }
                    50% {
                        color: transparent;
                    }
                    100% {
                        color: #1cc9e9;
                    }
                }

                @-ms-keyframes glowing {
                    0% {
                        color: #1cc9e9;
                    }
                    50% {
                        color: transparent;
                    }
                    100% {
                        color: #1cc9e9;
                    }
                }

            </style>
            <?php

                if ($this->queueSize() > 0) {
                    echo '<p><em>QueueWorker()</em> ' . $this->itemProcessed . ' jobs processed, ' . $this->queueSize() . '  remaining.</p>';
                } elseif ($this->itemProcessed > 1) {
                    echo '<p><em>QueueWorker()</em>  All jobs complete.</p>';
                } else {
                    echo '<p><em>QueueWorker()</em>  No jobs to process.</p>';
                }

                if($this->queueSize() > 0){
                    echo '<p><em>QueueWorker()</em>  <span>Continuing work...</span></p>';
                    ?>
                    <script type="text/javascript">
                        location.reload();
                    </script>
                    <?php
                }else{
                    echo '<p><em>QueueWorker()</em>  Resting state... resuming in <span id="countdown">60</span> secs.</p>';
                    ?>
                    <script type="text/javascript">
                        (function countdown(remaining) {
                            if(remaining <= 0){
                                document.getElementById('countdown').innerHTML = 'refreshing...';
                                location.reload();
                            }
                            document.getElementById('countdown').innerHTML = remaining;
                            setTimeout(function(){ countdown(remaining - 1); }, 1000);
                        })(60);
                    </script>
                    <?php
                }
        }
    }
    public function process(){

        while(
            //Queue Has Items
            ($this->queueSize() > 0)

            //Queue Memory Not Exceeded
            && !$this->worker->memoryExceeded($this->options->memory)

            //Timeout Not Reached
            && ($this->options->timeout > number_format($this->currentTime,0))
        ){
            //Process Next Queue Item
            $this->worker->runNextJob('database', 'default', $this->options);
            $this->itemProcessed++;

            //Update Time
            $this->currentTime = microtime(true) - $this->startTime;

            if($this->showConsole) {
                echo '<p>...completed in ' . number_format($this->currentTime, 3) . ' secs</p>';
            }
        }

    }
}