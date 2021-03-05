<section class="bg chat-list panel-body">
    <section class="panel panel-default">
        @widget('Chats\CreateSmsWidget', ['chatable_type' => 'users' , 'chatable_id' => $contact->id, 'cannedResponse' => true])
        
    </section>
    @asyncWidget('Chats\Sms', ['chatable_id' => $contact->id, 'chatable_type' => 'users'])
    
</section>



@include('extras::_ajax.ajaxify_chat')