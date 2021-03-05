<?php

namespace Modules\Projects\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Projects\Entities\Link;
use Modules\Projects\Http\Requests\LinkRequest;

class LinkController extends Controller
{
    protected $links;
    protected $request;
    /**
     * Create a new controller instance.
     */
    public function __construct(Request $request, Link $link)
    {
        $this->middleware(['auth', 'verified', '2fa']);
        $this->request = $request;
        $this->links   = $link;
    }

    public function edit(Link $link)
    {
        $data['link'] = $link;

        return view('projects::modal.links.update')->with($data);
    }

    public function update(LinkRequest $request, Link $link)
    {
        $link->update($request->all());
        $data['message']  = langapp('changes_saved_successful');
        $data['redirect'] = route('projects.view', ['project' => $link->project->id, 'tab' => 'links', 'item' => $link->id]);

        return ajaxResponse($data);
    }

    public function save(LinkRequest $request)
    {
        $link = $this->links->create($request->all());

        $data['message']  = langapp('changes_saved_successful');
        $data['redirect'] = route('projects.view', ['project' => $link->project->id, 'tab' => 'links']);

        return ajaxResponse($data);
    }

    public function pin(Link $link)
    {
        $client = $link->project->client_id;

        if ($link->client_id > 0) {
            $link->update(['client_id' => 0]);
            $message = langapp('link_unpinned_successfully');
        } else {
            $link->update(['client_id' => $client]);
            $message = langapp('link_pinned_successfully');
        }
        toastr()->info($message, langapp('response_status'));

        return redirect(route('projects.view', ['project' => $link->project->id, 'tab' => 'links']));
    }

    public function delete(Link $link)
    {
        $data['link'] = $link;

        return view('projects::modal.links.delete')->with($data);
    }

    public function destroy(Request $request, Link $link)
    {
        $link->delete();
        toastr()->warning(langapp('deleted_successfully'), langapp('response_status'));

        return redirect($request->url);
    }
}
