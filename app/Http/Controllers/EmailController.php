<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\Recipient;
use App\Repositories\EmailRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $emailRepository;

    public function __construct(EmailRepository $emailRepository)
    {
        $this->emailRepository = $emailRepository;
    }

    public function index()
    {
        return $this->emailRepository->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $files = $request['files'];

        $request = json_decode($request['data']);

        $request = new \Illuminate\Http\Request((array) $request);

        $this->validatEmail($request);

        return $this->emailRepository->store(['request' => $request, 'files' => $files]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Email $email)
    {
        return $this->emailRepository->show(['email' => $email]);
    }

    public function recipientEmails(Recipient $recipient)
    {
        return $this->emailRepository->recipientEmails(['recipient' => $recipient]);
    }

    public function search(Request $request)
    {
        $searchResult = $this->emailRepository->search(['request' => $request]);
        return response()->json($searchResult);
    }

    public function destroy(Email $email)
    {

        $response = $this->emailRepository->destroy(['email' => $email]);

        return response()->json($response['message']);
    }

    private function validatEmail($request)
    {
        $this->validate(
            $request,
            [
                'to' => 'required|email',
                'subject' => 'required|string',
                'content' => 'required',
            ]
        );
    }
}
