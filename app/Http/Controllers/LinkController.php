<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class LinkController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');        
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $links=\App\Link::user()        
        ->select('links.*', \DB::raw('(SELECT COUNT(*) FROM link_logs lg WHERE lg.link_id = links.id) AS nb_click'))
        ->latest()
        ->get();
        return view('links.index',compact('links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('links.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $validatedData = $request->validate([
            'url' => ['required', 'active_url', new \App\Rules\LinkLimits]
        ]);

        $link= new \App\Link;
        $link->url=$request->get('url');
        $link->user_id = \Auth::user()->id;
        $link->save();
        
        return redirect('links')->with('success', trans('messages.operation_done'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $link = \App\Link::user()->find($id);
        return view('links.edit',compact('link'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $link = \App\Link::user()->find($id);
        $validatedData = $request->validate([
            'url' => ['required', 'active_url']           
        ]);
        $link->url=$request->get('url');
        $link->save();
        return redirect('links')->with('success',trans('messages.operation_done'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $link = \App\Link::user()->find($id);
        $link->delete();
        return redirect('links')->with('success',trans('messages.operation_done'));
    }
}
