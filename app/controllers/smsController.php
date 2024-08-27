<?php 

use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;

class smsController extends controller{

    function sendMsg(){
        $report_model = new reportModel();
		$settings_model = new settingsModel();
        $barangays = $settings_model->get_barangays(1);
				
        $total_supporters_per_brgy = $report_model->get_total_supporters(2022);
        $total_voters_per_brgy = $report_model->get_total_voters(2022);
        $data = [];

        $ctr = 0;
        foreach ($total_supporters_per_brgy as $supporter){
            $data[] = ['barangay' => $barangays[$ctr]['name'], 'supporter' => $supporter, 'voters' => $total_voters_per_brgy[$ctr]];
            $ctr++;
        }

        $phoneNumber = "+639097764778"; //"+639097764778";
        $message = "Team Cajes Supporters update as of ".date('F d, Y')." \n\n";

        foreach ($data as $d){
            $message = $message.$d['barangay']." - ".$d['supporter']." / ".$d['voters']." \n";
        }
        
        $apiURL = "xl8lve.api.infobip.com";
        $apiKey = "93ff623eb34d5c53f6f8ce5c5e82938b-83ebf394-a37a-469a-a6a2-eb3f2250f1e2";

        $configuration = new Configuration(host: $apiURL, apiKey: $apiKey);
        $api = new SmsApi(config: $configuration);
        $destination = new SmsDestination(to: $phoneNumber);
        $theMessage = new SmsTextualMessage(
            destinations: [$destination],
            text: $message,
            from: 'Team Cajes'
        );

        $request = new SmsAdvancedTextualRequest(messages: [$theMessage]);
        $response = $api->sendSmsMessage($request);

        echo 1;
    }

}

?>

<!-- Update as of April 10, 2024
Banlasan
Bonbong
Catoogan
Guinobatan
Hinlayagan Ilaud
Hinlayagan Ilaya
Kauswagan
Kinan-oan
La Union
La Victoria
Mabuhay Cabiguhan
Mahagbu
Manuel M. Roxas
Poblacion
San Isidro
San Vicente
Santo Tomas
Soom
Tagum Norte
Tagum Sur -->