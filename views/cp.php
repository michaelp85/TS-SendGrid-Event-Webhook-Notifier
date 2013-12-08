<style>
	table.mainTable td.subject_row {
		border-bottom: 2px solid #45555f;
		background-color: #fff;
	}
</style>
<?php
    $this->table->set_heading('SendGrid Configuration');

    $this->table->add_row('<b>HTTP Post URL:</b> '.$action_url);

    echo $this->table->generate();
    
    /* Events Data */
    $this->table->set_heading('Event', 'Timestamp', 'Email', 'SMTP Id', 'IP Address', 'User Agent');

    foreach($events as $event)
    {
        $this->table->add_row(
			'<b>'. ucfirst($event['event_type']).'</b>',
			ee()->localize->human_time( $event['event_timestamp'] ),
			$event['event_email'],
			$event['event_smtpid'] ? $event['event_smtpid'] : 'N/A',
			$event['event_ip'] ? long2ip($event['event_ip']) : 'N/A',
			$event['event_useragent'] ? $event['event_useragent'] : 'N/A'
		);
		
		/* Add subject with colspan */
		$cell = array(
			'data' => 'Subject: '.$event['event_subject'],
			'colspan' => 6,
			'class' => 'subject_row'
		);
		$this->table->add_row($cell);
    }

	echo $this->table->generate();
?>