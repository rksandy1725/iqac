<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Models\MeetingAttendee;
use App\Models\User;

class MeetingController extends Controller
{
    public function index(Request $request)
    {
        $query = Meeting::with(['creator', 'attendees.user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('meeting_type')) {
            $query->where('meeting_type', $request->meeting_type);
        }

        $meetings = $query->latest('meeting_date')->paginate(15)->withQueryString();

        return view('meetings.index', compact('meetings'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('meetings.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'meeting_type' => 'required|in:iqac,department,other',
            'meeting_date' => 'required|date',
            'meeting_time' => 'nullable|string|max:20',
            'venue' => 'nullable|string|max:255',
            'agenda' => 'nullable|string',
            'attendees' => 'nullable|array',
            'attendees.*' => 'exists:users,id',
        ]);

        $validated['created_by'] = auth()->id();
        $meeting = Meeting::create($validated);

        if (!empty($validated['attendees'])) {
            foreach ($validated['attendees'] as $userId) {
                $meeting->attendees()->create([
                    'user_id' => $userId,
                    'attendance_status' => 'invited',
                ]);
            }
        }

        return redirect()->route('meetings.show', $meeting)->with('success', 'Meeting scheduled successfully.');
    }

    public function show(Meeting $meeting)
    {
        $meeting->load(['creator', 'attendees.user']);
        return view('meetings.show', compact('meeting'));
    }

    public function edit(Meeting $meeting)
    {
        $users = User::orderBy('name')->get();
        $meeting->load('attendees');
        $selectedAttendees = $meeting->attendees->pluck('user_id')->toArray();

        return view('meetings.edit', compact('meeting', 'users', 'selectedAttendees'));
    }

    public function update(Request $request, Meeting $meeting)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'meeting_type' => 'required|in:iqac,department,other',
            'meeting_date' => 'required|date',
            'meeting_time' => 'nullable|string|max:20',
            'venue' => 'nullable|string|max:255',
            'agenda' => 'nullable|string',
            'minutes' => 'nullable|string',
            'action_items' => 'nullable|string',
            'status' => 'required|in:scheduled,ongoing,completed,cancelled',
            'attendees' => 'nullable|array',
            'attendees.*' => 'exists:users,id',
        ]);

        $meeting->update($validated);

        if (isset($validated['attendees'])) {
            $meeting->attendees()->delete();
            foreach ($validated['attendees'] as $userId) {
                $meeting->attendees()->create([
                    'user_id' => $userId,
                    'attendance_status' => 'invited',
                ]);
            }
        }

        return redirect()->route('meetings.show', $meeting)->with('success', 'Meeting updated successfully.');
    }

    public function destroy(Meeting $meeting)
    {
        $meeting->delete();
        return redirect()->route('meetings.index')->with('success', 'Meeting deleted successfully.');
    }

    public function updateAttendance(Request $request, Meeting $meeting)
    {
        $validated = $request->validate([
            'attendee_id' => 'required|exists:meeting_attendees,id',
            'attendance_status' => 'required|in:present,absent,invited',
        ]);

        MeetingAttendee::where('id', $validated['attendee_id'])
            ->update(['attendance_status' => $validated['attendance_status']]);

        return redirect()->back()->with('success', 'Attendance updated.');
    }
}
