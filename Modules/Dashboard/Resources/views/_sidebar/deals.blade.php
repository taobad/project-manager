@widget('Activities\Feed', ['activities' => Modules\Activity\Entities\Activity::whereIn('actionable_type', [Modules\Deals\Entities\Deal::class, Modules\Leads\Entities\Lead::class])->with('user:id,username,name')->latest()->take(50)->get(), 'view' => 'dashboard'])
