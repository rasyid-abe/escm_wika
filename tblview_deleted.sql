-- public.vw_prc_pr_item_sap source

CREATE OR REPLACE VIEW public.vw_prc_pr_item_sap
AS SELECT a.ppi_code AS smbd_catalog_code,
a.ppm_id,
b.group_name AS group_smbd_name,
"substring"(a.ppi_code::text, 1, 3) AS group_smbd_code,
a.ppi_code AS smbd_code,
a.ppi_item_desc AS smbd_name,
a.ppi_satuan AS unit,
''::character varying AS currency,
a.ppi_harga AS price,
a.ppis_pr_number,
a.ppis_pr_item,
a.ppis_delivery_date,
a.ppis_pr_type,
ROW(a.ppi_harga::double precision * a.ppi_jumlah, 2, 50)::text AS jumlah,
a.ppi_jumlah AS smbd_quantity,
c.ppv_remain,
m.ppm_project_id AS spk_code,
a.ppi_jumlah AS ppv_max,
b.is_matgis,
a.ppis_cat_tech,
a.ppis_acc_assig
FROM prc_plan_item a
LEFT JOIN ( SELECT DISTINCT ON (ppv.ppv_smbd_code) ppv.ppm_id,
ppv.ppv_remain,
ppv.ppv_smbd_code
FROM prc_plan_volume ppv
JOIN prc_plan_main ppm ON ppm.ppm_id = ppv.ppm_id
ORDER BY ppv.ppv_smbd_code, ppv.ppv_id DESC) c ON c.ppm_id = a.ppm_id AND a.ppi_code::text = c.ppv_smbd_code::text
LEFT JOIN com_group_smbd b ON b.group_code::text = "substring"(a.ppi_code::text, 1, 3)
LEFT JOIN prc_plan_main m ON a.ppm_id = m.ppm_id;


-- public.vw_prc_pr_sap source

CREATE OR REPLACE VIEW public.vw_prc_pr_sap
AS SELECT concat(ppi.ppis_pr_type, ', ', ppm.ppm_project_id, ', Project Def : ', ppm.ppm_subject_of_work, ', TCM : Rp. ', btrim(to_char(( SELECT sum(ppi2.ppi_harga::double precision * ppi2.ppi_jumlah) AS t
FROM prc_plan_main ppm2
JOIN prc_plan_item ppi2 ON ppm2.ppm_id = ppi2.ppm_id
WHERE ppi2.ppis_pr_type::text = ppi.ppis_pr_type::text AND ppm2.ppm_project_id::text = ppm.ppm_project_id::text
GROUP BY ppi2.ppis_pr_type, ppm2.ppm_project_id), '99,999,999,999,999'::text)), ', Total Cost Plan BL : Rp. 0') AS head_pr,
ppi.ppi_id,
ppm.ppm_id,
ppm.ppm_project_id,
ppm.ppm_subject_of_work,
ppm.ppm_scope_of_work,
ppm.ppm_pagu_anggaran,
ppm.ppm_sisa_anggaran,
ppi.ppis_pr_type,
ppi.ppis_pr_number,
ppm.ppm_type_of_plan,
ppm.ppm_project_name,
ppm.ppms_project_id,
ppm.ppms_storage_loc,
ppm.ppms_tgl_tender,
ppm.ppms_tgl_po,
ppm.ppms_target_kedatangan,
ppm.ppm_ekgrp,
ppm.ptm_is_uskep_online,
ppi.ppis_acc_assig,
ppm.ptm_ctr_matgis_type,
ppi.ppis_pr_item,
ppi.ppi_code,
"substring"(ppi.ppi_code::text, 1, 3) AS code_sub,
ppi.ppi_item_desc,
ppm.ppm_dept_id,
ppm.ppm_dept_name,
ppi.ppi_satuan,
ppi.ppi_jumlah,
ppi.ppi_harga,
ppi.ppi_harga::double precision * ppi.ppi_jumlah AS subtotal,
ppm.ppms_start_date,
ppm.ppms_finish_date,
ppi.ppis_delivery_date,
ppi.ppi_update_at,
ppi.status_rkp,
ppi.ppi_temp_vol,
ppi.ppi_pr_order,
ppi.ppi_mata_uang,
ppi.tit_incoterm,
ppi.tit_lokasi_incoterm,
ppi.tit_sumber_hps,
ppi.tit_hps,
ppi.tit_lampiran,
ppi.tit_pr_number,
ppi.tit_pr_item,
ppi.tit_delivery_date,
ppi.tit_pr_type,
ppi.tit_cat_tech,
ppi.tit_acc_assig,
ppi.ppis_remark,
ppi.ppis_network,
ppi.ppis_network_desc,
ppi.ppis_wbs_element,
ppi.ppis_wbs_element_desc,
ppi.ppi_is_sap,
ppi.ppis_used_date,
ppi.ppis_cat_tech,
ppi.ppi_delete_flag,
ppi.ppi_created_at
FROM prc_plan_main ppm
JOIN prc_plan_item ppi ON ppi.ppm_id = ppm.ppm_id
LEFT JOIN adm_dept ad ON ad.dept_id = ppm.ppm_dept_id
WHERE ppm.ppm_is_sap = 1
ORDER BY ppi.ppis_pr_number DESC;


-- public.vw_prc_plan_item source

CREATE OR REPLACE VIEW public.vw_prc_plan_item
AS SELECT a.smbd_code AS smbd_catalog_code,
b.ppm_id,
a.group_smbd_name,
a.group_smbd_code,
a.smbd_code,
a.smbd_name,
a.unit,
a.currency,
a.price,
"substring"((a.price::double precision * sum(COALESCE(a.smbd_quantity, 0::numeric::double precision)))::numeric::money::text, 2, 50) AS jumlah,
sum(COALESCE(a.smbd_quantity, 0::double precision)) AS smbd_quantity,
c.ppv_remain,
a.spk_code,
round(sum(COALESCE(a.smbd_quantity, 0::double precision))) AS ppv_max,
a.is_matgis
FROM prc_plan_integrasi a
LEFT JOIN prc_plan_main b ON b.ppm_project_id::text = a.spk_code::text
LEFT JOIN ( SELECT DISTINCT ON (ppv.ppv_smbd_code) ppv.ppm_id,
ppv.ppv_remain,
ppv.ppv_smbd_code
FROM prc_plan_volume ppv
JOIN prc_plan_main ppm ON ppm.ppm_id = ppv.ppm_id
ORDER BY ppv.ppv_smbd_code, ppv.ppv_id DESC) c ON c.ppm_id = b.ppm_id AND a.smbd_code::text = c.ppv_smbd_code::text
GROUP BY a.smbd_code, b.ppm_id, a.group_smbd_name, a.group_smbd_code, a.smbd_name, a.unit, a.price, a.spk_code, a.currency, c.ppv_remain, a.is_matgis
UNION ALL
SELECT a.ppi_code AS smbd_catalog_code,
a.ppm_id,
b.group_name AS group_smbd_name,
"substring"(a.ppi_code::text, 1, 3) AS group_smbd_code,
a.ppi_code AS smbd_code,
a.ppi_item_desc AS smbd_name,
a.ppi_satuan AS unit,
''::character varying AS currency,
a.ppi_harga AS price,
ROW(a.ppi_harga::double precision * a.ppi_jumlah, 2, 50)::text AS jumlah,
a.ppi_jumlah AS smbd_quantity,
c.ppv_remain,
NULL::character varying AS spk_code,
a.ppi_jumlah AS ppv_max,
b.is_matgis
FROM prc_plan_item a
LEFT JOIN prc_plan_volume c ON c.ppm_id = a.ppm_id AND a.ppi_code::bpchar = c.ppv_smbd_code::bpchar
LEFT JOIN com_group_smbd b ON b.group_code::text = "substring"(a.ppi_code::text, 1, 3);


