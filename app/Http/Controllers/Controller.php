<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class Controller extends BaseController
{    

    public function redirectShortLink(Request $request, $shortLink)
    {
        $linkId = \App\Link::convertShortLinkToId($shortLink);        
        if (!$linkId) return view('noredirect');
        $link = \App\Link::find($linkId);           
        if (!$link || $link->deleted_at || time()-$link->created_at->timestamp >= 3600 * 24) return view('noredirect');

        // Link Log
        $trace = new \App\LinkLog();
        $trace->link_id = $link->id;
        $trace->user_agent = $request->server('HTTP_USER_AGENT');
        $trace->ip = $request->ip();
        $trace->date = time();
        if (\Auth::user()) $trace->user_id = \Auth::user()->id;
        $location = geoip($request->ip());
        $trace->country = $location['iso_code'];
        $trace->save();

        return redirect()->to($link->url);
    }

    public function changeLocale(Request $request)
    {        
        $nl = \Session::get('locale')=='fr' ? 'en' : 'fr';        
        if (($user = \Auth::user())) {            
            $user->lang = $nl;
            $user->save();            
        }
        \Session::put('locale', $nl);
        \App::setLocale($nl);
        return redirect()->back();
    }
}
