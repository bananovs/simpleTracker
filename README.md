simple tracker dimension, try

use Bananovs\Tracker\Tracker;


$tracker = new Tracker($tsettings['endpoint'], $tsettings['secret'], $tsettings['access_token']);
$data = $tracker
        // ->setDatabase('database')
        ->setProgramId($tsettings['program_id'])
        ->setUser($user_id) // user_id
        ->setType('click') // click, pay, ??
        ->setEvent('pay')
        ->setAmount('400')
        ->setDimension('podpiska', '400')
        ->setDimension('ebalo', 'bado');
        // ->send();
$resp = $data->send();
