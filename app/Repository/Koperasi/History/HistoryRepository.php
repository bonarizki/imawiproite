<?php

namespace App\Repository\Koperasi\History;

use App\Model\Koperasi\OrderHeader;
use App\Repository\Koperasi\History\Interfaces\HistoryInterfaces;

class HistoryRepository implements HistoryInterfaces
{
    public static function getHistoryUser($user_nik)
    {
        return OrderHeader::where('user_nik',$user_nik)
            ->orderBy('order_header_id','desc')
            ->get();
    }
}