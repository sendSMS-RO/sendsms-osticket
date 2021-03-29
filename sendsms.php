<?php
require_once('config.php');
require_once (INCLUDE_DIR . 'class.plugin.php');
require_once (INCLUDE_DIR . 'class.signal.php');
require_once (INCLUDE_DIR . 'class.ticket.php');

class SendSMS extends Plugin
{
	var $config_class = 'SendSMSConfig';
	var $config;
	function bootstrap()
	{
		$this->config = $this->getConfig();
		Signal::connect('ticket.created', function(Ticket $ticket) {
			$data['phone_number'] = $ticket->getPhoneNumber();
			$data['name'] = $ticket->getName()->getFull();
			$data['email'] = $ticket->getEmail()->__toString();
			$data['subject'] = $ticket->getSubject();
			$data['help_topic'] = $ticket->getHelpTopic();
			$data['create_date'] = $ticket->getCreateDate();
			$data['priority'] = $ticket->getPriority()->getDesc();
			$data['ticket_url'] = $ticket->getVar('client_link');
			highlight_string("<?php\n\$config =\n" . var_export($this->config, true) . ";\n?>");
		});
	}
}
