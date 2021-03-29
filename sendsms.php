<?php
require_once('config.php');
require_once(INCLUDE_DIR . 'class.plugin.php');
require_once(INCLUDE_DIR . 'class.signal.php');
require_once(INCLUDE_DIR . 'class.ticket.php');

class SendSMS extends Plugin
{
	var $config_class = 'SendSMSConfig';
	var $config;
	function bootstrap()
	{
		$this->config = $this->getConfig();
		Signal::connect('ticket.created', function (Ticket $ticket) {
			$ticketData['phone_number'] = preg_replace('/\D/', '', $ticket->getPhoneNumber());
			$ticketData['name'] = $ticket->getName()->getFull();
			$ticketData['email'] = $ticket->getEmail()->__toString();
			$ticketData['subject'] = $ticket->getSubject();
			$ticketData['help_topic'] = $ticket->getHelpTopic();
			$ticketData['create_date'] = $ticket->getCreateDate();
			$ticketData['priority'] = $ticket->getPriority()->getDesc();
			$ticketData['ticket_url'] = $ticket->getVar('client_link');

			$userData['username'] = urlencode(trim($this->config->get('sendsms_username')));
			$userData['password'] = urlencode(trim($this->config->get('sendsms_password')));
			$userData['label'] = urlencode($this->config->get('sendsms_label'));
			$userData['ticket_created'] = $this->config->get('sendsms_ticket_created');
			$userData['ticket_created_message'] = urlencode($this->config->get('sendsms_ticket_created_message'));
			$userData['ticket_created_short'] = $this->config->get('sendsms_ticket_created_short');
			$userData['ticket_created_gdpr'] = $this->config->get('sendsms_ticket_created_gdrp');

			if (!empty($ticketData['phone_number']) && !empty($userData['ticket_created_message'] && $userData['ticket_created'] !== '0') && !empty($userData['username']) && !empty($userData['password'])) {
				$curl = curl_init();

				curl_setopt($curl, CURLOPT_HEADER, 1);
				curl_setopt($curl, CURLOPT_URL, 'https://api.sendsms.ro/json?action=message_send' . ($userData['ticket_created_gdpr'] === true ? '_gdpr' : '')
					. '&username=' . $userData['username']
					. '&password=' . $userData['password']
					. '&from=' . $userData['label']
					. '&to=' . $ticketData['phone_number']
					. '&text=' . $userData['ticket_created_message']
					. '&short=' . ($userData['ticket_created_short'] === true ? 'true' : 'false'));
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLINFO_HEADER_OUT, true);
				curl_setopt($curl, CURLOPT_HTTPHEADER, array("Connection: keep-alive"));

				$result = curl_exec($curl);

				$size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);

				$result = substr($result, $size);

				echo $result;

				//TODO: save to database if you can make a page for this 
			}
			/*			
			highlight_string("<?php\n\$userData =\n" . var_export($userData, true) . ";\n?>");
*/
		});
	}
}
