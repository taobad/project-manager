<?php

namespace Modules\Files\Http\Controllers;

use App\Http\Controllers\Controller;
use Filestack\Filelink;
use Illuminate\Http\Request;
use Modules\Files\Entities\FileUpload;
use Modules\Files\Helpers\Uploader;
use Modules\Files\Http\Requests\UploadRequest;

class SummernoteController extends Controller
{
    /**
     * Request instance
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;
    /**
     * Uploader helper
     *
     * @var \Modules\Files\Helpers\Uploader
     */
    protected $uploader;

    public function __construct(Request $request, Uploader $uploader)
    {
        $this->middleware(['auth', 'verified', '2fa']);
        $this->request  = $request;
        $this->uploader = $uploader;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function imageUpload()
    {
        $url = '';

        if ($this->request->ajax()) {
            if ($this->request->hasFile('file')) {
                $file = $this->request->file('file');
                $store = $file->store('public/summer-uploads');
                $url = \Storage::url('public/summer-uploads/'.$this->request->file->hashName());
            }
            // Includes domain $this->request->root() . '/' . $url
            return response()->json($url, 200, [], JSON_UNESCAPED_SLASHES);
        }

        return \App::abort(404);
    }

    /**
     * Save file
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(UploadRequest $request)
    {
        if (!empty($request->filestack)) {
            $files = json_decode($request->filestack);
            if (count($files)) {
                foreach ($files as $file) {
                    $this->uploadFilestack($file, $request);
                }
            }
        }
        if ($request->hasFile('uploads')) {
            $this->makeUploads($request);
        }
        $data['message']  = langapp('saved_successfully');
        $data['redirect'] = url()->previous();

        return ajaxResponse($data);
    }

    protected function makeUploads($request)
    {
        return $this->uploader->save('uploads/' . $request->module, $request);
    }
}
