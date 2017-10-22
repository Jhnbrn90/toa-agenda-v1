<?php
namespace App\Classes;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Jobs\DeleteAttachedFiles;


class AttachmentHandler {


    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function uploadAttachment() {
        if($this->request->hasFile('file')) {
            foreach($this->request->file as $file) {
                $this->filepath[] = $file->store('attachments');
            }
        } else {
            $this->filepath = null;
        }
        return $this->filepath;
    }

    public function deleteAttachments()
    {

        if($this->request->hasFile('file')) {
            DeleteAttachedFiles::dispatch($this->filepath)->delay(Carbon::now()->addMinutes(5));
        }

    }
}
