<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BotUser;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BotUserController extends Controller
{
    public function index()
    {
        $botUsers = BotUser::orderBy('created_at', 'desc')->get();

        return view('admin.bot-users.index', compact('botUsers'));
    }

    public function create()
    {
        return view('admin.bot-users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'telegram_id' => 'required|unique:bot_users,telegram_id',
            'username' => 'nullable|string',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
        ]);

        BotUser::create([
            'telegram_id' => $request->telegram_id,
            'username' => $request->username,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'is_active' => $request->has('is_active'),
            'is_admin' => $request->has('is_admin'),
        ]);

        return redirect()->route('admin.bot-users.index')->with('success', 'Bot user created successfully');
    }

    public function edit(BotUser $botUser)
    {
        return view('admin.bot-users.edit', compact('botUser'));
    }

    public function update(Request $request, BotUser $botUser)
    {
        $request->validate([
            'telegram_id' => 'required|unique:bot_users,telegram_id,' . $botUser->id,
            'username' => 'nullable|string',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
        ]);

        $botUser->update([
            'telegram_id' => $request->telegram_id,
            'username' => $request->username,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'is_active' => $request->has('is_active'),
            'is_admin' => $request->has('is_admin'),
        ]);

        return redirect()->route('admin.bot-users.index')->with('success', 'Bot user updated successfully');
    }

    public function destroy(BotUser $botUser)
    {
        $botUser->delete();

        return back()->with('success', 'Bot user deleted successfully');
    }

    public function massDestroy(Request $request)
    {
        BotUser::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function toggleActive(BotUser $botUser)
    {
        $botUser->update(['is_active' => !$botUser->is_active]);

        return back()->with('success', 'Status updated successfully');
    }
}
