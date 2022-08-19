<?php

namespace App\Repository\Ticketing\UploadFile;

use App\Repository\Ticketing\UploadFile\Interfaces\UploadFileInterfaces;
use Illuminate\Support\Facades\DB;
use App\Model\Ticketing\RequestTicketingHeader as Header;

class UploadFileRepository implements UploadFileInterfaces
{
    public static function updateFileUpload($request)
    {
        DB::transaction(function () use ($request) {
            \Helper::instance()->log('UPDATE', $request, 'App\Model\Ticketing\RequestTicketingHeader');
            Header::where('ticket_id', $request->ticket_id)
                ->update($request->except('_token'));
        });
    }
}