-- public.vw_prc_plan_item_pmcs source

CREATE OR REPLACE VIEW public.vw_prc_plan_item_pmcs
AS SELECT a.smbd_code AS smbd_catalog_code,
b.ppm_id,
a.group_smbd_name,
a.group_smbd_code,
a.smbd_code,
a.smbd_name,
a.unit,
a.currency,
a.price,
"substring"((a.price::double precision * sum(COALESCE(a.smbd_quantity, 0::numeric::double precision)))::numeric::money::text, 2, 50) AS jumlah,
COALESCE(a.smbd_quantity, 0::double precision) AS smbd_quantity,
c.ppv_remain,
a.spk_code,
COALESCE(a.smbd_quantity, 0::double precision) AS ppv_max,
a.periode_pengadaan
FROM prc_plan_integrasi a
LEFT JOIN prc_plan_main b ON b.ppm_project_id::text = a.spk_code::text
LEFT JOIN ( SELECT ppv.ppm_id,
ppv.ppv_remain,
ppv.ppv_smbd_code
FROM prc_plan_volume ppv
JOIN prc_plan_main ppm ON ppm.ppm_id = ppv.ppm_id
ORDER BY ppv.ppv_smbd_code, ppv.ppv_id DESC) c ON c.ppm_id = b.ppm_id AND a.smbd_code::text = c.ppv_smbd_code::text
GROUP BY a.smbd_code, b.ppm_id, a.group_smbd_name, a.group_smbd_code, a.smbd_name, a.unit, a.price, a.spk_code, c.ppv_remain, a.currency, a.smbd_quantity, a.periode_pengadaan
UNION ALL
SELECT a.ppi_code AS smbd_catalog_code,
a.ppm_id,
b.group_name AS group_smbd_name,
"substring"(a.ppi_code::text, 1, 3) AS group_smbd_code,
a.ppi_code AS smbd_code,
a.ppi_item_desc AS smbd_name,
a.ppi_satuan AS unit,
''::character varying AS currency,
a.ppi_harga AS price,
ROW(a.ppi_harga::double precision * a.ppi_jumlah, 2, 50)::text AS jumlah,
a.ppi_jumlah AS smbd_quantity,
c.ppv_remain,
NULL::character varying AS spk_code,
a.ppi_jumlah AS ppv_max,
''::character varying AS periode_pengadaan
FROM prc_plan_item a
LEFT JOIN prc_plan_volume c ON c.ppm_id = a.ppm_id AND a.ppi_code::bpchar = c.ppv_smbd_code::bpchar
LEFT JOIN com_group_smbd b ON b.group_code::text = "substring"(a.ppi_code::text, 1, 3);


-- public.vw_prc_plan_item_sap source

CREATE OR REPLACE VIEW public.vw_prc_plan_item_sap
AS SELECT a.smbd_code AS smbd_catalog_code,
b.ppm_id,
a.group_smbd_name,
a.group_smbd_code,
a.smbd_code,
a.smbd_name,
a.unit,
a.currency,
a.price,
a.ppis_pr_number,
a.ppis_pr_item,
a.ppis_delivery_date,
a.ppis_pr_type,
"substring"((a.price::double precision * sum(COALESCE(a.smbd_quantity, 0::numeric::double precision)))::numeric::money::text, 2, 50) AS jumlah,
sum(COALESCE(a.smbd_quantity, 0::double precision)) AS smbd_quantity,
c.ppv_remain,
a.spk_code,
round(sum(COALESCE(a.smbd_quantity, 0::double precision))) AS ppv_max,
a.is_matgis,
a.ppis_cat_tech,
a.ppis_acc_assig
FROM prc_plan_integrasi a
LEFT JOIN prc_plan_main b ON b.ppm_project_id::text = a.spk_code::text
LEFT JOIN ( SELECT DISTINCT ON (ppv.ppv_smbd_code) ppv.ppm_id,
ppv.ppv_remain,
ppv.ppv_smbd_code
FROM prc_plan_volume ppv
JOIN prc_plan_main ppm ON ppm.ppm_id = ppv.ppm_id
ORDER BY ppv.ppv_smbd_code, ppv.ppv_id DESC) c ON c.ppm_id = b.ppm_id AND a.smbd_code::text = c.ppv_smbd_code::text
GROUP BY a.smbd_code, b.ppm_id, a.group_smbd_name, a.ppis_cat_tech, a.ppis_acc_assig, a.group_smbd_code, a.smbd_name, a.unit, a.price, a.ppis_pr_number, a.ppis_pr_item, a.ppis_delivery_date, a.ppis_pr_type, a.spk_code, a.currency, c.ppv_remain, a.is_matgis
UNION ALL
SELECT a.ppi_code AS smbd_catalog_code,
a.ppm_id,
b.group_name AS group_smbd_name,
"substring"(a.ppi_code::text, 1, 3) AS group_smbd_code,
a.ppi_code AS smbd_code,
a.ppi_item_desc AS smbd_name,
a.ppi_satuan AS unit,
''::character varying AS currency,
a.ppi_harga AS price,
a.ppis_pr_number,
a.ppis_pr_item,
a.ppis_delivery_date,
a.ppis_pr_type,
ROW(a.ppi_harga::double precision * a.ppi_jumlah, 2, 50)::text AS jumlah,
a.ppi_jumlah AS smbd_quantity,
c.ppv_remain,
NULL::character varying AS spk_code,
a.ppi_jumlah AS ppv_max,
b.is_matgis,
a.ppis_cat_tech,
a.ppis_acc_assig
FROM prc_plan_item a
LEFT JOIN ( SELECT DISTINCT ON (ppv.ppv_smbd_code) ppv.ppm_id,
ppv.ppv_remain,
ppv.ppv_smbd_code
FROM prc_plan_volume ppv
JOIN prc_plan_main ppm ON ppm.ppm_id = ppv.ppm_id
ORDER BY ppv.ppv_smbd_code, ppv.ppv_id DESC) c ON c.ppm_id = a.ppm_id AND a.ppi_code::text = c.ppv_smbd_code::text
LEFT JOIN com_group_smbd b ON b.group_code::text = "substring"(a.ppi_code::text, 1, 3);


-- public.vw_prc_matgis_header_detail source

