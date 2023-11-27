<?php

namespace App\Http\Controllers\core;

use App\Http\Controllers\Controller;
use App\Models\Translate;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TranslateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lang = LaravelLocalization::getCurrentLocale();
        $trans = new Translate();
        $trans->key = $lang;
        $trans->word = $request->word;
        $trans->translation = $request->translation;
        $trans->save();

        $notification = array(
			'message' => transWord('Translate created successfully !!'),
			'alert-type' => 'success'
		);

        return back()->with($notification);
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
    public function edit()
    {
        $lang = LaravelLocalization::getCurrentLocale();
        $langs = Translate::where('key',$lang)->get();
        // dd($langs);
        return view('pages.translates.edit', compact('langs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $lang = LaravelLocalization::getCurrentLocale();
        if (isset($request->trans)) {
            for ($i=0; $i < count($request->trans); $i++) {
                $trans = Translate::where('id',$request->ids[$i])->where('key',$lang)->get()->first();
                $trans->translation = $request->trans[$i];
                $trans->save();
            }
        }

        $notification = array(
			'message' => transWord('Translate updated successfully !!'),
			'alert-type' => 'success'
		);

        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Translate::findOrFail($id)->delete();

        $notification = array(
			'message' => transWord('Translate deleted successfully !!'),
			'alert-type' => 'success'
		);

        return back()->with($notification);
    }
}
