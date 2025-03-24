<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class TicketsExport implements FromCollection, WithHeadings
{

    protected $since;
    protected $until;
    protected $search;
    protected $sort;
    protected $direction;

    public function __construct($since = null, $until = null, $search = null, $sort = 'created_at', $direction = 'asc')
    {
        $this->since = $since;
        $this->until = $until;
        $this->search = $search;
        $this->sort = $sort;
        $this->direction = $direction;
    }

    public function collection()
    {
        return Ticket::when($this->since, function ($query) {
            $query->where('created_at', '>=', $this->since);
        })
            ->when($this->until, function ($query) {
                $query->where('created_at', '<=', $this->until);
            })
            ->when($this->search, function ($query) {
                $query->where('category', 'like', "%{$this->search}%");
            })
            ->orderBy($this->sort, $this->direction)
            ->with('user')
            ->get()
            ->map(function ($ticket) {
                return [
                    $ticket->references,
                    $ticket->created_at->format('d/m/Y'),
                    $ticket->created_at->format('H:i:s'),
                    $ticket->updated_at->format('d/m/Y'),
                    $ticket->status,
                    $ticket->user->name ?? 'N/A',
                    $ticket->user->username ?? 'N/A',
                    $ticket->user->studyProgram->name ?? 'N/A',
                    $ticket->lecture_program ?? 'N/A',
                    $ticket->assignedToUser->name ?? 'Unassigned',
                    $ticket->category,
                    $ticket->title,
                    strip_tags($ticket->message),
                    $ticket->feedback ?? '-'
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Reference',
            'Date',
            'Time',
            'Date Closed',
            'Status',
            'Name',
            'NIM',
            'Study Program',
            'Lecture Program',
            'Agent Name',
            'Category',
            'Subject',
            'Message',
            'Feedback',
        ];
    }
}