CREATE OR REPLACE VIEW public.vw_prc_matgis_header_detail
AS SELECT h.ppm_id,
h.ppm_subject_of_work,
h.ppm_scope_of_work,
h.ppm_district_id,
h.ppm_district_name,
h.ppm_dept_id,
h.ppm_dept_name,
h.ppm_planner,
h.ppm_planner_pos_code,
h.ppm_planner_pos_name,
h.ppm_status,
h.ppm_tender_method,
h.ppm_contract_type,
h.ppm_attachment1,
h.ppm_attachment2,
h.ppm_attachment3,
h.ppm_attachment4,
h.ppm_attachment5,
h.ppm_mata_anggaran,
h.ppm_nama_mata_anggaran,
h.ppm_sub_mata_anggaran,
h.ppm_nama_sub_mata_anggaran,
h.ppm_pagu_anggaran,
h.ppm_renc_kebutuhan,
h.ppm_renc_pelaksanaan,
h.ppm_id_lokasi_pengiriman,
h.ppm_lokasi_pengiriman,
h.ppm_swakelola,
h.ppm_sisa_anggaran,
h.ppm_penata_perencanaan,
h.ppm_pp_pos_code,
h.ppm_pp_pos_name,
h.ppm_currency,
h.ppm_keterangan_tambahan,
h.ppm_komentar,
h.ppm_created_date,
h.ppm_status_activity,
h.ppm_ppn,
h.ppm_kode_rencana,
h.ppm_approved_date,
h.ppm_approved_pos_code,
h.ppm_approved_pos_name,
h.ppm_planner_id,
h.ppm_type_of_plan,
h.ppm_project_name,
h.ppm_next_pos_id,
h.ppm_project_id,
h.ppm_is_integrated,
d.ppi_item_type,
d.ppi_item_desc,
d.ppi_budget_source,
d.ppi_budget_value,
d.ppi_required_date,
d.ppi_attachment,
d.ppi_execution_schedule,
d.ppi_execution_date,
d.ppi_satuan,
d.ppi_mata_uang,
d.ppi_jumlah,
d.ppi_harga,
d.ppi_code,
d.ppi_tujuan,
d.ppi_id,
d.ppi_harga::double precision * d.ppi_jumlah AS ppi_total
FROM prc_plan_item d
JOIN prc_plan_main h ON h.ppm_id = d.ppm_id;


-- public.vw_prc_plan_main source

CREATE OR REPLACE VIEW public.vw_prc_plan_main
AS SELECT prc_plan_main.ppm_id,
prc_plan_main.ppm_type_of_plan,
prc_plan_main.ppm_project_id,
prc_plan_main.ppm_project_name,
prc_plan_main.ppm_subject_of_work,
prc_plan_main.ppm_scope_of_work,
prc_plan_main.ppm_district_id,
prc_plan_main.ppm_district_name,
prc_plan_main.ppm_dept_id,
prc_plan_main.ppm_dept_name,
prc_plan_main.ppm_planner,
prc_plan_main.ppm_planner_pos_code,
prc_plan_main.ppm_planner_pos_name,
prc_plan_main.ppm_status,
CASE COALESCE(prc_plan_main.ppm_status)
WHEN 0 THEN 'Simpan Sementara'::text
WHEN 1 THEN 'Belum Disetujui'::text
WHEN 2 THEN 'Telah Disetujui User'::text
WHEN 3 THEN concat('Telah Disetujui ', initcap((( SELECT vw_adm_pos.pos_name
FROM vw_adm_pos
WHERE vw_adm_pos.pos_id = (( SELECT prc_plan_comment.pos_id
FROM prc_plan_comment
WHERE prc_plan_comment.ppm_id = prc_plan_main.ppm_id
ORDER BY prc_plan_comment.comment_id DESC
LIMIT 1))
LIMIT 1))::text), ' ',
CASE prc_plan_main.ppm_is_integrated
WHEN 1 THEN '(PMCS)'::text
WHEN 2 THEN '(SIMDIV)'::text
ELSE ''::text
END)
WHEN 4 THEN 'Revisi'::text
ELSE NULL::text
END AS ppm_status_name,
prc_plan_main.ppm_tender_method,
prc_plan_main.ppm_contract_type,
prc_plan_main.ppm_attachment1,
prc_plan_main.ppm_attachment2,
prc_plan_main.ppm_attachment3,
prc_plan_main.ppm_attachment4,
prc_plan_main.ppm_attachment5,
prc_plan_main.ppm_mata_anggaran,
prc_plan_main.ppm_nama_mata_anggaran,
prc_plan_main.ppm_sub_mata_anggaran,
prc_plan_main.ppm_nama_sub_mata_anggaran,
prc_plan_main.ppm_pagu_anggaran,
CASE
WHEN prc_plan_main.ppm_sub_mata_anggaran::text = 0::text THEN ( SELECT array_to_string(array_agg(concat(prc_plan_project_cost.coa_name, '(', prc_plan_project_cost.coa_code, ')')), ' , '::text, ''::text) AS array_to_string
FROM prc_plan_project_cost
WHERE prc_plan_project_cost.spk_code::text = prc_plan_main.ppm_project_id::text)
ELSE concat(prc_plan_main.ppm_nama_sub_mata_anggaran, ' (', prc_plan_main.ppm_sub_mata_anggaran, ')')
END AS coa,
prc_plan_main.ppm_renc_kebutuhan,
concat(
CASE char_length(prc_plan_main.ppm_renc_kebutuhan::text)
WHEN 8 THEN concat(substr(prc_plan_main.ppm_renc_kebutuhan::text, 7, 2), ' ')
ELSE ''::text
END,
CASE substr(prc_plan_main.ppm_renc_kebutuhan::text, 5, 2)
WHEN '01'::text THEN 'January'::text
WHEN '02'::text THEN 'February'::text
WHEN '03'::text THEN 'March'::text
WHEN '04'::text THEN 'April'::text
WHEN '05'::text THEN 'May'::text
WHEN '06'::text THEN 'June'::text
WHEN '07'::text THEN 'July'::text
WHEN '08'::text THEN 'August'::text
WHEN '09'::text THEN 'September'::text
WHEN '10'::text THEN 'October'::text
WHEN '11'::text THEN 'November'::text
WHEN '12'::text THEN 'December'::text
ELSE NULL::text
END, ' ', substr(prc_plan_main.ppm_renc_kebutuhan::text, 1, 4)) AS ppm_renc_kebutuhan_vw,
prc_plan_main.ppm_renc_pelaksanaan,
concat(
CASE char_length(prc_plan_main.ppm_renc_pelaksanaan::text)
WHEN 8 THEN concat(substr(prc_plan_main.ppm_renc_pelaksanaan::text, 7, 2), ' ')
ELSE ''::text
END,
CASE COALESCE(substr(prc_plan_main.ppm_renc_pelaksanaan::text, 5, 2))
WHEN '01'::text THEN 'January'::text
WHEN '02'::text THEN 'February'::text
WHEN '03'::text THEN 'March'::text
WHEN '04'::text THEN 'April'::text
WHEN '05'::text THEN 'May'::text
WHEN '06'::text THEN 'June'::text
WHEN '07'::text THEN 'July'::text
WHEN '08'::text THEN 'August'::text
WHEN '09'::text THEN 'September'::text
WHEN '10'::text THEN 'October'::text
WHEN '11'::text THEN 'November'::text
WHEN '12'::text THEN 'December'::text
ELSE NULL::text
END, ' ', substr(prc_plan_main.ppm_renc_pelaksanaan::text, 1, 4)) AS ppm_renc_pelaksanaan_vw,
prc_plan_main.ppm_id_lokasi_pengiriman,
prc_plan_main.ppm_lokasi_pengiriman,
prc_plan_main.ppm_swakelola,
prc_plan_main.ppm_sisa_anggaran,
prc_plan_main.ppm_penata_perencanaan,
prc_plan_main.ppm_pp_pos_code,
prc_plan_main.ppm_pp_pos_name,
prc_plan_main.ppm_currency,
prc_plan_main.ppm_keterangan_tambahan,
prc_plan_main.ppm_komentar,
prc_plan_main.ppm_created_date,
to_char(prc_plan_main.ppm_created_date, 'DD/MM/YYYY HH24:MI:ss'::text) AS ppm_created_date_vw,
prc_plan_main.ppm_status_activity,
prc_plan_main.ppm_ppn,
prc_plan_main.ppm_kode_rencana,
prc_plan_main.ppm_approved_date,
prc_plan_main.ppm_approved_pos_code,
prc_plan_main.ppm_approved_pos_name,
prc_plan_main.ppm_planner_id,
prc_plan_main.ppm_next_pos_id,
prc_plan_main.ppm_is_integrated,
CASE prc_plan_main.ppm_type_of_plan
WHEN 'rkp'::text THEN 'RKP'::text
WHEN 'rkap'::text THEN 'RKAP'::text
WHEN 'rkp_matgis'::text THEN 'RKP Matgis'::text
ELSE NULL::text
END AS ppm_type_of_plan2
FROM prc_plan_main;



