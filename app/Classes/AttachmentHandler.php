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
        // upload the files if there are any
        if($this->request->hasFile('file')) {
            foreach($this->request->file as $file) {
                $this->filepath[] = $file->store('attachments');
            }
        } else {
            $this->filepath = null;
        }

        // set a timer to delete the files from the server
        $this->deleteAttachments();

        // return the filepath array
        return $this->filepath;
    }

    public function deleteAttachments()
    {

        if($this->request->hasFile('file')) {
            DeleteAttachedFiles::dispatch($this->filepath)->delay(Carbon::now()->addMinutes(5));
        }

    }
}
