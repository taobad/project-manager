<?php

namespace Modules\Calendar\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Calendar\Entities\Calendar;
use Modules\Users\Entities\User;

class FeedController extends Controller
{
    /**
     * Calendar feeds
     *
     * @param  string $token
     * @return mixed
     */
    public function feed($token = null)
    {
        $user = User::select('id')->whereCalendarToken($token)->first();
        if (isset($user->id)) {
            $vCalendar = new \Eluceo\iCal\Component\Calendar(url('/'));

            foreach (Calendar::whereUserId($user->id)->orWhere('is_private', 0)->get() as $event) {
                $vEvent = new \Eluceo\iCal\Component\Event();
                $vAlarm = new \Eluceo\iCal\Component\Alarm();
                $vAlarm->setAction('DISPLAY');
                $vAlarm->setTrigger('-PT' . $event->alert . 'M'); // X Minutes before event starts
                $vAlarm->setDescription($event->event_name);

                $vEvent
                    ->setDtStart(new \DateTime($event->start_date))
                    ->setDtEnd(new \DateTime($event->end_date))
                    ->setNoTime(false)
                    ->setUseUtc(false)
                    ->setDescription($event->description)
                    ->setUrl(route('calendar.index'))
                    ->setSummary($event->event_name);
                $vEvent->addComponent($vAlarm);
                $vCalendar->addComponent($vEvent);
            }

            header('Content-Type: text/calendar; charset=utf-8');
            header('Content-Disposition: attachment; filename="cal.ics"');
            echo $vCalendar->render();
            exit;
        }
    }
}
