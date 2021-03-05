<?php

namespace Modules\Contracts\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Contracts\Entities\Contract;
use Modules\Contracts\Entities\ContractTemplate;

class ContractsController extends Controller
{
    /**
     * Page name
     *
     * @var string
     */
    protected $page;
    /**
     * Request instance
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;
    /**
     * Contract model
     *
     * @var \Modules\Contracts\Entities\Contract
     */
    protected $contract;

    public function __construct(Request $request)
    {
        $this->middleware(['auth', 'verified', '2fa', 'can:menu_contracts']);
        $this->request  = $request;
        $this->contract = new Contract;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data['sign'] = true;
        $data['page'] = $this->getPage();
        //$data['contracts'] = $this->getContracts();

        return view('contracts::index')->with($data);
    }
    /**
     * Show contract create page
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data['page'] = $this->getPage();

        return view('contracts::create')->with($data);
    }
    /**
     * Show edit contract page
     *
     * @param  \Modules\Contracts\Entities\Contract $contract
     * @return \Illuminate\View\View
     */
    public function edit(Contract $contract)
    {
        $data['page']     = $this->getPage();
        $data['contract'] = $contract;

        return view('contracts::update')->with($data);
    }
    /**
     * View contract page
     *
     * @param  \Modules\Contracts\Entities\Contract $contract
     * @return \Illuminate\View\View
     */
    public function view(Contract $contract)
    {
        $data['page']     = $this->getPage();
        $data['contract'] = $contract;
        $data['sign']     = true;

        return view('contracts::view')->with($data);
    }
    // Show contract activities
    public function activity(Contract $contract)
    {
        $data['page']       = $this->getPage();
        $data['activities'] = $contract->activities;

        return view('partial.activity')->with($data);
    }
    // Sign and send a contract
    public function send(Contract $contract)
    {
        $data['page']     = $this->getPage();
        $data['contract'] = $contract;
        return view('contracts::modal.sign')->with($data);
    }
    // Send contract reminder
    public function remind(Contract $contract)
    {
        $data['page']     = $this->getPage();
        $data['contract'] = $contract;

        return view('contracts::modal.remind')->with($data);
    }
    // Share contract link
    public function share($id)
    {
        $data['page'] = $this->getPage();
        $data['id']   = $id;

        return view('contracts::modal.share')->with($data);
    }

    /**
     * View contract templates
     *
     * @return \Illuminate\View\View
     */
    public function templates()
    {
        $data['page'] = $this->getPage();

        return view('contracts::templates')->with($data);
    }
    /**
     * Save contract template
     */
    public function saveTemplate()
    {
        $this->request->validate(['name' => 'required', 'body' => 'required']);
        $template = ContractTemplate::create($this->request->all());

        return ajaxResponse(
            [
                'message'  => langapp('saved_successfully'),
                'redirect' => route('contracts.templates'),
            ],
            true,
            Response::HTTP_CREATED
        );
    }
    /**
     * Edit contract template
     *
     * @return \Illuminate\View\View
     */
    public function editTemplate(ContractTemplate $template)
    {
        $data['page']     = $this->getPage();
        $data['template'] = $template;
        return view('contracts::edit_template')->with($data);
    }

    public function updateTemplate(ContractTemplate $template)
    {
        $this->request->validate(['name' => 'required', 'body' => 'required']);
        $template->update($this->request->all());
        $data['message']  = langapp('changes_saved_successful');
        $data['redirect'] = route('contracts.templates');

        return ajaxResponse($data);
    }

    /**
     * Delete contract template
     */
    public function deleteTemplate($id = null)
    {
        Contract::where('template_id', $id)->update(['template_id' => 1]);
        $template = ContractTemplate::findOrFail($id);
        $template->delete();
        return ajaxResponse(
            [
                'message'  => langapp('deleted_successfully'),
                'redirect' => route('contracts.templates'),
            ],
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Show Duplicate contract modal
     */
    public function copy(Contract $contract)
    {
        $data['contract'] = $contract;

        return view('contracts::modal.copy')->with($data);
    }

    // Download contract as PDF
    public function pdf(Contract $contract)
    {
        if (isset($contract->id)) {
            return $contract->pdf();
        }
        abort(404);
    }
    // Show contract delete modal
    public function delete(Contract $contract)
    {
        $data['contract'] = $contract;

        return view('contracts::modal.delete')->with($data);
    }

    public function getContracts()
    {
        switch ($this->request->filter) {
            case 'viewed':
                return $this->contract->viewed()->orderBy('id', 'desc')->get();
                break;
            case 'draft':
                return $this->contract->isDraft()->orderBy('id', 'desc')->get();
                break;
            case 'signed':
                return $this->contract->done()->orderBy('id', 'desc')->get();
                break;
            case 'sent':
                return $this->contract->sent()->orderBy('id', 'desc')->get();
                break;
            case 'expired':
                return $this->contract->expired()->orderBy('id', 'desc')->get();
                break;

            default:
                return $this->contract->where('signed', '0')->orderBy('id', 'desc')->get();
                break;
        }
    }

    public function getPage()
    {
        return langapp('contracts');
    }
}
