<div class="flex flex-col">
    @if ($projects->count())
    <div class="flex items-center justify-between px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
        <div class="text-gray-600">
            Per Page: &nbsp;
            <select wire:model="perPage" class="py-2 pr-2">
                <option>10</option>
                <option>15</option>
                <option>25</option>
            </select>
        </div>
        <div class="flex justify-between flex-1 sm:justify-end">
            <div class="relative md:w-1/3">
                <input wire:model="search" class="w-full py-2 pl-10 pr-2 font-medium text-gray-600 rounded-lg shadow focus:outline-none focus:shadow-outline" type="text"
                    placeholder="Search Invoices...">
                <div class="absolute top-0 left-0 inline-flex items-center p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                        <circle cx="10" cy="10" r="7" />
                        <line x1="21" y1="21" x2="15" y2="15" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <div class="py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
        <div class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                            <a wire:click.prevent="sortBy('code')" role="button" href="#">
                                @langapp('code')
                                @include('partial._sort-icon', ['field' => 'code'])
                            </a>
                        </th>

                        <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                            <a wire:click.prevent="sortBy('progress')" role="button" href="#">
                                @langapp('progress')
                                @include('partial._sort-icon', ['field' => 'progress'])
                            </a>
                        </th>
                        <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                            <a wire:click.prevent="sortBy('start_date')" role="button" href="#">
                                @langapp('start_date')
                                @include('partial._sort-icon', ['field' => 'start_date'])
                            </a>
                        </th>
                        <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                            <a wire:click.prevent="sortBy('due_date')" role="button" href="#">
                                @langapp('due_date')
                                @include('partial._sort-icon', ['field' => 'due_date'])
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                    <tr class="bg-white">
                        <td class="px-6 py-4 text-sm font-medium leading-5 border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="ml-4">
                                    <div class="text-sm font-semibold leading-5 truncate">
                                        <a href="{{ route('projects.view', $project->id) }}" class="{{themeLinks()}}">
                                            {{ $project->code }}
                                        </a>
                                    </div>
                                    <div class="text-xs leading-5 text-gray-700">
                                        {{ str_limit($project->name,25) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-gray-700 border-b border-gray-200">
                            <span class="py-1 px-2 {{themeBg()}} text-white rounded-md text-xs">{{$project->progress}}%</span>
                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-gray-700 border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="ml-4">
                                    <div class="text-sm font-semibold leading-5 text-gray-600">
                                        {{ $project->start_date->toFormattedDateString()}}
                                    </div>
                                    @can('projects_view_expenses')
                                    <div class="text-xs leading-5 text-gray-700">
                                        @langapp('expenses') : {{ formatCurrency($project->currency, $project->total_expenses) }}
                                    </div>
                                    @endcan

                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-gray-500 border-b border-gray-200">
                            <div class="ml-4">
                                <div class="text-sm font-semibold leading-5 text-gray-600">
                                    {{ dateString($project->due_date)}}
                                </div>
                                <div class="text-xs leading-5 text-gray-700">
                                    @langapp('status') : {{$project->status}}
                                </div>
                            </div>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="px-4 py-2 text-gray-600">
                {{ $projects->links() }}
            </div>
        </div>
    </div>
    @else

    <div class="px-4 py-3">
        <p class="text-base text-gray-600">
            You have no pending projects
        </p>
    </div>
    @endif
</div>