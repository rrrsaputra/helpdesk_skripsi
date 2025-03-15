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
                    'references' => $ticket->references,
                    'created_at' => $ticket->created_at,
                    'user_name' => $ticket->user->name,
                    'nim' => $ticket->user->username,
                    'agent_name' => $ticket->assignedToUser->name,
                    'category' => $ticket->category,
                    'subject' => $ticket->title,
                    'message'   => strip_tags($ticket->message),
                    'status' => $ticket->status,
                    'link' => env('APP_URL') . '/admin/data-repository?ticket=' . $ticket->references,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Reference',
            'Date',
            'User Name',
            'NIM',
            'Agent Name',
            'Category',
            'Subject',
            'Message',
            'Status',
            'Link',
        ];
    }
}
