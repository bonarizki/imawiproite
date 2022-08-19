<?php

namespace App\Services\Ticketing;

use App\Helper\HelperService;
use App\Repository\Ticketing\UploadFile\Interfaces\UploadFileInterfaces;

class UploadFileService
{
    public $HelperService;
    public $UploadFileInterfaces;
    public $array_it_po;
    public $path;

    public function __construct(HelperService $HelperService,UploadFileInterfaces $UploadFileInterfaces)
    {
        $this->HelperService = $HelperService;
        $this->array_it_po = [
            "offering",
            "capex",
            "po",
            "pr"
        ];
        $this->path = public_path('file_uploads/ticketing/file_uploads');
        $this->UploadFileInterfaces = $UploadFileInterfaces;
    }

    public function handle($request)
    {
        if ($request->type == 'it_po') {
            $request = $this->it_po($request);
            $newRequest = \Helper::instance()->MakeRequest($request);
        }

        return $this->UploadFileInterfaces->updateFileUpload($newRequest);
    }

    public function it_po($request)
    {
        $file = $this->array_it_po;

        $obj = [];

        $files_data = $request->file();

        for ($i=0; $i < count($file) ; $i++) { 
            if (isset($files_data[$file[$i]])) { //cek adakah paramater file di request
                $data = $files_data[$file[$i]]; //variabel yang berisi array file
                $file_name = []; //variabel yang akan digunakan untuk menampung namafile
                $array = [];
                for ($x=0; $x < count($data) ; $x++) { 
                    $data[$x]->move($this->path ."/it_po",$data[$x]->getClientOriginalName()); // proses upload file to folder server
                    array_push($file_name,$data[$x]->getClientOriginalName()); //push nama file ke dalam sebuah array
                }
                $obj = array_merge([$file[$i] => $file_name],$obj);
            }else{
                $obj = array_merge([$file[$i] => []],$obj);
            }

        }
        return [
            "ticket_id" => $request->id,
            "file_upload" => json_encode(json_decode(json_encode($obj)))
        ];

    }
}