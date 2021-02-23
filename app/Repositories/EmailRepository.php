<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface EmailRepository
{
    public function index();

    public function store($data);

    public function show($data);

    public function recipientEmails($data);

    public function search($data);

    public function destroy($data);
}
