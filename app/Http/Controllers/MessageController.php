<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Message;


/**
 * Description of MessageController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class MessageController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $messages = Message::where('user_id',auth()->id())->get();
        return view('pages.messages.index', compact('messages'));
    }    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Message $message)
    {
        return view('pages.messages.show', [
                'record' =>$message,
        ]);

    }    /**
     * Show the form for creating a new resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        return view('pages.messages.create', [
            'model' => new Message,

        ]);
    }    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = Message::find($request->m_id);
        if(!$message)
            $message = new Message();
        $message->id = newId();
        $message->message = $request->message;
        $message->department_id = $request->category;
        $message->user_id = auth()->id();
        $message->save();
        //activity()->on($message)->log('Created / edited custom message');
        return back();
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Message $message)
    {

        return view('pages.messages.edit', [
            'model' => $message,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Request  $request
     * @param  Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Message $message)
    {
        $message->fill($request->all());

        if ($message->save()) {

            session()->flash('app_message', 'Message successfully updated');
            return redirect()->route('messages.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating Message');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Request  $request
     * @param  Message  $message
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Message $message)
    {
        if($message->delete())
            return back();
        return back();
    }
}
