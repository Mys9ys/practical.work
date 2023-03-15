<?php
if ($_POST['Имя']) {
    $name = $_POST['Имя'];
} else {
    $name = 'Уточнить имя';
}
$phone = $_POST['Телефон'];
$title = 'Заявка с сайта clinik.eurokappa.moscow, клиент: ' . $name;
if($phone == '') exit();
//Добавляем лид
$srm_lead_url = "https://eurokappa.bitrix24.ru/rest/5274/ocqpp8glkn36y0l1/crm.lead.add";
$crmQuery = [ // Пишем в массив для логирования
    'fields' => array(
        "TITLE" => $title,
        "NAME" => $name,
        "OPENED" => "Y",
        "PHONE" => array(
            array("VALUE" => $phone, "VALUE_TYPE" => "WORK")
        ),
    ),
    'params' => array("REGISTER_SONET_EVENT" => "Y")
];
$srm_lead_add = http_build_query($crmQuery);

$crmQuery["date"] = date('Y-m-d H:i:s'); // докидываем дату

file_put_contents('log.json', json_encode($crmQuery), FILE_APPEND | LOCK_EX);

$curl_lead_add = curl_init();
curl_setopt_array($curl_lead_add, array(
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_POST => 1,
    CURLOPT_HEADER => 0,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $srm_lead_url,
    CURLOPT_POSTFIELDS => $srm_lead_add,
));
$new_lead = curl_exec($curl_lead_add);
curl_close($curl_lead_add);

$new_lead = json_decode($new_lead, 1);

$leadID = isset($new_lead['result']) ? $new_lead['result'] : 0;
echo '$leadID = ' . $leadID;