-- public.vw_lap_plan source

CREATE OR REPLACE VIEW public.vw_lap_plan
AS SELECT vw_prc_plan_main.ppm_id,
vw_prc_plan_main.ppm_type_of_plan,
vw_prc_plan_main.ppm_project_id,
vw_prc_plan_main.ppm_project_name,
vw_prc_plan_main.ppm_subject_of_work,
vw_prc_plan_main.ppm_scope_of_work,
vw_prc_plan_main.ppm_district_id,
vw_prc_plan_main.ppm_district_name,
vw_prc_plan_main.ppm_dept_id,
vw_prc_plan_main.ppm_dept_name,
vw_prc_plan_main.ppm_planner,
vw_prc_plan_main.ppm_planner_pos_code,
vw_prc_plan_main.ppm_planner_pos_name,
vw_prc_plan_main.ppm_status,
vw_prc_plan_main.ppm_status_name,
vw_prc_plan_main.ppm_tender_method,
vw_prc_plan_main.ppm_contract_type,
vw_prc_plan_main.ppm_attachment1,
vw_prc_plan_main.ppm_attachment2,
vw_prc_plan_main.ppm_attachment3,
vw_prc_plan_main.ppm_attachment4,
vw_prc_plan_main.ppm_attachment5,
vw_prc_plan_main.ppm_mata_anggaran,
vw_prc_plan_main.ppm_nama_mata_anggaran,
vw_prc_plan_main.ppm_sub_mata_anggaran,
vw_prc_plan_main.ppm_nama_sub_mata_anggaran,
vw_prc_plan_main.ppm_pagu_anggaran,
vw_prc_plan_main.coa,
vw_prc_plan_main.ppm_renc_kebutuhan,
vw_prc_plan_main.ppm_renc_kebutuhan_vw,
vw_prc_plan_main.ppm_renc_pelaksanaan,
vw_prc_plan_main.ppm_renc_pelaksanaan_vw,
vw_prc_plan_main.ppm_id_lokasi_pengiriman,
vw_prc_plan_main.ppm_lokasi_pengiriman,
vw_prc_plan_main.ppm_swakelola,
vw_prc_plan_main.ppm_sisa_anggaran,
vw_prc_plan_main.ppm_penata_perencanaan,
vw_prc_plan_main.ppm_pp_pos_code,
vw_prc_plan_main.ppm_pp_pos_name,
vw_prc_plan_main.ppm_currency,
vw_prc_plan_main.ppm_keterangan_tambahan,
vw_prc_plan_main.ppm_komentar,
vw_prc_plan_main.ppm_created_date,
vw_prc_plan_main.ppm_created_date_vw,
vw_prc_plan_main.ppm_status_activity,
vw_prc_plan_main.ppm_ppn,
vw_prc_plan_main.ppm_kode_rencana,
vw_prc_plan_main.ppm_approved_date,
vw_prc_plan_main.ppm_approved_pos_code,
vw_prc_plan_main.ppm_approved_pos_name,
vw_prc_plan_main.ppm_planner_id,
vw_prc_plan_main.ppm_next_pos_id,
vw_prc_plan_main.ppm_is_integrated,
adm_coa.ac_id,
adm_coa.ac_mata_anggaran,
adm_coa.ac_sub_mata_anggaran,
adm_coa.ac_kode_sub_mata_anggaran,
adm_coa.ac_coa,
adm_coa.ac_nama_coa,
adm_coa.ac_tahun,
adm_coa.ac_beban,
project_info.kode_spk,
CASE project_info.is_jo
WHEN 't'::text THEN 'JO'::text
ELSE 'Non JO'::text
END AS is_jo,
project_info.lokasi
FROM vw_prc_plan_main
LEFT JOIN adm_coa ON vw_prc_plan_main.ppm_sub_mata_anggaran::text = adm_coa.ac_coa::text
LEFT JOIN project_info ON project_info.kode_spk::text = vw_prc_plan_main.ppm_project_id::text
WHERE vw_prc_plan_main.ppm_is_integrated = ANY (ARRAY[1, 2])
ORDER BY vw_prc_plan_main.ppm_id;



-- public.vw_lap_rari source

CREATE OR REPLACE VIEW public.vw_lap_rari
AS SELECT a.ppm_id,
a.ppm_type_of_plan,
a.ppm_project_id,
a.ppm_project_name,
a.ppm_subject_of_work,
a.ppm_scope_of_work,
a.ppm_district_id,
a.ppm_district_name,
a.ppm_dept_id,
a.ppm_dept_name,
a.ppm_planner,
a.ppm_planner_pos_code,
a.ppm_planner_pos_name,
a.ppm_status,
a.ppm_status_name,
a.ppm_tender_method,
a.ppm_contract_type,
a.ppm_attachment1,
a.ppm_attachment2,
a.ppm_attachment3,
a.ppm_attachment4,
a.ppm_attachment5,
a.ppm_mata_anggaran,
a.ppm_nama_mata_anggaran,
a.ppm_sub_mata_anggaran,
a.ppm_nama_sub_mata_anggaran,
a.ppm_pagu_anggaran,
a.coa,
a.ppm_renc_kebutuhan,
a.ppm_renc_kebutuhan_vw,
a.ppm_renc_pelaksanaan,
a.ppm_renc_pelaksanaan_vw,
a.ppm_id_lokasi_pengiriman,
a.ppm_lokasi_pengiriman,
a.ppm_swakelola,
a.ppm_sisa_anggaran,
a.ppm_penata_perencanaan,
a.ppm_pp_pos_code,
a.ppm_pp_pos_name,
a.ppm_currency,
a.ppm_keterangan_tambahan,
a.ppm_komentar,
a.ppm_created_date,
a.ppm_created_date_vw,
a.ppm_status_activity,
a.ppm_ppn,
a.ppm_kode_rencana,
a.ppm_approved_date,
a.ppm_approved_pos_code,
a.ppm_approved_pos_name,
a.ppm_planner_id,
a.ppm_next_pos_id,
a.ppm_is_integrated,
a.ac_id,
a.ac_mata_anggaran,
a.ac_sub_mata_anggaran,
a.ac_kode_sub_mata_anggaran,
a.ac_coa,
a.ac_nama_coa,
a.ac_tahun,
a.ac_beban,
a.kode_spk,
a.is_jo,
a.lokasi,
( SELECT sum(x.hps) AS sum
FROM vw_lap_tender x
WHERE x.ppm_id = a.ppm_id) AS total_rfq
FROM vw_lap_plan a;



