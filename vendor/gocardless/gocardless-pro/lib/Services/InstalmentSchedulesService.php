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
use \GoCardlessPro\Resources\InstalmentSchedule;
use \GoCardlessPro\Core\Exception\InvalidStateException;


/**
 * Service that provides access to the InstalmentSchedule
 * endpoints of the API
 *
 * @method createWithDates()
 * @method createWithSchedule()
 * @method list()
 * @method get()
 * @method update()
 * @method cancel()
 */
class InstalmentSchedulesService extends BaseService
{

    protected $envelope_key   = 'instalment_schedules';
    protected $resource_class = '\GoCardlessPro\Resources\InstalmentSchedule';


    /**
     * Create (with dates)
     *
     * Example URL: /instalment_schedules
     *
     * @param  string[mixed] $params An associative array for any params
     * @return InstalmentSchedule
     **/
    public function createWithDates($params = array())
    {
        $path = "/instalment_schedules";
        if(isset($params['params'])) { 
            $params['body'] = json_encode(array($this->envelope_key => (object)$params['params']));
        
            unset($params['params']);
        }

        
        try {
            $response = $this->api_client->post($path, $params);
        } catch(InvalidStateException $e) {
            if ($e->isIdempotentCreationConflict()) {
                if ($this->api_client->error_on_idempotency_conflict) {
                    throw $e;
                }
                return $this->get($e->getConflictingResourceId());
            }

            throw $e;
        }
        

        return $this->getResourceForResponse($response);
    }

    /**
     * Create (with schedule)
     *
     * Example URL: /instalment_schedules
     *
     * @param  string[mixed] $params An associative array for any params
     * @return InstalmentSchedule
     **/
    public function createWithSchedule($params = array())
    {
        $path = "/instalment_schedules";
        if(isset($params['params'])) { 
            $params['body'] = json_encode(array($this->envelope_key => (object)$params['params']));
        
            unset($params['params']);
        }

        
        try {
            $response = $this->api_client->post($path, $params);
        } catch(InvalidStateException $e) {
            if ($e->isIdempotentCreationConflict()) {
                if ($this->api_client->error_on_idempotency_conflict) {
                    throw $e;
                }
                return $this->get($e->getConflictingResourceId());
            }

            throw $e;
        }
        

        return $this->getResourceForResponse($response);
    }

    /**
     * List instalment schedules
     *
     * Example URL: /instalment_schedules
     *
     * @param  string[mixed] $params An associative array for any params
     * @return ListResponse
     **/
    protected function _doList($params = array())
    {
        $path = "/instalment_schedules";
        if(isset($params['params'])) { $params['query'] = $params['params'];
            unset($params['params']);
        }

        
        $response = $this->api_client->get($path, $params);
        

        return $this->getResourceForResponse($response);
    }

    /**
     * Get a single instalment schedule
     *
     * Example URL: /instalment_schedules/:identity
     *
     * @param  string        $identity Unique identifier, beginning with "IS".
     * @param  string[mixed] $params   An associative array for any params
     * @return InstalmentSchedule
     **/
    public function get($identity, $params = array())
    {
        $path = Util::subUrl(
            '/instalment_schedules/:identity',
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
     * Update an instalment schedule
     *
     * Example URL: /instalment_schedules/:identity
     *
     * @param  string        $identity Unique identifier, beginning with "IS".
     * @param  string[mixed] $params   An associative array for any params
     * @return InstalmentSchedule
     **/
    public function update($identity, $params = array())
    {
        $path = Util::subUrl(
            '/instalment_schedules/:identity',
            array(
                
                'identity' => $identity
            )
        );
        if(isset($params['params'])) { 
            $params['body'] = json_encode(array($this->envelope_key => (object)$params['params']));
        
            unset($params['params']);
        }

        
        $response = $this->api_client->put($path, $params);
        

        return $this->getResourceForResponse($response);
    }

    /**
     * Cancel an instalment schedule
     *
     * Example URL: /instalment_schedules/:identity/actions/cancel
     *
     * @param  string        $identity Unique identifier, beginning with "IS".
     * @param  string[mixed] $params   An associative array for any params
     * @return InstalmentSchedule
     **/
    public function cancel($identity, $params = array())
    {
        $path = Util::subUrl(
            '/instalment_schedules/:identity/actions/cancel',
            array(
                
                'identity' => $identity
            )
        );
        if(isset($params['params'])) { 
            $params['body'] = json_encode(array("data" => (object)$params['params']));
        
            unset($params['params']);
        }

        
        try {
            $response = $this->api_client->post($path, $params);
        } catch(InvalidStateException $e) {
            if ($e->isIdempotentCreationConflict()) {
                if ($this->api_client->error_on_idempotency_conflict) {
                    throw $e;
                }
                return $this->get($e->getConflictingResourceId());
            }

            throw $e;
        }
        

        return $this->getResourceForResponse($response);
    }

    /**
     * List instalment schedules
     *
     * Example URL: /instalment_schedules
     *
     * @param  string[mixed] $params
     * @return Paginator
     **/
    public function all($params = array())
    {
        return new Paginator($this, $params);
    }

}
