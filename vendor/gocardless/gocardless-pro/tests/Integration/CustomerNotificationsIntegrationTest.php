<?php
//
// WARNING: Do not edit by hand, this file was generated by Crank:
// https://github.com/gocardless/crank
//

namespace GoCardlessPro\Integration;

class CustomerNotificationsIntegrationTest extends IntegrationTestBase
{
    public function testResourceModelExists()
    {
        $obj = new \GoCardlessPro\Resources\CustomerNotification(array());
        $this->assertNotNull($obj);
    }
    
    public function testCustomerNotificationsHandle()
    {
        $fixture = $this->loadJsonFixture('customer_notifications')->handle;
        $this->stub_request($fixture);

        $service = $this->client->customerNotifications();
        $response = call_user_func_array(array($service, 'handle'), (array)$fixture->url_params);

        $body = $fixture->body->customer_notifications;
    
        $this->assertInstanceOf('\GoCardlessPro\Resources\CustomerNotification', $response);

        $this->assertEquals($body->action_taken, $response->action_taken);
        $this->assertEquals($body->action_taken_at, $response->action_taken_at);
        $this->assertEquals($body->action_taken_by, $response->action_taken_by);
        $this->assertEquals($body->id, $response->id);
        $this->assertEquals($body->links, $response->links);
        $this->assertEquals($body->type, $response->type);
    

        $expectedPathRegex = $this->extract_resource_fixture_path_regex($fixture);
        $dispatchedRequest = $this->history[0]['request'];
        $this->assertRegExp($expectedPathRegex, $dispatchedRequest->getUri()->getPath());
    }

    
}
