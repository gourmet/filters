<?php

namespace Gourmet\Filters\Routing\Filter;

use Cake\Event\Event;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Routing\DispatcherFilter;

class IpFilter extends DispatcherFilter
{
    public function __construct($config = [])
    {
        $config += [
            'message' => 'Forbidden (%s)',
            'allow' => [],
            'disallow' => [],
        ];

        if (empty($config['when'])) {
            $config['when'] = function (Request $request) use ($config) {
                $ip = $request->clientIp();
                return !(
                    in_array($ip, $config['allow']) 
                    || !in_array($ip, $config['disallow'])
                );
            };
        }
        parent::__construct($config);
    }

    public function beforeDispatch(Event $event)
    {
        $event->stopPropagation();
        return new Response([
            'body' => sprintf($this->config('message'), $event->data['request']->clientIp()),
            'status' => 403,
        ]);
    }
}
