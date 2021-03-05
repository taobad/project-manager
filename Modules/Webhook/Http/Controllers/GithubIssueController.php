<?php

namespace Modules\Webhook\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Issues\Entities\Issue;
use Modules\Projects\Entities\Project;
use Auth;

class GithubIssueController extends Controller
{
    protected $request;
    protected $payload;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->payload = json_decode($this->request->payload);
    }

    public function incoming($token = null)
    {
        $project      = Project::where('token', $token)->first();
        if (!isset($project->id)) {
            return abort(404);
        }
        $issueCreator = $project->assignees()->inRandomOrder()->first();
        Auth::onceUsingId($issueCreator->user_id);
        switch ($this->payload->action) {
            case 'opened':
                $this->openIssue($project, $issueCreator);
                break;
            case 'closed':
                $this->closeIssue($project, $issueCreator);
                break;
            case 'reopened':
                $this->reopenIssue($project, $issueCreator);
                break;
            case 'created':
                $this->commentIssue($project, $issueCreator);
                break;
            default:
                // code...
                break;
        }
        Auth::logout();
        return 'OK';
    }
    private function openIssue($project, $issueCreator)
    {
        $issue = $project->issues()->create(
            [
            'user_id'         => $issueCreator->user_id,
            'assignee'        => $issueCreator->user_id,
            'subject'         => $this->payload->issue->title,
            'reproducibility' => $this->payload->issue->body,
            'severity'        => langapp('major'),
            'priority'        => 'high',
            'description'     => 'Issue Url <br>'.$this->payload->issue->html_url.' posted by '.$this->payload->sender->login,
            'status'          => 1,
            'meta'            => [
                'url'       => $this->payload->issue->html_url,
                'repository'  => $this->payload->repository->full_name,
                'timestamp' => $this->payload->issue->created_at,
                'tags'      => $this->payload->issue->labels,
            ],
            ]
        );
        $issue->tag(['github']);
    }

    private function closeIssue($project, $issueCreator)
    {
        $issue = Issue::where('subject', $this->payload->issue->title)->first();
        if (isset($issue->id)) {
            $issue->update(['status' => 5, 'closed_at' => now()->toDateTimeString()]);
        }
    }
    private function reopenIssue($project, $issueCreator)
    {
        $issue = Issue::where('subject', $this->payload->issue->title)->first();
        if (isset($issue->id)) {
            $issue->update(['status' => 1, 'closed_at' => null]);
        }
    }
    private function commentIssue($project, $issueCreator)
    {
        if (isset($this->payload->comment)) {
            $issue = Issue::where('subject', $this->payload->issue->title)->first();
            if (isset($issue->id)) {
                $issue->comments()->create([
                    'user_id' => $issue->user_id,
                    'message' => $this->payload->comment->body.'<br>'.$this->payload->comment->html_url
                ]);
            }
        }
    }
}
