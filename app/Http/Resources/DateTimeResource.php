<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DateTimeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'human' => $this->diffForHumans(),
            'datetime' => $this->toDateTimeString(),
            'date' => $this->format('Y-m-d'),
            'fancy' => $this->format('F j, Y g:i A'),
            'fancy_day' => $this->format('l, F j, Y g:i A'),
            'fancy_date' => $this->format('l, F j, Y'),
        ];
    }
}
