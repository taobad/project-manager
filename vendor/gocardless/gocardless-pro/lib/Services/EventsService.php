<?php
/**
 * WARNING: Do not edit by hand, this file was generated by Crank:
 *
 * https://github.com/gocardless/crank
 */

namespace GoCardlessPro\Services;

use \GoCardlessPro\Core\Paginator;
use \GoCardlessPro\Core\Util;
use \GoCardlessPro\Core\ListResponse;
use \GoCardlessPro\Resources\Event;
use \GoCardlessPro\Core\Exception\InvalidStateException;


/**
 * Service that provides access to the Event
 * endpoints of the API
 *
 * @method list()
 * @method get()
 */
class EventsService extends BaseService
{

    protected $envelope_key   = 'events';
    protected $resource_class = '\GoCardlessPro\Resources\Event';


    /**
     * List events
     *
     * Example URL: /events
     *
     * @param  string[mixed] $params An associative array for any params
     * @return ListResponse
     **/
    protected function _doList($params = array())
    {
        $path = "/events";
        if(isset($params['params'])) { $params['query'] = $params['params'];
            unset($params['params']);
        }

        
        $response = $this->api_client->get($path, $params);
        

        return $this->getResourceForResponse($response);
    }

    /**
     * Get a single event
     *
     * Example URL: /events/:identity
     *
     * @param  string        $identity Unique identifier, beginning with "EV".
     * @param  string[mixed] $params   An associative array for any params
     * @return Event
     **/
    public function get($identity, $params = array())
    {
        $path = Util::subUrl(
            '/events/:identity',
            array(
                
                'identity' => $identity
            )
        );
        if(isset($params['params'])) { $params['query'] = $params['params'];
            unset($params['params']);
        }

        
        $response = $this->api_client->get($path, $params);
        

        return $this->getResourceForResponse($response);
    }

    /**
     * List events
     *
     * Example URL: /events
     *
     * @param  string[mixed] $params
     * @return Paginator
     **/
    public function all($params = array())
    {
        return new Paginator($this, $params);
    }

}