-- public.vw_lap_plan source

CREATE OR REPLACE VIEW public.vw_lap_plan
AS SELECT vw_prc_plan_main.ppm_id,
vw_prc_plan_main.ppm_type_of_plan,
vw_prc_plan_main.ppm_project_id,
vw_prc_plan_main.ppm_project_name,
vw_prc_plan_main.ppm_subject_of_work,
vw_prc_plan_main.ppm_scope_of_work,
vw_prc_plan_main.ppm_district_id,
vw_prc_plan_main.ppm_district_name,
vw_prc_plan_main.ppm_dept_id,
vw_prc_plan_main.ppm_dept_name,
vw_prc_plan_main.ppm_planner,
vw_prc_plan_main.ppm_planner_pos_code,
vw_prc_plan_main.ppm_planner_pos_name,
vw_prc_plan_main.ppm_status,
vw_prc_plan_main.ppm_status_name,
vw_prc_plan_main.ppm_tender_method,
vw_prc_plan_main.ppm_contract_type,
vw_prc_plan_main.ppm_attachment1,
vw_prc_plan_main.ppm_attachment2,
vw_prc_plan_main.ppm_attachment3,
vw_prc_plan_main.ppm_attachment4,
vw_prc_plan_main.ppm_attachment5,
vw_prc_plan_main.ppm_mata_anggaran,
vw_prc_plan_main.ppm_nama_mata_anggaran,
vw_prc_plan_main.ppm_sub_mata_anggaran,
vw_prc_plan_main.ppm_nama_sub_mata_anggaran,
vw_prc_plan_main.ppm_pagu_anggaran,
vw_prc_plan_main.coa,
vw_prc_plan_main.ppm_renc_kebutuhan,
vw_prc_plan_main.ppm_renc_kebutuhan_vw,
vw_prc_plan_main.ppm_renc_pelaksanaan,
vw_prc_plan_main.ppm_renc_pelaksanaan_vw,
vw_prc_plan_main.ppm_id_lokasi_pengiriman,
vw_prc_plan_main.ppm_lokasi_pengiriman,
vw_prc_plan_main.ppm_swakelola,
vw_prc_plan_main.ppm_sisa_anggaran,
vw_prc_plan_main.ppm_penata_perencanaan,
vw_prc_plan_main.ppm_pp_pos_code,
vw_prc_plan_main.ppm_pp_pos_name,
vw_prc_plan_main.ppm_currency,
vw_prc_plan_main.ppm_keterangan_tambahan,
vw_prc_plan_main.ppm_komentar,
vw_prc_plan_main.ppm_created_date,
vw_prc_plan_main.ppm_created_date_vw,
vw_prc_plan_main.ppm_status_activity,
vw_prc_plan_main.ppm_ppn,
vw_prc_plan_main.ppm_kode_rencana,
vw_prc_plan_main.ppm_approved_date,
vw_prc_plan_main.ppm_approved_pos_code,
vw_prc_plan_main.ppm_approved_pos_name,
vw_prc_plan_main.ppm_planner_id,
vw_prc_plan_main.ppm_next_pos_id,
vw_prc_plan_main.ppm_is_integrated,
adm_coa.ac_id,
adm_coa.ac_mata_anggaran,
adm_coa.ac_sub_mata_anggaran,
adm_coa.ac_kode_sub_mata_anggaran,
adm_coa.ac_coa,
adm_coa.ac_nama_coa,
adm_coa.ac_tahun,
adm_coa.ac_beban,
project_info.kode_spk,
CASE project_info.is_jo
WHEN 't'::text THEN 'JO'::text
ELSE 'Non JO'::text
END AS is_jo,
project_info.lokasi
FROM vw_prc_plan_main
LEFT JOIN adm_coa ON vw_prc_plan_main.ppm_sub_mata_anggaran::text = adm_coa.ac_coa::text
LEFT JOIN project_info ON project_info.kode_spk::text = vw_prc_plan_main.ppm_project_id::text
WHERE vw_prc_plan_main.ppm_is_integrated = ANY (ARRAY[1, 2])
ORDER BY vw_prc_plan_main.ppm_id;


-- public.vw_job_proc source

CREATE OR REPLACE VIEW public.vw_job_proc
AS SELECT p.id,
p.pos_id,
ap.pos_name,
p.number,
p.type,
p.status,
p.activity,
p."time",
p.url,
p.employee_id
FROM ( SELECT plan.ppm_id AS id,
plan.ppm_next_pos_id AS pos_id,
plan.ppm_subject_of_work AS number,
CASE COALESCE(plan.ppm_type_of_plan)
WHEN 'rkp'::text THEN 'Proyek'::text
WHEN 'rkp_matgis'::text THEN 'Proyek Matgis'::text
WHEN 'rkap'::text THEN 'Non Proyek'::text
ELSE NULL::text
END AS type,
plan.ppm_status AS status,
plan.ppm_status_name AS activity,
to_timestamp(plan.ppm_created_date_vw, 'DD/MM/YYYY hh24:mi:ss'::text)::timestamp without time zone AS "time",
'procurement/perencanaan_pengadaan/rekapitulasi_perencanaan_pengadaan/approval/'::text AS url,
NULL::text AS employee_id
FROM vw_prc_plan_main plan
WHERE plan.ppm_status <> 3
UNION
SELECT paket.ppc_id AS id,
paket.ppc_pos_code AS pos_id,
paket.pr_number AS number,
paket.jenis_pengadaan AS type,
paket.pr_status AS status,
paket.awa_name AS activity,
to_timestamp(paket.waktu, 'DD/MM/YYYY hh24:mi:ss'::text)::timestamp without time zone AS "time",
'procurement/daftar_pekerjaan/proses/'::text AS url,
NULL::text AS employee_id
FROM vw_daftar_pekerjaan_pr paket
WHERE paket.ppc_activity <> 1028 AND paket.pr_status <> 1012
UNION
SELECT jpaket.ppc_id AS id,
jpaket.ppc_pos_code AS pos_id,
jpaket.pr_number AS number,
jpaket.jenis_pengadaan AS type,
jpaket.pr_status AS status,
jpaket.awa_name AS activity,
to_timestamp(jpaket.waktu, 'DD/MM/YYYY hh24:mi:ss'::text)::timestamp without time zone AS "time",
'procurement/daftar_pekerjaan/proses/'::text AS url,
jpaket.pr_buyer_id::text AS employee_id
FROM vw_daftar_pekerjaan_pr jpaket
WHERE jpaket.ppc_activity <> 1028 AND jpaket.pr_status = 1012
UNION
SELECT rfq.ptc_id AS id,
rfq.ptc_pos_code AS pos_id,
rfq.ptm_number AS number,
rfq.jenis_pengadaan AS type,
rfq.ptm_status AS status,
rfq.activity,
to_timestamp(rfq.waktu, 'YYYY-MM-DD hh24:mi:ss'::text)::timestamp without time zone AS "time",
'procurement/daftar_pekerjaan/proses_tender/'::text AS url,
NULL::text AS employee_id
FROM vw_daftar_pekerjaan_rfq_ rfq
WHERE rfq.ptm_status < 1901 AND rfq.ptc_user IS NULL) p
JOIN adm_pos ap ON ap.pos_id = p.pos_id
ORDER BY p."time" DESC;



