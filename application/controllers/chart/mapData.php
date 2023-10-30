<?php 

$data_pis = $this->db->get('vw_map_chart')->result_array();

$data = json_encode($data_pis,JSON_NUMERIC_CHECK);
echo $data;
exit();

$data = '[
{"name": "Ambon", "lat": -3.654703, "lon": 128.190643, "jumlah": "2.390", "value": 70.69},
{"name": "Bajoe", "lat": -4.546712, "lon": 120.4067, "jumlah": "347", "value": 24.67},
{"name": "Bakauheni", "lat": -5.860035, "lon": 105.739624, "jumlah": "644", "value": 616.52},
{"name": "Balikpapan", "lat": -1.263539, "lon": 116.827881, "jumlah": "2.013", "value": 61.19},
{"name": "Banda Aceh", "lat": 5.54829, "lon": 95.323753, "jumlah": "583", "value": 9.08},
{"name": "Bangka", "lat": -2.288478, "lon": 106.064018, "jumlah": "1.096", "value": 50.07},
{"name": "Batam", "lat": 0.951134, "lon": 103.951462, "jumlah": "1.463", "value": 82.43},
{"name": "Batulicin", "lat": -3.443435, "lon": 115.998108, "jumlah": "1.161", "value": 65.99},
{"name": "Bau-bau", "lat": -5.45513, "lon": 122.610489, "jumlah": "2.308", "value": 69.76},
{"name": "Biak", "lat": -1.18022, "lon": 136.093246, "jumlah": "867", "value": 61.11},
{"name": "Bitung", "lat": 1.455353, "lon": 125.204697, "jumlah": "1.094", "value": 81.76},
{"name": "Indonesia Ferry Property", "lat": -6.279861, "lon": 106.974571, "jumlah": "41", "value": 0.83},
{"name": "Jepara", "lat": -6.574958, "lon": 110.670525, "jumlah": "600", "value": 53.55},
{"name": "Kantor Pusat", "lat": -6.184311, "lon": 106.874748, "jumlah": "2.823", "value": 42.33},
{"name": "Kayangan", "lat": -8.249376, "lon": 116.265732, "jumlah": "1.516", "value": 88.81},
{"name": "Ketapang", "lat": -8.062377, "lon": 114.265533, "jumlah": "1.698", "value": 176.38},
{"name": "Kupang", "lat": -10.178757, "lon": 123.597603, "jumlah": "2.284", "value": 115.51},
{"name": "Lembar", "lat": -8.727837, "lon": 116.077316, "jumlah": "1.681", "value": 202.58},
{"name": "Luwuk", "lat": -0.951842, "lon": 122.79612, "jumlah": "1.624", "value": 90.65},
{"name": "Merak", "lat": -5.93103, "lon": 105.997223, "jumlah": "2.467", "value": 697.44},
{"name": "Merauke", "lat": -8.496041, "lon": 140.394547, "jumlah": "500", "value": 32.44},
{"name": "Padang", "lat": -0.95, "lon": 100.353058, "jumlah": "621", "value": 27.46},
{"name": "Pontianak", "lat": -0.022523, "lon": 109.330307, "jumlah": "2.702", "value": 41.95},
{"name": "Sape", "lat": -8.448095, "lon": 119.038277, "jumlah": "956", "value": 49.23},
{"name": "Selayar", "lat": -5.577589, "lon": 120.445946, "jumlah": "1.034", "value": 32.01},
{"name": "Sibolga", "lat": 1.740374, "lon": 98.782799, "jumlah": "648", "value": 20.7},
{"name": "Singkil", "lat": 2.358946, "lon": 97.872162, "jumlah": "696", "value": 28.61},
{"name": "Sorong", "lat": -0.866667, "lon": 131.25, "jumlah": "1.173", "value": 85.31},
{"name": "Surabaya", "lat": -7.197611, "lon": 112.732147, "jumlah": "844", "value": 195.5},
{"name": "Ternate", "lat": 0.783333, "lon": 127.366669, "jumlah": "1.919", "value": 107.23},
{"name": "Tual", "lat": -5.640851, "lon": 132.747513, "jumlah": "717", "value": 58.92}
]';

// $data='[]';

