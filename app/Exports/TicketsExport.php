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
                'category' => $ticket->category,
                'title_message' => $ticket->title . ' - ' . strip_tags($ticket->message),
                'time_received' => $ticket->created_at,
                'time_delivered' => $ticket->updated_at,
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
            'Category',
            'Topic/Case',
            'Time Received',
            'Time Delivered',
            'Status',
            'Link',
        ];
    }
}
