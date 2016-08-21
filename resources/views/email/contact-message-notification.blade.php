<h1>A new contact message was sent from!</h1>
<h3>Information about the message:</h3>
<p>From: {{ $contact_message->sender }}</p>
<p>Email: {{ $contact_message->email }}</p>
<p>Subject: {{ $contact_message->subject }}</p>
<p>Message: {{ $contact_message->body }}</p>