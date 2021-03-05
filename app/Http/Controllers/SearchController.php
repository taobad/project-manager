<?php

namespace App\Http\Controllers;

use App\Traits\Taggable;
use Illuminate\Http\Request;
use Modules\Clients\Entities\Client;
use Modules\Contracts\Entities\Contract;
use Modules\Creditnotes\Entities\CreditNote;
use Modules\Deals\Entities\Deal;
use Modules\Estimates\Entities\Estimate;
use Modules\Expenses\Entities\Expense;
use Modules\Invoices\Entities\Invoice;
use Modules\Issues\Entities\Issue;
use Modules\Knowledgebase\Entities\Knowledgebase;
use Modules\Leads\Entities\Lead;
use Modules\Milestones\Entities\Milestone;
use Modules\Payments\Entities\Payment;
use Modules\Projects\Entities\Project;
use Modules\Tasks\Entities\Task;
use Modules\Tickets\Entities\Ticket;
use Modules\Users\Entities\User;

class SearchController extends Controller
{
    use Taggable;

    protected $request;
    protected $searchTerm;
    protected $page;

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->request = $request;
        $this->searchTerm = $request->keyword;
    }

    public function search()
    {
        $this->request->validate(['keyword' => 'required']);
        $data['invoices'] = Invoice::whereLike(['reference_no', 'title', 'tags.name', 'company.name', 'billing_city', 'billing_country'], $this->searchTerm)->take(30)->get();
        $data['estimates'] = Estimate::whereLike(['reference_no', 'title', 'tags.name', 'company.name', 'billing_city', 'billing_country'], $this->searchTerm)->take(30)->get();
        $data['projects'] = Project::whereLike(['code', 'name', 'description', 'company.name'], $this->searchTerm)->take(30)->get();
        $data['contracts'] = Contract::whereLike(['contract_title', 'company.name', 'template.name'], $this->searchTerm)->take(30)->get();
        $data['credits'] = CreditNote::whereLike(['status', 'reference_no', 'company.name', 'billing_city', 'billing_country'], $this->searchTerm)->take(30)->get();
        $data['deals'] = Deal::whereLike(['title', 'contact.name', 'status', 'AsSource.name', 'pipe.name'], $this->searchTerm)->take(30)->get();
        $data['leads'] = Lead::whereLike(['name', 'agent.name', 'status.name', 'AsSource.name', 'job_title', 'company', 'email', 'city', 'country', 'rating_status'], $this->searchTerm)->take(30)->get();
        $data['expenses'] = Expense::whereLike(['company.name', 'code', 'vendor'], $this->searchTerm)->take(30)->get();
        $data['clients'] = Client::whereLike(['code', 'name', 'email', 'billing_city', 'billing_country', 'tax_number', 'billing_street'], $this->searchTerm)->take(30)->get();
        $data['issues'] = Issue::whereLike(['code', 'AsProject.name', 'AsStatus.status', 'subject', 'agent.name'], $this->searchTerm)->take(30)->get();
        $data['articles'] = Knowledgebase::whereLike(['subject', 'user.name', 'category.name'], $this->searchTerm)->take(30)->get();
        $data['payments'] = Payment::whereLike(['code', 'AsInvoice.reference_no', 'company.name', 'paymentMethod.method_name'], $this->searchTerm)->take(30)->get();
        $data['tasks'] = Task::whereLike(['name', 'AsProject.name', 'AsMilestone.milestone_name', 'AsCategory.name', 'user.name'], $this->searchTerm)->take(30)->get();
        $data['tickets'] = Ticket::whereLike(['code', 'subject', 'AsStatus.status', 'AsPriority.priority', 'agent.name', 'dept.deptname', 'user.name'], $this->searchTerm)->take(30)->get();
        $data['milestones'] = Milestone::whereLike(['milestone_name', 'AsProject.name'], $this->searchTerm)->take(30)->get();
        $data['users'] = User::whereLike(['name', 'email', 'profile.job_title', 'profile.city'], $this->searchTerm)->take(30)->get();
        $data['page'] = langapp('search');
        $data['keyword'] = $this->searchTerm;
        return view('searches')->with($data);
    }
}
