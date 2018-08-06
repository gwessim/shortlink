<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Link extends Model
{
    use SoftDeletes;

     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    public function getShortURLAttribute()
    {
        if (!$this->id) return null;
        return rtrim(strtr(base64_encode(pack('C*',$this->id)), '+/', '-_'), '=');        
    }

    public static function convertShortLinkToId($shortLink)
    {        
        $s = base64_decode(str_pad(strtr($shortLink, '-_', '+/'), true));
        $s = unpack('C*',$s);        
        if (is_array($s)) 
            return array_pop($s);
    }

    public function scopeUser($query)
    {
        return $query->where('links.user_id','=',\Auth::user()->id)
        ->where('links.created_at','>=', Carbon::now()->subMinutes(3600*24)->toDateTimeString() );
    }
    

}