-- public.vw_job_all source

CREATE OR REPLACE VIEW public.vw_job_all
AS SELECT j.id,
j.pos_id,
j.pos_name,
j.number,
j."time",
j.activity,
j.icon,
j.url,
j.employee_id
FROM ( SELECT p.id::text AS id,
p.pos_id,
p.pos_name,
p.number,
p."time",
p.activity,
'fa fa-laptop'::text AS icon,
p.url,
p.employee_id
FROM vw_job_proc p
UNION
SELECT c.id::text AS id,
c.pos_id,
c.pos_name,
c.number,
c."time",
c.activity,
'fa fa-bars'::text AS icon,
c.url,
NULL::text AS employee_id
FROM vw_job_ctr c
UNION
SELECT vw_job_uskep_privy.id::text AS id,
vw_job_uskep_privy.adm_pos_id AS pos_id,
vw_job_uskep_privy.pos_name,
vw_job_uskep_privy.rfq_no AS number,
now() AS "time",
'Tanda Tangan Uskep Privy'::text AS activity,
'fa fa-laptop'::text AS icon,
vw_job_uskep_privy.url,
vw_job_uskep_privy.employeeid::text AS employee_id
FROM vw_job_uskep_privy
UNION
SELECT k.id,
k.pos_id::bigint AS pos_id,
k.pos_name,
k."desc" AS number,
k."time",
k.activity,
'fa fa-tags'::text AS icon,
k.url,
NULL::text AS employee_id
FROM vw_job_com k
UNION
SELECT v.id::text AS id,
v.pos_id,
v.pos_name,
v."desc" AS number,
v."time",
v.activity,
'fa fa-university'::text AS icon,
v.url,
NULL::text AS employee_id
FROM vw_job_vnd v
UNION
SELECT vnd_doc_pq.vdp_id::text AS id,
vnd_doc_pq.vdp_pos_id AS pos_id,
adm_pos.pos_name,
concat(vnd_doc_pq.vendor_id::text, ' - ', vnd_header.vendor_name) AS number,
vnd_doc_pq.updated_datetime AS "time",
CASE vnd_doc_pq.vdp_status
WHEN '-1'::text THEN 'Revisi PQ/Tambahan'::text
WHEN '0'::text THEN 'Menunggu Upload Dokumen PQ/Tambahan'::text
WHEN '1'::text THEN 'Menunggu Verifikasi Dokumen PQ/Tambahan'::text
WHEN '2'::text THEN 'Dokumen PQ/Tambahan Sudah Diverifikasi'::text
ELSE NULL::text
END AS activity,
'fa fa-laptop'::text AS icon,
'vendor/verifikasi_dokumen_pq/'::text AS url,
NULL::text AS employee_id
FROM vnd_doc_pq
LEFT JOIN vnd_type_master ON vnd_type_master.vtm_id = vnd_doc_pq.vtm_id
LEFT JOIN vnd_header ON vnd_header.vendor_id = vnd_doc_pq.vendor_id
LEFT JOIN adm_pos ON adm_pos.pos_id = vnd_doc_pq.vdp_pos_id
WHERE vnd_doc_pq.vdp_status::text = '1'::text) j
ORDER BY j."time" DESC;



-- public.vw_prc_plan_main_v2 source

