<?php

namespace Gourmet\Filters\Routing\Filter;

use Cake\Event\Event;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Routing\DispatcherFilter;

class RobotsFilter extends DispatcherFilter
{
    public function __construct($config = [])
    {
        $config += [
            'key' => 'APP_ENV',
            'value' => 'production',
        ];

        if (empty($config['when'])) {
            $config['when'] = function(Request $request) use ($config) {
                return $request->env($config['key']) === $config['value'];
            };
        }

        parent::__construct($config);
    }

    public function beforeDispatch(Event $event)
    {
        if ($event->data['request']->url !== 'robots.txt') {
            return;
        }

        $event->stopPropagation();
        return new Response([
            'body' => "User-Agent: *\nDisallow: /",
            'status' => 200,
            'type' => 'txt',
        ]);
    }

    public function afterDispatch(Event $event)
    {
        $event->data['response']->header('X-Robots-Tag', 'noindex, nofollow, noarchive');
    }
}
