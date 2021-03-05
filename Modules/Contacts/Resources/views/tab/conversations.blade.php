@widget('Emails\SendContactEmail', ['id' => $contact->id, 'subject' => optional($contact->emails->first())->subject])
@widget('Emails\ShowEmails', ['emails' => $contact->emails])