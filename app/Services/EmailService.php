<?php

namespace App\Services;

use App\Http\Resources\EmailResource;
use App\Mail\SendEmail;
use App\Models\Email;
use App\Models\Recipient;
use App\Models\SenderRecipient;
use App\Models\Status;
use App\Models\User;
use App\Repositories\EmailRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class EmailService implements EmailRepository
{

    public function index()
    {
        $emails = Email::whereNotIn('status_id',  [Status::DELETED])
            ->orWhere('status_id', null)->latest()->get();

        $emailResource = EmailResource::collection($emails);

        return $emailResource;
    }

    public function store($data)
    {
        $request = $data['request'];

        $files = $data['files'];

        $email = $this->saveEmail($request);

        $this->saveRecipient($request, $email);

        $fileName  = $this->storeAttachment($files, $email);

        $data = $this->saveAttachment($fileName, $email);

        $this->sendMail($request, $email, $data);

        $email->status_id = Status::SENT;

        $email->save();

        return new EmailResource($email);
    }

    public function show($data)
    {
        $email = $data['email'];

        return new EmailResource($email);
    }

    public function recipientEmails($data)
    {
        $recipient = $data['recipient'];

        $recipientEmails = $recipient->emails;

        return response()->json($recipientEmails);
    }

    public function search($data)
    {
        $request = $data['request'];

        $searchQuery = $request->search_term;

        $searchResult = Email::with(['recipients', 'attachments'])
            ->where('subject', 'like', '%' . $searchQuery . '%')
            ->orWhere('name', 'like', '%' . $searchQuery . '%')
            ->orWhere('email', 'like', '%' . $searchQuery . '%')
            ->join('users', 'users.id', '=', 'emails.user_id')
            ->orWhereHas('recipients', function ($query) use ($searchQuery) {
                    $query->where('email', 'like', '%' . $searchQuery . '%');
            })->select(
                'emails.id',
                'users.email',
                'users.name',
                'emails.subject',
                'emails.content',
                'emails.created_at as formated_date'
            )->get();

        return $searchResult;
    }

    public function destroy($data)
    {
        $email = $data['email'];

        if (!$email) {
            return response(null, 204)->json("Email not found");
        }

        $email->status_id = Status::DELETED;

        $email->save();

        return [
            'status' => 'success',
            'message' => 'Email deleted successfully'
        ];
    }

    private function saveRecipient($request, $email)
    {
        $recipient = Recipient::create(['email' => $request->to]);

        SenderRecipient::create([
            'email_id' => $email->id,
            'recipient_id' => $recipient->id
        ]);
    }

    private function sendMail($request, $email, $data)
    {
        $name  = User::where('email', trim($request->to))->value('name') ?: 'You';

        $user = ['email' => $request->to, 'name' => $name];

        Mail::to((object) $user)->send(new SendEmail($email, $data));
    }

    private function saveEmail($request)
    {
        if (! Auth::guard('api')->check() ) {
            return response(null, 401)->json("User not authenticated");
        }

        $data = [
            'user_id' => Auth::guard('api')->id(),
            'subject' => $request->subject,
            'content' => $request->content
        ];

        return Email::create($data);
    }

    private function saveAttachment($data, $email)
    {
        if (count($data['file_names'])) {
            foreach ($data['file_names'] as $index => $fileName) {
                $email->attachments()->create(
                    ['file_url' => $data['file_urls'][$index],
                        'file_name' => $fileName
                    ]
                );
            }
        }

        return $data;
    }

    private function storeAttachment($files, $email)
    {
        $data  = [];
        foreach ($files as $file) {
            $fileExtension = $file->getClientOriginalExtension();

            $fileName = $file->getClientOriginalName();

            $mimeType  = $file->getMimeType();

            $fileUrl = now()->format('YmdHis'). '_' . $email->id . '_'. 'email_attachment'.'.'.$fileExtension;

            $upload = Storage::disk('email_attachment')->put($fileUrl, file_get_contents($file));

            if (!$upload) {
                logger()->error("Failed to upload File: {$fileName}");

                return response()->json('Failed to upload attachment');
            }

            $data['file_names'][] = $fileName;

            $data['file_urls'][] = $fileUrl;

            $data['mimes'][] = $mimeType;
        }

        return $data;
    }
}
