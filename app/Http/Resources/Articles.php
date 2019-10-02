<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Articles extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request); default api
        //custom api
        return[
            'id'=> $this->id,
            'title'=>$this->title,
            'body'=> $this->body
        ];
    }
    public function with($request){
       return[
            'version' =>'0.0.1',
            'power_by'=> url('www.genmyanmar.org')
       ];
    }
}
