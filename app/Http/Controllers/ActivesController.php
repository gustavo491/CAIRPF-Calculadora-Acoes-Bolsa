<?php

namespace App\Http\Controllers;

use App\Models\Actives;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ActivesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actives = actives::get();
        return view('active', ['actives' => $actives]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active = new \stdClass;
        $active->title = "active.add_active";
        $active->action = "form.add";
        $active->route = 'save-active';

        return view('active-form', ['active' => $active]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $active = new actives;
        $active->uuid = Str::uuid();

        $formData = $request->all();

        foreach($formData as $column => $data) {
            if($column != "_token"){
                $active->$column  = $data;
            }
        }

        if($active->save()){
            return redirect()->route('actives')->with('message',  ['message' => __('form.register_success'), 'class' => 'success']);
        } else{
            return redirect()->route('actives')->with('message',  ['message' => __('form.register_error'), 'class' => 'error']);
        }
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
    public function edit($uuid)
    {
        $active = actives::where('uuid', $uuid)->firstOrFail();
        
        if(!empty($active)) {
            $active->title = "active.edit_active";
            $active->action = "form.edit";
            $active->route = "update-active";
        } else {
            return redirect()->route('actives')->with('message',  ['message' => __('form.register_undefined'), 'class' => 'error']);
        }
        return view('active-form', ['active' => $active]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        $formData = $request->all();
        $active = new Actives;

        unset($formData['_token']);

        if($active::where('uuid', $uuid)->update($formData)) {
            return redirect()->route('actives')->with('message',  ['message' => __('form.update_success'), 'class' => 'success']);
        } else{
            return redirect()->route('actives')->with('message',  ['message' => __('form.update_error'), 'class' => 'error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    **/
    public function destroy($uuid)
    {
        if (actives::where('uuid', $uuid)->delete()) {
            return redirect()->route('actives')->with('message',  ['message' => __('form.delete_success'), 'class' => 'success']);
        } else{
            return redirect()->route('actives')->with('message',  ['message' => __('form.delete_error'), 'class' => 'error']);
        }
    }
}
