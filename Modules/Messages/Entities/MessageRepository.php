<?php

namespace Modules\Messages\Entities;

use Modules\Messages\Entities\Message;
use SebastianBerc\Repositories\Repository;

class MessageRepository extends Repository
{
    public function takeModel()
    {
        return Message::class;
    }

    public function deleteMessages($conversationId)
    {
        $delete = Message::where('conversation_id', $conversationId)->delete();
        if ($delete) {
            return true;
        }

        return false;
    }

    public function softDeleteMessage($messageId, $authUserId)
    {
        $message = $this->with(
            ['conversation' => function ($qry) use ($authUserId) {
                $qry->where('user_one', $authUserId);
                $qry->orWhere('user_two', $authUserId);
            }]
        )->find($messageId);

        if (is_null($message->conversation)) {
            return false;
        }

        if ($message->user_id == $authUserId) {
            $message->deleted_from_sender = 1;
        } else {
            $message->deleted_from_receiver = 1;
        }

        return (boolean) $this->update($message);
    }
}
