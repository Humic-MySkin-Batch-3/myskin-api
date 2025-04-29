<?php
namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;


class DashboardStatsResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'totalPatients' => $this['totalPatients'],
            'pending'       => $this['pendingCount'],
            'verified'      => $this['verifiedCount'],
        ];
    }
}
