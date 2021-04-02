<?php
require_once(INCLUDE_DIR . '/class.plugin.php');
require_once(INCLUDE_DIR . '/class.forms.php');
class SendSMSConfig extends PluginConfig
{
    function getOptions()
    {
        return array(
            'sb1' => new SectionBreakField(array(
                'label' => __('Your sendSMS.ro login informations'),
                'hint' => __('If you don\'t have an account, go to https://hub.sendsms.ro/register'),
            )),
            'sendsms_username' => new TextboxField(array(
                'label' => __('Your SendSMS username')
            )),
            'sendsms_password' => new PasswordField(array(
                'label' => __('Your SendSMS password/API Key')
            )),
            'sendsms_label' => new TextboxField(array(
                'label' => __('Your SendSMS label')
            )),
            'sb2' => new SectionBreakField(array(
                'label' => __('Message informations')
            )),
            'sendsms_ticket_created' => new BooleanField(array(
                'label' => __('Send an SMS when a new ticket is created')
            )),
            'sendsms_ticket_created_message' => new TextareaField(
                array(
                    'label' => __('Message'),
                    'hint' => __('Disponible variables: {phone_number}, {name}, {email}, {subject}, {help_topic}, {create_date}, {priority}, {ticket_url}'),
                    'configuration' => array(
                        'html' => false,
                        'rows' => 6,
                        'cols' => 40
                    )
                )
            ),
            'sendsms_ticket_created_short' => new BooleanField(array(
                'label' => __('Transform all URLs in short URLs?')
            )),
            'sendsms_ticket_created_gdrp' => new BooleanField(array(
                'label' => __('Add an unsubscribe link to the message?')
            ))
        );
    }
}
