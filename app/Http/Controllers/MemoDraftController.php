<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MemoDraft;


/**
 * Description of MemoDraftController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class MemoDraftController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('pages.memo_drafts.index', ['records' => MemoDraft::paginate(10)]);
    }    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  MemoDraft  $memodraft
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, MemoDraft $memodraft)
    {
        return view('pages.memo_drafts.show', [
                'record' =>$memodraft,
        ]);

    }    /**
     * Show the form for creating a new resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        return view('pages.memo_drafts.create', [
            'model' => new MemoDraft,

        ]);
    }    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model=new MemoDraft;
        $model->id = newId();
        $model->fill($request->all());

        if ($model->save()) {
            
            session()->flash('app_message', 'MemoDraft saved successfully');
            return redirect()->route('memo_drafts.index');
            } else {
                session()->flash('app_message', 'Something is wrong while saving MemoDraft');
            }
        return redirect()->back();
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  MemoDraft  $memodraft
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, MemoDraft $memodraft)
    {

        return view('pages.memo_drafts.edit', [
            'model' => $memodraft,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Request  $request
     * @param  MemoDraft  $memodraft
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,MemoDraft $memodraft)
    {
        $memodraft->fill($request->all());

        if ($memodraft->save()) {
            
            session()->flash('app_message', 'MemoDraft successfully updated');
            return redirect()->route('memo_drafts.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating MemoDraft');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Request  $request
     * @param  MemoDraft  $memodraft
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, MemoDraft $memodraft)
    {
        if ($memodraft->delete()) {
                session()->flash('app_message', 'MemoDraft successfully deleted');
            } else {
                session()->flash('app_error', 'Error occurred while deleting MemoDraft');
            }

        return redirect()->back();
    }
}
