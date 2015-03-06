<?php

namespace Gourmet\Filters\Routing\Filter;

use Cake\Event\Event;
use Cake\Network\Response;
use Cake\Routing\DispatcherFilter;

class MaintenanceFilter extends DispatcherFilter
{
    public function __construct($config = [])
    {
        $config += [
            'priority' => 1,
            'path' => ROOT . DS . 'maintenance.html',
        ];

        if (empty($config['when'])) {
            $config['when'] = function() use ($config) {
                return file_exists($config['path']);
            };
        }

        parent::__construct($config);
    }

    public function beforeDispatch(Event $event)
    {
        $event->stopPropagation();
        return new Response([
            'body' => file_get_contents($this->config('path')),
            'status' => 503,
        ]);
    }
}
