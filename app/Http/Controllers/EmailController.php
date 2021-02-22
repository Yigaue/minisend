<?php

namespace App\Http\Controllers;

use App\Email;
use App\Http\Resources\EmailResource;
use App\Mail\SendEmail;
use App\Recipient;
use App\SenderRecipient;
use App\Status;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return EmailResource::collection(
            Email::whereNotIn('status_id',  [Status::DELETED])
                ->orWhere('status_id', null)->latest()->get()
        );
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
        $this->storeAttachment($request, $email);
        $this->sendMail($request, $email);

        $email->status_id = Status::SENT;
        $email->save();

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

    public function recipientEmails(Recipient $recipient)
    {
        $recipientEmails = $recipient->emails;

        return response()->json($recipientEmails);
    }

    public function search(Request $request)
    {
        $searchQuery = $request->search_term;
        $searchResult = Email::with(['recipients', 'attachments'])
            ->where('subject', 'like', '%' . $searchQuery . '%')
            ->orWhere('alias', 'like', '%' . $searchQuery . '%')
            ->orWhere('from', 'like', '%' . $searchQuery . '%')
            ->orWhereHas(
                'recipients', function ($query) use ($searchQuery) {
                    $query->where('email', 'like', '%' . $searchQuery . '%');
                }
            )->select(
                'from',
                'id',
                'subject',
                'alias',
                'content',
                'emails.created_at as formated_date'
            )->get();

        return response()->json($searchResult);
    }

    private function storeAttachment($request, $email)
    {
        if (!$request->hasFile('file')) {
            return response()->json('No file Selected!');
        }

        $file = $request->file('file');
        $fileExtension = $file->getClientOriginalExtension();

        $fileName = 'email'.now()->format('YmdHis'). '_' . $email->id . 'attachment'.'.'.$fileExtension;

        $upload = Storage::disk('email_attachment')->put($fileName, file_get_contents($file));

        if (!$upload) {
            Log::error("Failed to upload File: {$fileName}");
            return response()->json('Failed to upload attachment');
        }
    }

    private function sendMail($request, $email)
    {
        $user = ['email' => $request->to, 'name' => $request->alias];
        Mail::to((object) $user)->send(new SendEmail($email));
    }

    private function validatEmail($request)
    {
        $this->validate(
            $request, [
            'from' => 'required|email',
            'alias' => 'required|string',
            'to' => 'required|email',
            'subject' => 'required|string',
            'content' => 'required',
            'email_attachment' => 'file|size|5000'
            ]
        );
    }

    private function saveEmail($request)
    {
        $email = Email::create(
            [
                'from' => $request->from,
                'alias' => $request->alias,
                'subject' => $request->subject,
                'content' => $request->content
            ]
        );

        return $email;
    }

    private function saveAttachment($request, $email)
    {
        if ($request->attachments) {
            foreach ($request->attachments as $attachment) {
                $email->attachments()->create(
                    ['file_link' => $attachment]
                );
            }
        }
    }


    public function saveRecipient($request, $email)
    {
        $recipient = Recipient::create(
            ['email' => $request->to]
        );

        $user = User::updateOrCreate(
            [
                'name' => $request->alias,
                'email' => $request->from,
                'password' => bcrypt("password" . rand(1, 1000))
            ]
        );

        SenderRecipient::create(
            [
                'user_id' => $user->id,
                'email_id' => $email->id,
                'recipient_id' => $recipient->id
            ]
        );
    }

    public function destroy(Email $email)
    {
        if (!$email) {
            return response(null, 204)->json("Email not found");
        }
        $email->status_id = Status::DELETED;
        $email->save();

        return response()->json('Email deleted successfully');;
    }
}
