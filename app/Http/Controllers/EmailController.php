<?php

namespace App\Http\Controllers;

use App\Email;
use App\Http\Resources\EmailResource;
use App\Recipient;
use App\SenderRecipient;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    // public function __construct()
    // {
    //      $this->middleware('auth:api')->except(['index', 'show']);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return EmailResource::collection(Email::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validatEmail($request);
        $email = $this->saveEmail($request);
        $this->saveAttachment($request, $email);
        $this->saveRecipient($request, $email);

        return new EmailResource($email);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Email $email)
    {
        return new EmailResource($email);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Email $email)
    {
        $email->delete();

        return response()->json("email deleted successful $email->id");
    }

    private function validatEmail($request)
    {
        $this->validate($request, [
            'alias' => 'required|string',
            'to' => 'required|email',
            'subject' => 'required|string',
            'text_content' => 'required'
        ]);
    }

    private function saveEmail($request)
    {
        $email = Email::create([
            'alias' => $request->alias,
            'subject' => $request->subject,
            'text_content' => $request->text_content,
            'html_content' => $request->html_content,
        ]);

        return $email;
    }

    private function saveAttachment($request, $email)
    {
        foreach ($request->attachments as $attachment) {
            $email->attachments()->create(
                ['file_link' => $attachment]
            );
        }
    }

    public function saveRecipient($request, $email)
    {
        $recipient = Recipient::create(
            ['email' => $request->to]
        );

        SenderRecipient::create(
            [
                'user_id' => 2,
                'email_id' => $email->id,
                'recipient_id' => $recipient->id
            ]
        );
    }
}
