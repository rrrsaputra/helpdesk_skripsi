<!DOCTYPE html>
<html>
<head>
    <title>New Ticket Notification</title>
</head>
<body>
    <h2>New Helpdesk Ticket Received</h2>
    <p><strong>Ticket ID:</strong> {{ $ticket_id }}</p>
    <p><strong>User:</strong> {{ $user_name }}</p>
    <p><strong>Subject:</strong> {{ $subject }}</p>
    <p><strong>Description:</strong> {{ strip_tags($description) }}</p>
    <br>
    <p>Please check and respond to the ticket as soon as possible.</p>
    <p><a href="{{ env('APP_URL') . '/messages/' . $ticket->references }}">View Ticket</a></p>
</body>
</html>
