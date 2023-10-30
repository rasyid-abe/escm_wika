<?php

$post = $this->input->post();

$page = $post['page'];
$limit = $post['rows'];

$filter = array();
if (isset($post['fil'])) {
    $filter['fil'] = $post['fil'];
    if ($post['pg'] != '') {
        $filter['pg'] = $post['pg'];
    }
    if ($post['project'] != '') {
        $filter['project'] = $post['project'];
    }
    if ($post['prtype'] != '') {
        $filter['prtype'] = $post['prtype'];
    }
    if ($post['pr'] != '') {
        $filter['pr'] = $post['pr'];
    }
    if ($post['orby'] != '') {
        $filter['orby'] = $post['orby'];
    }
    if ($post['orty'] != '') {
        $filter['orty'] = $post['orty'];
    }
    if ($post['altex'] != '') {
        $filter['altex'] = $post['altex'];
    }
    if ($post['drup'] == 1) {
        $filter['drup'] = "('ZPW1')";
    } else {
        $filter['drup'] = "('ZPW2','ZPW3','ZPW4')";
    }
}

if ($page < 1) {
    $offset = 0;
} elseif ($page > 0) {
    $offset = $limit * $page;
}

$data = array();
$data['limit'] = $limit;
$data['offset'] = $offset;
$data['page'] = (int)$page + 1;
$data['shows'] = $limit;
$data['num_rows'] = $this->sqln_data_sap($filter,'','')->num_rows();

$raw = $this->sqln_data_sap($filter, $limit, $offset)->result_array();
$list = [];

for ($i=0; $i < count($raw); $i++) {
    $ld = $this->sapn_draw($filter, $raw[$i]['ppm_id']);
    if (count($ld) > 0) {
        $head = $raw[$i];
        $body = ['item' => $ld];
        $list[] = array_merge($head, $body);
    }
}

$data['result'] = $list;
echo json_encode($data);