CREATE OR REPLACE VIEW public.vw_prc_plan_main_v2
AS SELECT prc_plan_main.ppm_id,
prc_plan_main.ppm_type_of_plan,
prc_plan_main.ppm_project_id,
prc_plan_main.ppm_project_name,
prc_plan_main.ppm_subject_of_work,
prc_plan_main.ppm_scope_of_work,
prc_plan_main.ppm_district_id,
prc_plan_main.ppm_district_name,
prc_plan_main.ppm_dept_id,
prc_plan_main.ppm_dept_name,
prc_plan_main.ppm_planner,
prc_plan_main.ppm_planner_pos_code,
prc_plan_main.ppm_planner_pos_name,
prc_plan_main.ppm_status,
CASE COALESCE(prc_plan_main.ppm_status)
WHEN 0 THEN 'Simpan Sementara'::text
WHEN 1 THEN 'Belum Disetujui'::text
WHEN 2 THEN 'Telah Disetujui User'::text
WHEN 3 THEN concat('Telah Disetujui ', initcap((( SELECT vw_adm_pos.pos_name
FROM vw_adm_pos
WHERE vw_adm_pos.pos_id = (( SELECT prc_plan_comment.pos_id
FROM prc_plan_comment
WHERE prc_plan_comment.ppm_id = prc_plan_main.ppm_id
ORDER BY prc_plan_comment.comment_id DESC
LIMIT 1))
LIMIT 1))::text), ' ',
CASE prc_plan_main.ppm_is_integrated
WHEN 1 THEN '(PMCS)'::text
WHEN 2 THEN '(SIMDIV)'::text
ELSE ''::text
END)
WHEN 4 THEN 'Revisi'::text
ELSE NULL::text
END AS ppm_status_name,
prc_plan_main.ppm_tender_method,
prc_plan_main.ppm_contract_type,
prc_plan_main.ppm_attachment1,
prc_plan_main.ppm_attachment2,
prc_plan_main.ppm_attachment3,
prc_plan_main.ppm_attachment4,
prc_plan_main.ppm_attachment5,
prc_plan_main.ppm_mata_anggaran,
prc_plan_main.ppm_nama_mata_anggaran,
prc_plan_main.ppm_sub_mata_anggaran,
prc_plan_main.ppm_nama_sub_mata_anggaran,
prc_plan_main.ppm_pagu_anggaran,
CASE
WHEN prc_plan_main.ppm_sub_mata_anggaran::text = 0::text THEN ( SELECT array_to_string(array_agg(concat(prc_plan_project_cost.coa_name, '(', prc_plan_project_cost.coa_code, ')')), ' , '::text, ''::text) AS array_to_string
FROM prc_plan_project_cost
WHERE prc_plan_project_cost.spk_code::text = prc_plan_main.ppm_project_id::text)
ELSE concat(prc_plan_main.ppm_nama_sub_mata_anggaran, ' (', prc_plan_main.ppm_sub_mata_anggaran, ')')
END AS coa,
prc_plan_main.ppm_renc_kebutuhan,
concat(
CASE char_length(prc_plan_main.ppm_renc_kebutuhan::text)
WHEN 8 THEN concat(substr(prc_plan_main.ppm_renc_kebutuhan::text, 7, 2), ' ')
ELSE ''::text
END,
CASE substr(prc_plan_main.ppm_renc_kebutuhan::text, 5, 2)
WHEN '01'::text THEN 'January'::text
WHEN '02'::text THEN 'February'::text
WHEN '03'::text THEN 'March'::text
WHEN '04'::text THEN 'April'::text
WHEN '05'::text THEN 'May'::text
WHEN '06'::text THEN 'June'::text
WHEN '07'::text THEN 'July'::text
WHEN '08'::text THEN 'August'::text
WHEN '09'::text THEN 'September'::text
WHEN '10'::text THEN 'October'::text
WHEN '11'::text THEN 'November'::text
WHEN '12'::text THEN 'December'::text
ELSE NULL::text
END, ' ', substr(prc_plan_main.ppm_renc_kebutuhan::text, 1, 4)) AS ppm_renc_kebutuhan_vw,
prc_plan_main.ppm_renc_pelaksanaan,
concat(
CASE char_length(prc_plan_main.ppm_renc_pelaksanaan::text)
WHEN 8 THEN concat(substr(prc_plan_main.ppm_renc_pelaksanaan::text, 7, 2), ' ')
ELSE ''::text
END,
CASE COALESCE(substr(prc_plan_main.ppm_renc_pelaksanaan::text, 5, 2))
WHEN '01'::text THEN 'January'::text
WHEN '02'::text THEN 'February'::text
WHEN '03'::text THEN 'March'::text
WHEN '04'::text THEN 'April'::text
WHEN '05'::text THEN 'May'::text
WHEN '06'::text THEN 'June'::text
WHEN '07'::text THEN 'July'::text
WHEN '08'::text THEN 'August'::text
WHEN '09'::text THEN 'September'::text
WHEN '10'::text THEN 'October'::text
WHEN '11'::text THEN 'November'::text
WHEN '12'::text THEN 'December'::text
ELSE NULL::text
END, ' ', substr(prc_plan_main.ppm_renc_pelaksanaan::text, 1, 4)) AS ppm_renc_pelaksanaan_vw,
prc_plan_main.ppm_id_lokasi_pengiriman,
prc_plan_main.ppm_lokasi_pengiriman,
prc_plan_main.ppm_swakelola,
prc_plan_main.ppm_sisa_anggaran,
prc_plan_main.ppm_penata_perencanaan,
prc_plan_main.ppm_pp_pos_code,
prc_plan_main.ppm_pp_pos_name,
prc_plan_main.ppm_currency,
prc_plan_main.ppm_keterangan_tambahan,
prc_plan_main.ppm_komentar,
prc_plan_main.ppm_created_date,
to_char(prc_plan_main.ppm_created_date, 'DD/MM/YYYY HH24:MI:ss'::text) AS ppm_created_date_vw,
prc_plan_main.ppm_status_activity,
prc_plan_main.ppm_ppn,
prc_plan_main.ppm_kode_rencana,
prc_plan_main.ppm_approved_date,
prc_plan_main.ppm_approved_pos_code,
prc_plan_main.ppm_approved_pos_name,
prc_plan_main.ppm_planner_id,
prc_plan_main.ppm_next_pos_id,
prc_plan_main.ppm_is_sap,
prc_plan_main.ppm_is_integrated,
prc_plan_main.ppms_project_desc,
prc_plan_main.ppms_start_date,
prc_plan_main.ppms_finish_date,
prc_plan_main.ppms_project_id,
CASE prc_plan_main.ppm_type_of_plan
WHEN 'rkp'::text THEN 'RKP'::text
WHEN 'rkap'::text THEN 'RKAP'::text
WHEN 'rkp_matgis'::text THEN 'RKP Matgis'::text
ELSE NULL::text
END AS ppm_type_of_plan2
FROM prc_plan_main;


-- public.vw_map_chart source

CREATE OR REPLACE VIEW public.vw_map_chart
AS SELECT project_info.kode_spk,
project_info.nama_spk_full AS nama_proyek,
b.ppm_dept_name AS dept_name,
project_info.alamatproyek,
project_info.latitude AS lat,
project_info.longitude AS lon,
project_info.omset,
b.ppm_pagu_anggaran AS nilai_perencanaan_pengadaan,
( SELECT count(ptm.ptm_number) AS count
FROM prc_tender_main ptm
JOIN prc_pr_main prm ON prm.pr_number::text = ptm.pr_number::text
JOIN prc_plan_main ppm ON ppm.ppm_id = prm.ppm_id
WHERE ppm.ppm_project_id::text = project_info.kode_spk::text) AS jumlah_rfq
FROM project_info
JOIN prc_plan_main b ON b.ppm_project_id::text = project_info.kode_spk::text;



-- public.vw_prc_plan_volume source

CREATE OR REPLACE VIEW public.vw_prc_plan_volume
AS SELECT a.ppv_id,
a.ppm_id,
a.ppv_main,
a.ppv_remain,
a.ppv_plus,
a.ppv_minus,
a.ppv_activity,
a.ppv_no,
a.created_datetime,
a.ppv_smbd_code,
( SELECT DISTINCT prc_plan_integrasi.group_smbd_code
FROM prc_plan_integrasi
WHERE prc_plan_integrasi.smbd_code::text = "right"(a.ppv_smbd_code::text, 6)
LIMIT 1) AS group_smbd_code,
( SELECT DISTINCT prc_plan_integrasi.group_smbd_name
FROM prc_plan_integrasi
WHERE prc_plan_integrasi.smbd_code::text = "right"(a.ppv_smbd_code::text, 6)
LIMIT 1) AS group_smbd_name,
( SELECT DISTINCT prc_plan_integrasi.smbd_code
FROM prc_plan_integrasi
WHERE prc_plan_integrasi.smbd_code::text = "right"(a.ppv_smbd_code::text, 6)
LIMIT 1) AS smbd_code,
( SELECT DISTINCT prc_plan_integrasi.smbd_name
FROM prc_plan_integrasi
WHERE prc_plan_integrasi.smbd_code::text = "right"(a.ppv_smbd_code::text, 6)
LIMIT 1) AS smbd_name,
a.ppv_unit,
b.ppm_project_id AS spk_code,
COALESCE(c.awa_name, 'Pembuatan Volume Awal'::character varying) AS status,
a.ppv_prc
FROM prc_plan_volume a
JOIN prc_plan_main b ON b.ppm_id = a.ppm_id
LEFT JOIN adm_wkf_activity c ON c.awa_id::text = a.ppv_activity::text;



-- public.vw_prc_plan_volume_remain source

