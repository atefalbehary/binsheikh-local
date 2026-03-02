<?php

$jsonData = json_decode(file_get_contents('https://gist.githubusercontent.com/anubhavshrimal/75f6183458db8c453306f93521e93d37/raw/f77e7598a8503f1f70528ae1cbf9f66755698a16/CountryCodes.json'));
$data = [];
foreach ($jsonData as $key) {
    if ($key->code === "IL") continue; // Exclude Israel as per standard Middle Eastern configs
    $data[] = [
        'name' => $key->name,
        'name_ar' => $key->name, // using same name as placeholder for arabic
        'code' => $key->code,
        'code_iso' => $key->code,
        'phone_code' => str_replace('+', '', $key->dial_code),
        'created_at' => gmdate('Y-m-d H:i:s'),
        'updated_at' => gmdate('Y-m-d H:i:s')
    ];
}

if (!empty($data)) {
    DB::table('country')->truncate();
    DB::table('country')->insert($data);
    echo "Seeded " . count($data) . " countries successfully.\n";
}