CREATE OR REPLACE VIEW public.vw_prc_plan_volume_remain
AS SELECT a.spk_code,
a.project_name,
a.dept_code,
a.dept_name,
a.group_smbd_code,
a.group_smbd_name,
a.smbd_type,
c.ppm_id,
a.smbd_code,
a.smbd_name,
a.unit,
a.smbd_quantity AS first_volume,
c.ppv_remain AS remain_volume,
a.periode_pengadaan
FROM prc_plan_integrasi a
LEFT JOIN prc_plan_main b ON b.ppm_project_id::text = a.spk_code::text
JOIN ( SELECT DISTINCT ON (ppv.ppv_smbd_code) ppv.ppm_id,
ppv.ppv_remain,
ppv.ppv_smbd_code
FROM prc_plan_volume ppv
JOIN prc_plan_main ppm ON ppm.ppm_id = ppv.ppm_id
ORDER BY ppv.ppv_smbd_code, ppv.ppv_id DESC) c ON c.ppm_id = b.ppm_id AND c.ppv_smbd_code::text = a.smbd_code::text;




-- public.vw_efisiensi_detail source

CREATE OR REPLACE VIEW public.vw_efisiensi_detail
AS SELECT a.ptm_number,
prc_tender_main.ptm_subject_of_work,
d.ppm_subject_of_work,
c.pr_packet,
prc_tender_main.ptm_dept_name,
prc_tender_main.ptm_dept_id,
e.tanggal_penunjukan,
CASE d.ppm_type_of_plan
WHEN 'rkp'::text THEN 'Proyek'::text
WHEN 'rkp_matgis'::text THEN 'Proyek Matgis'::text
ELSE 'Non Proyek'::text
END AS ppm_type_of_plan,
a.contract_amount,
a.hps,
d.ppm_project_name,
CASE f.ptp_tender_method
WHEN 0 THEN 'Penunjukkan Langsung'::text
WHEN 1 THEN 'Pemilihan Langsung'::text
WHEN 2 THEN 'Pelelangan'::text
ELSE '-'::text
END AS metode,
f.ptp_tender_method AS metode_id,
CASE f.ptp_submission_method
WHEN 0 THEN '1 Sampul'::text
WHEN 1 THEN '2 Sampul'::text
WHEN 2 THEN '2 Tahap'::text
ELSE '-'::text
END AS sampul,
CASE
WHEN a.total_rab > a.contract_amount::double precision THEN a.total_rab - a.contract_amount::double precision
ELSE 0::double precision
END AS efisiensi,
CASE
WHEN a.total_rab > a.contract_amount::double precision THEN (a.total_rab - a.contract_amount::double precision) / a.total_rab * 100::double precision
ELSE 0::double precision
END AS efisiensi_percent,
CASE
WHEN a.total_rab < a.contract_amount::double precision THEN a.contract_amount::double precision - a.total_rab
ELSE 0::double precision
END AS inefisiensi,
CASE
WHEN a.total_rab < a.contract_amount::double precision THEN (a.contract_amount::double precision - a.total_rab) / a.total_rab * 100::double precision
ELSE 0::double precision
END AS inefisiensi_percent,
pti.tit_price,
ppi.ppis_pr_number,
ppi.ppi_is_sap,
prc_tender_main.ctr_po_number
FROM vw_efisiensi a
LEFT JOIN prc_tender_main ON prc_tender_main.ptm_number::text = a.ptm_number::text
LEFT JOIN prc_pr_main c ON c.pr_number::text = prc_tender_main.pr_number::text
LEFT JOIN prc_plan_main d ON d.ppm_id = c.ppm_id
LEFT JOIN prc_plan_item ppi ON d.ppm_id = ppi.ppm_id
LEFT JOIN ( SELECT DISTINCT ON (prc_tender_comment.ptm_number) prc_tender_comment.ptm_number,
prc_tender_comment.ptc_start_date AS tanggal_penunjukan
FROM prc_tender_comment
WHERE prc_tender_comment.ptc_activity = 1180 OR prc_tender_comment.ptc_activity = 1181) e ON e.ptm_number::text = a.ptm_number::text
LEFT JOIN prc_tender_prep f ON f.ptm_number::text = a.ptm_number::text
LEFT JOIN prc_tender_item pti ON prc_tender_main.ptm_number::text = pti.ptm_number::text
WHERE prc_tender_main.ptm_status <> 1902 AND ppi.ppi_is_sap = 1;



-- public.vw_efisiensi_total source

CREATE OR REPLACE VIEW public.vw_efisiensi_total
AS SELECT sum(vw_efisiensi_detail.hps) AS hps,
sum(vw_efisiensi_detail.contract_amount) AS total_contract,
CASE
WHEN sum(vw_efisiensi_detail.hps) > sum(vw_efisiensi_detail.contract_amount)::double precision THEN sum(vw_efisiensi_detail.hps) - sum(vw_efisiensi_detail.contract_amount)::double precision
ELSE 0::double precision
END AS efisiensi,
CASE
WHEN sum(vw_efisiensi_detail.hps) > sum(vw_efisiensi_detail.contract_amount)::double precision THEN (sum(vw_efisiensi_detail.hps) - sum(vw_efisiensi_detail.contract_amount)::double precision) / sum(vw_efisiensi_detail.hps) * 100::double precision
ELSE 0::double precision
END AS efisiensi_percent,
CASE
WHEN sum(vw_efisiensi_detail.hps) < sum(vw_efisiensi_detail.contract_amount)::double precision THEN sum(vw_efisiensi_detail.contract_amount)::double precision - sum(vw_efisiensi_detail.hps)
ELSE 0::double precision
END AS inefisiensi,
CASE
WHEN sum(vw_efisiensi_detail.hps) < sum(vw_efisiensi_detail.contract_amount)::double precision THEN (sum(vw_efisiensi_detail.contract_amount)::double precision - sum(vw_efisiensi_detail.hps)) / sum(vw_efisiensi_detail.hps) * 100::double precision
ELSE 0::double precision
END AS inefisiensi_percent
FROM vw_efisiensi_detail;



-- public.vw_rata_durasi_proses_detail source

CREATE OR REPLACE VIEW public.vw_rata_durasi_proses_detail
AS SELECT b.ptm_number,
d.ppm_project_name,
b.ptm_subject_of_work,
b.ptm_dept_name,
a.ptp_tender_method AS metode_id,
CASE a.ptp_tender_method
WHEN 0 THEN 'Penunjukkan Langsung'::text
WHEN 1 THEN 'Pemilihan Langsung'::text
WHEN 2 THEN 'Pelelangan'::text
ELSE '-'::text
END AS metode,
b.ptm_created_date,
b.ptm_completed_date,
concat(NULLIF(round((date_part('day'::text, b.ptm_completed_date - b.ptm_created_date) + 1::double precision)::integer::numeric, 0), 0::numeric), ' hari') AS av,
CASE b.ptm_type_of_plan
WHEN 'rkp'::text THEN 'Proyek'::text
WHEN 'rkp_matgis'::text THEN 'Proyek Matgis'::text
ELSE 'Non Proyek'::text
END AS ptm_type_of_plan,
d.ppm_subject_of_work,
c.pr_packet
FROM prc_tender_prep a
LEFT JOIN prc_tender_main b ON a.ptm_number::text = b.ptm_number::text
LEFT JOIN prc_pr_main c ON b.pr_number::text = c.pr_number::text
LEFT JOIN prc_plan_main d ON c.ppm_id = d.ppm_id
WHERE a.ptp_tender_method IS NOT NULL AND b.ptm_completed_date IS NOT NULL AND b.ptm_status <> 1902 AND b.ptm_number::text <> 'RFQ.201811.00017'::text;
