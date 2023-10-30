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

-- public.vw_top_5_efisiensi_proyek source

CREATE OR REPLACE VIEW public.vw_top_5_efisiensi_proyek
AS SELECT b.ppm_project_id,
    b.project_name,
    b.ptm_dept_name,
    b.ptm_dept_id,
    b.contract_amount,
    b.hps,
        CASE
            WHEN b.hps > b.contract_amount::double precision THEN b.hps - b.contract_amount::double precision
            ELSE 0::double precision
        END AS efisiensi,
        CASE
            WHEN b.hps > b.contract_amount::double precision THEN (b.hps - b.contract_amount::double precision) / b.hps * 100::double precision
            ELSE 0::double precision
        END AS efisiensi_percent,
        CASE
            WHEN b.hps < b.contract_amount::double precision THEN b.contract_amount::double precision - b.hps
            ELSE 0::double precision
        END AS inefisiensi,
        CASE
            WHEN b.hps < b.contract_amount::double precision THEN (b.contract_amount::double precision - b.hps) / b.hps * 100::double precision
            ELSE 0::double precision
        END AS inefisiensi_percent
   FROM ( SELECT x.hps,
            sum(x.contract_amount) AS contract_amount,
            x.ptm_dept_name,
            x.ptm_dept_id,
            x.ppm_project_id,
            x.project_name
           FROM ( SELECT a.ptm_number,
                    a.ptm_subject_of_work,
                    a.ptm_dept_name,
                    a.ptm_dept_id,
                    a.contract_amount,
                    a.hps,
                    a.efisiensi,
                    a.efisiensi_percent,
                    a.inefisiensi,
                    a.inefisiensi_percent,
                    d.ppm_project_name AS project_name,
                    d.ppm_project_id
                   FROM vw_efisiensi a
                     LEFT JOIN prc_tender_main b_1 ON b_1.ptm_number::text = a.ptm_number::text
                     LEFT JOIN prc_pr_main c ON c.pr_number::text = b_1.pr_number::text
                     LEFT JOIN prc_plan_main d ON d.ppm_id = c.ppm_id
                  WHERE d.ppm_project_id IS NOT NULL) x
          GROUP BY x.hps, x.ptm_dept_name, x.ptm_dept_id, x.ppm_project_id, x.project_name) b
  ORDER BY (
        CASE
            WHEN b.hps > b.contract_amount::double precision THEN b.hps - b.contract_amount::double precision
            ELSE 0::double precision
        END) DESC, (
        CASE
            WHEN b.hps > b.contract_amount::double precision THEN (b.hps - b.contract_amount::double precision) / b.hps * 100::double precision
            ELSE 0::double precision
        END) DESC
 LIMIT 5;

-- public.vw_data_item_po_pmcs source

CREATE OR REPLACE VIEW public.vw_data_item_po_pmcs
AS SELECT DISTINCT a.po_number,
    a.po_id,
    COALESCE(COALESCE(h.group_smbd_code, i.smbd_rab), i.item_code) AS group_sumberdaya,
    COALESCE(i.smbd_rab, i.item_code::bpchar::character varying) AS kode_sumberdaya,
    i.qty AS volume_sumberdaya,
    i.uom AS satuan_sumberdaya,
    i.price AS harga_satuan,
    COALESCE(h.is_matgis, 'f'::bpchar) AS is_matgis
   FROM ctr_po_header a
     JOIN ctr_po_item i ON a.po_id = i.po_id
     LEFT JOIN ctr_wo_item pi ON a.po_id = pi.wo_id
     LEFT JOIN ctr_contract_header b_1 ON b_1.contract_id = a.contract_id
     LEFT JOIN prc_tender_main c ON b_1.ptm_number::text = c.ptm_number::text
     LEFT JOIN prc_pr_main d ON d.pr_number::text = c.pr_number::text
     LEFT JOIN prc_plan_main e ON e.ppm_id = d.ppm_id
     LEFT JOIN prc_plan_integrasi h ON h.spk_code::text = e.ppm_project_id::text AND h.smbd_code::text = i.item_code::text;

-- public.vw_data_po_pmcs source

CREATE OR REPLACE VIEW public.vw_data_po_pmcs
AS SELECT DISTINCT ON (a.po_id) a.po_id,
    COALESCE(b.contract_number, cph.sppm_number) AS no_kontrak,
    COALESCE(b.start_date, a.start_date) AS tanggal_mulai_kontrak,
    COALESCE(b.end_date, a.end_date) AS tanggal_akhir_kontrak,
    a.po_number AS no_po,
    a.created_date AS tanggal_po,
    a.spk_code AS no_spk,
    f.dep_code AS kode_departement,
    g.nasabah_code AS kode_nasabah,
    'yes'::text AS fasilitas_bank
   FROM ctr_po_header a
     LEFT JOIN ctr_contract_header b ON b.contract_id = a.contract_id
     LEFT JOIN prc_tender_main c ON b.ptm_number::text = c.ptm_number::text
     LEFT JOIN prc_pr_main d ON d.pr_number::text = c.pr_number::text
     LEFT JOIN prc_plan_main e ON e.ppm_id = d.ppm_id
     LEFT JOIN adm_dept f ON f.dep_code::text = a.dept_code::text
     LEFT JOIN vnd_header g ON g.vendor_id = a.vendor_id
     LEFT JOIN prc_plan_integrasi h ON h.spk_code::text = e.ppm_project_id::text
     LEFT JOIN ctr_wo_header cwo ON cwo.wo_id = a.po_id
     LEFT JOIN ctr_sppm_header cph ON cph.wo_id = a.po_id
  WHERE a.status::text = '2017'::text
UNION ALL
 SELECT DISTINCT ON (a.wo_id) a.wo_id AS po_id,
    COALESCE(b.contract_number, cph.sppm_number) AS no_kontrak,
    COALESCE(b.start_date, a.start_date) AS tanggal_mulai_kontrak,
    COALESCE(b.end_date, a.end_date) AS tanggal_akhir_kontrak,
    a.wo_number AS no_po,
    a.created_date AS tanggal_po,
    a.spk_number AS no_spk,
    f.dep_code AS kode_departement,
    g.nasabah_code AS kode_nasabah,
    'yes'::text AS fasilitas_bank
   FROM ctr_wo_header a
     LEFT JOIN ctr_contract_header b ON b.contract_id = a.contract_id
     LEFT JOIN prc_tender_main c ON b.ptm_number::text = c.ptm_number::text
     LEFT JOIN prc_pr_main d ON d.pr_number::text = c.pr_number::text
     LEFT JOIN prc_plan_main e ON e.ppm_id = d.ppm_id
     LEFT JOIN adm_dept f ON f.dep_code::text = a.dept_code::text
     LEFT JOIN vnd_header g ON g.vendor_id = a.vendor_id
     LEFT JOIN prc_plan_integrasi h ON h.spk_code::text = e.ppm_project_id::text
     LEFT JOIN ctr_wo_comment i ON i.wo_id = a.wo_id
     LEFT JOIN ctr_sppm_header cph ON cph.wo_id = a.wo_id
  WHERE i.cwo_activity = 2033;

-- public.vw_data_item_perencanaan_pmcs source

CREATE OR REPLACE VIEW public.vw_data_item_perencanaan_pmcs
AS SELECT DISTINCT ON (a.smbd_code, a.project_name) a.id,
    a.spk_code,
    a.project_name,
    a.dept_code,
    a.dept_name,
    a.group_smbd_code,
    a.group_smbd_name,
    a.smbd_type,
    a.smbd_code,
    a.smbd_name,
    a.unit,
    c.smbd_quantity,
    a.coa_code,
    a.coa_name,
    a.currency,
    a.user_id,
    a.user_name,
    a.periode_locking,
    a.created_date,
    a.updated_date,
    a.is_matgis,
    b.ppm_id
   FROM prc_plan_integrasi a
     JOIN prc_plan_main b ON b.ppm_project_id::text = a.spk_code::text
     JOIN ( SELECT prc_plan_integrasi.smbd_code,
            prc_plan_integrasi.spk_code,
            sum(prc_plan_integrasi.smbd_quantity) AS smbd_quantity
           FROM prc_plan_integrasi
          WHERE date_part('year'::text, prc_plan_integrasi.periode_pengadaan::timestamp without time zone) = date_part('year'::text, now()::timestamp(0) without time zone)
          GROUP BY prc_plan_integrasi.smbd_code, prc_plan_integrasi.spk_code) c ON c.smbd_code::text = a.smbd_code::text AND c.spk_code::text = a.spk_code::text
  WHERE date_part('year'::text, a.periode_pengadaan::timestamp without time zone) = date_part('year'::text, now()::timestamp(0) without time zone);

-- public.vw_data_item_bastp_pmcs source

CREATE OR REPLACE VIEW public.vw_data_item_bastp_pmcs
AS SELECT a.kode_sumberdaya,
    a.volume_sumberdaya,
    a.satuan_sumberdaya,
    a.harga_satuan,
    a.is_matgis,
    a.bastp_number
   FROM ( SELECT DISTINCT ON (h.spk_code, h.smbd_code, i.po_item_id) i.item_code AS kode_sumberdaya,
            i.qty AS volume_sumberdaya,
            i.uom AS satuan_sumberdaya,
            i.price AS harga_satuan,
            COALESCE(h.is_matgis, 'f'::bpchar) AS is_matgis,
            a_1.bastp_number
           FROM ctr_po_item i
             JOIN ctr_po_header a_1 ON a_1.po_id = i.po_id
             JOIN ctr_contract_header b ON b.contract_id = a_1.contract_id
             JOIN prc_tender_main c ON b.ptm_number::text = c.ptm_number::text
             JOIN prc_pr_main d ON d.pr_number::text = c.pr_number::text
             JOIN prc_plan_main e ON e.ppm_id = d.ppm_id
             JOIN prc_plan_integrasi h ON h.spk_code::text = e.ppm_project_id::text AND h.smbd_code::text = i.item_code::text
          WHERE a_1.bastp_number IS NOT NULL
          ORDER BY h.spk_code, h.smbd_code, i.po_item_id) a
UNION ALL
 SELECT b.kode_sumberdaya,
    b.volume_sumberdaya,
    b.satuan_sumberdaya,
    b.harga_satuan,
    b.is_matgis,
    b.bastp_number
   FROM ( SELECT DISTINCT ON (g.spk_code, g.smbd_code, a.bapb_item_id) a.item_code AS kode_sumberdaya,
            a.qty AS volume_sumberdaya,
            a.uom AS satuan_sumberdaya,
            a.price AS harga_satuan,
            COALESCE(g.is_matgis, 'f'::bpchar) AS is_matgis,
            b_1.bapb_number AS bastp_number
           FROM ctr_bapb_item a
             JOIN ctr_bapb_header b_1 ON b_1.bapb_id = a.bapb_id
             JOIN ctr_contract_header c ON c.contract_id = b_1.contract_id
             JOIN prc_tender_main d ON c.ptm_number::text = d.ptm_number::text
             JOIN prc_pr_main e ON e.pr_number::text = d.pr_number::text
             JOIN prc_plan_main f ON f.ppm_id = e.ppm_id
             JOIN prc_plan_integrasi g ON g.spk_code::text = f.ppm_project_id::text AND g.smbd_code::text = a.item_code::text
          WHERE b_1.bapb_number IS NOT NULL
          ORDER BY g.spk_code, g.smbd_code, a.bapb_item_id) b
UNION ALL
 SELECT c.kode_sumberdaya,
    c.volume_sumberdaya,
    c.satuan_sumberdaya,
    c.harga_satuan,
    c.is_matgis,
    c.bastp_number
   FROM ( SELECT DISTINCT ON (h.spk_code, h.smbd_code, a.milestone_item_id) a.item_code AS kode_sumberdaya,
            a.qty AS volume_sumberdaya,
            a.uom AS satuan_sumberdaya,
            c_1.price AS harga_satuan,
            COALESCE(h.is_matgis, 'f'::bpchar) AS is_matgis,
            b.bastp_number
           FROM ctr_contract_milestone_item a
             JOIN ctr_contract_milestone b ON b.milestone_id = a.milestone_id
             JOIN ctr_contract_item c_1 ON c_1.contract_item_id = a.contract_item_id
             JOIN ctr_contract_header d ON d.contract_id = b.contract_id
             JOIN prc_tender_main e ON e.ptm_number::text = d.ptm_number::text
             JOIN prc_pr_main f ON f.pr_number::text = e.pr_number::text
             JOIN prc_plan_main g ON g.ppm_id = f.ppm_id
             JOIN prc_plan_integrasi h ON h.spk_code::text = g.ppm_project_id::text AND h.smbd_code::text = a.item_code::text
          WHERE b.bastp_number IS NOT NULL
          ORDER BY h.spk_code, h.smbd_code, a.milestone_item_id) c;

-- public.vw_data_invoice_pmcs source

CREATE OR REPLACE VIEW public.vw_data_invoice_pmcs
AS SELECT DISTINCT ON (a.invoice_number) i.bastp_number,
    a.invoice_number,
    h.spk_code,
    f.dep_code,
    a.invoice_date,
    b.contract_number,
    g.nasabah_code,
    COALESCE(i.bastp_type, ''::character varying) AS tipe_bastp
   FROM ctr_invoice_header a
     JOIN ctr_contract_header b ON b.contract_id = a.contract_id
     JOIN prc_tender_main c ON b.ptm_number::text = c.ptm_number::text
     JOIN prc_pr_main d ON d.pr_number::text = c.pr_number::text
     JOIN prc_plan_main e ON e.ppm_id = d.ppm_id
     JOIN adm_dept f ON f.dept_id = e.ppm_dept_id
     JOIN vnd_header g ON g.vendor_id = b.vendor_id
     JOIN prc_plan_integrasi h ON h.spk_code::text = e.ppm_project_id::text
     LEFT JOIN ctr_po_header i ON i.po_id = a.po_id
  WHERE a.invoice_number IS NOT NULL AND a.current_approver_pos IS NULL AND a.approved_date IS NOT NULL
UNION ALL
 SELECT i.bastp_number,
    a.invoice_number,
    h.spk_code,
    f.dep_code,
    a.invoice_date,
    b.contract_number,
    g.nasabah_code,
    COALESCE(i.bastp_type, ''::character varying) AS tipe_bastp
   FROM ctr_invoice_milestone_header a
     JOIN ctr_contract_header b ON b.contract_id = a.contract_id
     JOIN prc_tender_main c ON b.ptm_number::text = c.ptm_number::text
     JOIN prc_pr_main d ON d.pr_number::text = c.pr_number::text
     JOIN prc_plan_main e ON e.ppm_id = d.ppm_id
     JOIN adm_dept f ON f.dept_id = e.ppm_dept_id
     JOIN vnd_header g ON g.vendor_id = b.vendor_id
     JOIN prc_plan_integrasi h ON h.spk_code::text = e.ppm_project_id::text
     LEFT JOIN ctr_contract_milestone i ON i.milestone_id = a.milestone_id
  WHERE a.invoice_number IS NOT NULL AND a.current_approver_pos IS NULL AND a.approved_date IS NOT NULL
UNION ALL
 SELECT k.bapb_number AS bastp_number,
    a.inv_number AS invoice_number,
    h.spk_code,
    f.dep_code,
    a.created_date AS invoice_date,
    b.contract_number,
    g.nasabah_code,
    'bapb'::character varying AS tipe_bastp
   FROM ctr_inv_header a
     JOIN ctr_contract_header b ON b.contract_id = a.contract_id
     JOIN prc_tender_main c ON b.ptm_number::text = c.ptm_number::text
     JOIN prc_pr_main d ON d.pr_number::text = c.pr_number::text
     JOIN prc_plan_main e ON e.ppm_id = d.ppm_id
     JOIN adm_dept f ON f.dept_id = e.ppm_dept_id
     JOIN vnd_header g ON g.vendor_id = b.vendor_id
     JOIN prc_plan_integrasi h ON h.spk_code::text = e.ppm_project_id::text
     JOIN ctr_wo_header i ON i.wo_id = a.wo_id
     JOIN ctr_bapb_comment j ON j.wo_id = a.wo_id
     JOIN ctr_bapb_header k ON k.bapb_id = a.bapb_id
  WHERE j.cwo_activity = 2082;

-- public.vw_data_bastp_pmcs source

CREATE OR REPLACE VIEW public.vw_data_bastp_pmcs
AS SELECT DISTINCT ON (a.po_number) a.bastp_number,
    a.po_number,
    b.contract_number,
    h.spk_code,
    f.dep_code,
    a.bastp_date,
    g.nasabah_code,
    i.sppm_number,
    COALESCE(a.bastp_type, ''::character varying) AS bastp_type
   FROM ctr_po_header a
     JOIN ctr_contract_header b ON b.contract_id = a.contract_id
     JOIN prc_tender_main c ON b.ptm_number::text = c.ptm_number::text
     JOIN prc_pr_main d ON d.pr_number::text = c.pr_number::text
     JOIN prc_plan_main e ON e.ppm_id = d.ppm_id
     JOIN adm_dept f ON f.dept_id = e.ppm_dept_id
     JOIN vnd_header g ON g.vendor_id = b.vendor_id
     JOIN prc_plan_integrasi h ON h.spk_code::text = e.ppm_project_id::text
     LEFT JOIN vw_monev i ON i.bapb_number::text = a.bastp_number::text
  WHERE a.progress_percentage = '100'::smallint AND a.bastp_number IS NOT NULL AND a.bastp_status IS NULL
UNION ALL
 SELECT a.bastp_number,
    ''::character varying AS po_number,
    b.contract_number,
    h.spk_code,
    f.dep_code,
    a.bastp_date,
    g.nasabah_code,
    i.sppm_number,
    COALESCE(a.bastp_type, ''::character varying) AS bastp_type
   FROM ctr_contract_milestone a
     JOIN ctr_contract_header b ON b.contract_id = a.contract_id
     JOIN prc_tender_main c ON b.ptm_number::text = c.ptm_number::text
     JOIN prc_pr_main d ON d.pr_number::text = c.pr_number::text
     JOIN prc_plan_main e ON e.ppm_id = d.ppm_id
     JOIN adm_dept f ON f.dept_id = e.ppm_dept_id
     JOIN vnd_header g ON g.vendor_id = b.vendor_id
     JOIN prc_plan_integrasi h ON h.spk_code::text = e.ppm_project_id::text
     LEFT JOIN vw_monev i ON i.bapb_number::text = a.bastp_number::text
  WHERE a.progress_percentage = '100'::smallint::double precision AND a.bastp_number IS NOT NULL AND a.bastp_status IS NULL
UNION ALL
 SELECT a.bapb_number AS bastp_number,
    i.wo_number AS po_number,
    b.contract_number,
    h.spk_code,
    f.dep_code,
    a.tgl_pembuatan_bapb AS bastp_date,
    g.nasabah_code,
    k.sppm_number,
    'bapb'::character varying AS bastp_type
   FROM ctr_bapb_header a
     JOIN ctr_contract_header b ON b.contract_id = a.contract_id
     JOIN prc_tender_main c ON b.ptm_number::text = c.ptm_number::text
     JOIN prc_pr_main d ON d.pr_number::text = c.pr_number::text
     JOIN prc_plan_main e ON e.ppm_id = d.ppm_id
     JOIN adm_dept f ON f.dept_id = e.ppm_dept_id
     JOIN vnd_header g ON g.vendor_id = b.vendor_id
     JOIN prc_plan_integrasi h ON h.spk_code::text = e.ppm_project_id::text
     JOIN ctr_wo_header i ON i.wo_id = a.wo_id
     JOIN ctr_bapb_comment j ON j.wo_id = a.wo_id
     LEFT JOIN vw_monev k ON k.bapb_number::text = a.bapb_number::text
  WHERE j.cwo_activity = 2082;

-- ---------------------------------------
-- ALTER PRC_PR_MAIN
-- ---------------------------------------

ALTER TABLE public.prc_pr_main ADD pr_tipe_pengadaan varchar(16) NULL;
ALTER TABLE public.prc_pr_main ADD pr_cat_management int2 NULL;
ALTER TABLE public.prc_pr_main ADD pr_jns_pengadaan varchar(16) NULL;
ALTER TABLE public.prc_pr_main ADD pr_nilai_pengadaan varchar(16) NULL;


ALTER TABLE public.prc_tender_uskep_online ADD depkn_kpd_name text NULL;
ALTER TABLE public.prc_tender_uskep_online ADD depkn_kpd_cat text NULL;
ALTER TABLE public.prc_tender_uskep_online ADD depkn_kpd_as text NULL;
ALTER TABLE public.prc_tender_uskep_online ADD depkn_nip text NULL;

ALTER TABLE public.prc_plan_item ADD ppi_pr_distribute int2 NULL;
ALTER TABLE public.prc_pr_item ADD ppi_pr_distribute int2 NULL;

ALTER TABLE public.prc_plan_main ALTER COLUMN ppm_project_id TYPE text USING ppm_project_id::text;
ALTER TABLE public.prc_plan_main ALTER COLUMN ppm_project_name TYPE text USING ppm_project_name::text;

ALTER TABLE public.prc_pr_main ADD pr_project_id text NULL;
ALTER TABLE public.prc_plan_item ALTER COLUMN ppi_jumlah TYPE float8 USING ppi_jumlah::float4;

ALTER TABLE public.prc_plan_main ALTER COLUMN ppm_project_id TYPE text USING ppm_project_id::text;


-- ---------------------------------------
-- Table structure for adm
-- ---------------------------------------
ALTER TABLE adm_pos
ADD nm_bidang varchar(100);

ALTER TABLE adm_employee
ADD type_proyek varchar(20);

ALTER TABLE adm_dept
ADD type_status varchar(50),
ADD kd_dep varchar(20),
ADD direktorat varchar(100);

ALTER TABLE adm_user
ADD signer_id varchar(20),
ADD signer_group varchar(50);

ALTER TABLE vnd_product
ADD id int8,
ADD level char(2),
ADD berat_unit varchar(50),
ADD tod varchar(50),
ADD uom varchar(50),
ADD note varchar(100),
ADD status int2;

-- -------------------------------
-- Table structure for vnd_header
-- -------------------------------
ALTER TABLE "public"."vnd_header"
ADD COLUMN "vnd_jenis" varchar(15),
ADD COLUMN "address_district" varchar(100),
ADD COLUMN "address_village" varchar(100),
ADD COLUMN "project_category" varchar(100),
ADD COLUMN "nilai_pengalaman" int8,
ADD COLUMN "upload_bukti_kontrak" text ,
ADD COLUMN "kemampuan_keuangan" int8,
ADD COLUMN "kapasitas_produk" int4,
ADD COLUMN "satuan" varchar(20),
ADD COLUMN "npwp_nama" varchar(150),
ADD COLUMN "npwp_district" varchar(150),
ADD COLUMN "npwp_lampiran" text ,
ADD COLUMN "pkp_lampiran" text ,
ADD COLUMN "mu_mata_uang" varchar(10),
ADD COLUMN "mu_nilai" numeric(64),
ADD COLUMN "md_mata_uang" varchar(10),
ADD COLUMN "md_nilai" numeric(64),
ADD COLUMN "syncron_date" timestamp(0),
ADD COLUMN "birth_date" date,
ADD COLUMN "birth_place" varchar(150),
ADD COLUMN "completed_date" date,
ADD COLUMN "id_card" varchar(50),
ADD COLUMN "contract_attachment" text ,
ADD COLUMN "sim_attachment" text ,
ADD COLUMN "id_attachment" text ,
ADD COLUMN "ref_doc_attachment" text ,
ADD COLUMN "tax_attachment" text ,
ADD COLUMN "status_fp" varchar(100),
ADD COLUMN "anak_perusahaan" int4,
ADD COLUMN "vendor_lampiran" varchar(255),
ADD COLUMN "notBankruptAtt" varchar(100),
ADD COLUMN "kemampuanNyata" numeric(64),
ADD COLUMN "nilaiPekerjaanBerjalan" numeric(64),
ADD COLUMN "sisaKemampuanNyata" numeric(64),
ADD COLUMN "totalModalTahunTerakhir" numeric(64),
ADD COLUMN "antiBriberyAtt" varchar(100),
ADD COLUMN "antiBriberyPolicyAtt" varchar(100),
ADD COLUMN "domesticAtt" varchar(100),
ADD COLUMN "organizationAtt" varchar(100),
ADD COLUMN "paktaAtt" varchar(100),
ADD COLUMN "umkmAtt" varchar(100),
ADD COLUMN "lastCqsmsApprovedDate" varchar(50),
ADD COLUMN "categoryIdBumnkarya" varchar(255),
ADD COLUMN "companyProfile" text ,
ADD COLUMN "contactMobileNo" varchar(255),
ADD COLUMN "facebook" TEXT ,
ADD COLUMN "instagram" TEXT ,
ADD COLUMN "linkGoogleMaps" TEXT ,
ADD COLUMN "linkedin" TEXT ,
ADD COLUMN "twitter" varchar(255),
ADD COLUMN "qualification" varchar(255),
ADD COLUMN "website" varchar(255),
ADD COLUMN "domisiliEnd" varchar(255),
ADD COLUMN "industryKey" TEXT ,
ADD COLUMN "instanceName" varchar(255),
ADD COLUMN "vendor_code" varchar(50),
ADD COLUMN "is_push_vnd_performance" smallint DEFAULT 0,
ADD COLUMN "is_3pl_ins" varchar(50),
ADD COLUMN "code_bp" varchar(10);

-- -----------------------------
-- Table structure for vnd_bank
-- -----------------------------
ALTER TABLE "public"."vnd_bank"
ADD COLUMN "bankId" int4,
ADD COLUMN "country" varchar(150),
ADD COLUMN "rek_koran_lampiran" text,
ADD COLUMN "surat_pernyataan" text,
ADD COLUMN "created_at" timestamp,
ADD COLUMN "transactionalAtt" varchar(100),
ADD COLUMN "statementLetterAtt" varchar(100);

-- -----------------------------
-- Table structure for prc_tender_quo_main
-- -----------------------------
ALTER TABLE "public"."prc_tender_quo_main"
ADD COLUMN "pqm_rate_curs" varchar(100);

-- -----------------------------
-- Table structure for prc_tender_quo_main_hist
-- -----------------------------
ALTER TABLE "public"."prc_tender_quo_main_hist"
ADD COLUMN "pqm_rate_curs" varchar(100);

-- -----------------------------
-- Table structure for adm_curr
-- -----------------------------
ALTER TABLE "public"."adm_curr"
ADD COLUMN "sell" int4,
ADD COLUMN "buy" int4,
ADD COLUMN "is_active" bool;
ADD COLUMN curr_is int4;

-- -----------------------------
-- Table structure for com_srv_catalog_smbd
-- -----------------------------
ALTER TABLE "public"."com_srv_catalog_smbd"
ADD COLUMN "jenis" varchar(10),
ADD COLUMN "uom" varchar(20);

-- -----------------------------
-- Table structure for com_mat_catalog_smbd
-- -----------------------------
ALTER TABLE "public"."com_mat_catalog_smbd"
ADD COLUMN "jenis" varchar(10);

-- ---------------------------------------
-- Table structure for prc_plan_integrasi
-- ---------------------------------------
ALTER TABLE "public"."prc_plan_integrasi"
ADD COLUMN "ppis_pr_number" int8,
ADD COLUMN "ppis_pr_item" varchar(32),
ADD COLUMN "ppis_delivery_date" date,
ADD COLUMN "ppis_cat_tech" int4,
ADD COLUMN "ppis_acc_assig" varchar(4),
ADD COLUMN "ppis_pr_type" varchar(20);

-- ---------------------------------------
-- Table structure for prc_pr_main
-- ---------------------------------------
ALTER TABLE "public"."prc_pr_main"
ADD COLUMN "pr_type_pengadaan" varchar(50),
ADD COLUMN "pr_jadwal_pengadaan_awal" timestamp,
ADD COLUMN "pr_jadwal_pengadaan_akhir" timestamp,
ADD COLUMN "pr_metode_pengadaan" varchar(50),
ADD COLUMN "prc_risiko_main" varchar(100),
ADD COLUMN "pr_tipe_perencanaan" varchar(50),
ADD COLUMN "pr_ekgrp" varchar(20),
ADD COLUMN "pr_vendor" text,
ADD COLUMN "pr_is_sap" smallint,
ADD COLUMN "pr_status_join" smallint,
ADD COLUMN "pr_jenis_kontrak" varchar(50);

-- ---------------------------------------
-- Table structure for prc_pr_item
-- ---------------------------------------
ALTER TABLE "public"."prc_pr_item"
ADD COLUMN "ppi_namasubmerdaya" varchar(255),
ADD COLUMN "ppi_incoterm" varchar(255),
ADD COLUMN "ppi_lokasi_incoterm" varchar(255),
ADD COLUMN "ppi_sumber_hps" varchar(255),
ADD COLUMN "ppi_hps" numeric(25, 4),
ADD COLUMN "ppi_lampiran" varchar(255),
ADD COLUMN "ppi_subtotal" varchar(255),
ADD COLUMN "ppis_pr_number" varchar(100),
ADD COLUMN "ppis_pr_item" varchar(100),
ADD COLUMN "ppis_delivery_date" date,
ADD COLUMN "ppi_status_update" varchar(2),
ADD COLUMN "ppi_tax_code" varchar(20),
ADD COLUMN "ppis_cat_tech" varchar(20),
ADD COLUMN "ppis_acc_assig" varchar(20),
ADD COLUMN "ppi_no_asset" varchar(20),
ADD COLUMN "ppi_sub_number" varchar(20),
ADD COLUMN "ppi_retention" varchar(20),
ADD COLUMN "ppi_type_po" varchar(20),
ADD COLUMN "ppi_dev_date" date,
ADD COLUMN "ppi_pdt" smallint,
ADD COLUMN "ppi_po_date" date,
ADD COLUMN "ppi_tender_date" date,
ADD COLUMN "ppi_volume_price" numeric(10, 2),
ADD COLUMN "ppi_delete_flag" varchar(1),
ADD COLUMN "ppi_created_at" timestamp,
ADD COLUMN "ppi_update_at" timestamp,
ADD COLUMN "ppi_temp_vol" float(53),
ADD COLUMN "ppi_pr_order" int8,
ADD COLUMN "ppis_pr_type" varchar(8);

-- ---------------------------------------
-- Table structure for prc_plan_item
-- ---------------------------------------
ALTER TABLE "public"."prc_plan_item"
ADD COLUMN "status_rkp" varchar(2),
ADD COLUMN "ppis_pr_number" int8,
ADD COLUMN "ppis_pr_item" varchar(32),
ADD COLUMN "ppis_delivery_date" date,
ADD COLUMN "ppis_cat_tech" int4,
ADD COLUMN "ppis_used_date" date,
ADD COLUMN "ppis_delivery_date" date,
ADD COLUMN "ppis_acc_assig" varchar(4),
ADD COLUMN "ppis_pr_type" varchar(20),
ADD COLUMN "ppis_remark" varchar(255),
ADD COLUMN "ppis_network" varchar(255),
ADD COLUMN "ppis_network_desc" varchar(255),
ADD COLUMN "ppis_wbs_element" varchar(255),
ADD COLUMN "ppi_created_at" timestamp,
ADD COLUMN "ppi_update_at" timestamp,
ADD COLUMN "ppis_wbs_element_desc" varchar(255),
ADD COLUMN "ppi_delete_flag" varchar(1),
ADD COLUMN "ppi_temp_vol" float(53),
ADD COLUMN "ppi_pr_order" int8,
ADD COLUMN "ppi_is_sap" smallint;

ALTER TABLE public.prc_plan_item ALTER COLUMN ppi_code TYPE bpchar(32) USING ppi_code::bpchar;

-- ---------------------------------------
-- Table structure for prc_plan_main
-- ---------------------------------------
ALTER TABLE "public"."prc_plan_main"
ADD COLUMN "ppms_project_id" varchar(64),
ADD COLUMN "ppms_project_desc" varchar(255),
ADD COLUMN "ppms_storage_loc" varchar(32),
ADD COLUMN "ppms_sloc_desc" varchar(255),
ADD COLUMN "ppms_start_date" date,
ADD COLUMN "ppms_finish_date" date,
ADD COLUMN "ppms_planner_pos_code" varchar(20),
ADD COLUMN "ppm_ekgrp" varchar(20),
ADD COLUMN "ppms_tgl_tender" date,
ADD COLUMN "ppms_tgl_po" date,
ADD COLUMN "ppms_target_kedatangan" date,
ADD COLUMN "ppm_is_sap" smallint;

-- ---------------------------------------
-- Table structure for prc_tender_prep
-- ---------------------------------------
ALTER TABLE "public"."prc_tender_prep"
ADD COLUMN "ptp_syarat_penunjuk" json,
ADD COLUMN "ptp_negosiation_date" timestamp,
ADD COLUMN "ptp_uskep_date" timestamp,
ADD COLUMN "ptp_announcement_date" timestamp,
ADD COLUMN "ptp_disclaimer_date" timestamp,
ADD COLUMN "ptp_appointment_date" timestamp,
ADD COLUMN "ptp_tender_priod" int4,
ADD COLUMN "ptm_contract_type" int4,
ADD COLUMN "ptp_padi_umkm" int4,
ADD COLUMN "ptp_pengadaan_com" int4,
ADD COLUMN "ptp_partai_wika" int4,
ADD COLUMN "ptp_tim_panitia" int4,
ADD COLUMN "ptp_preferensi_umkm" int4,
ADD COLUMN "ptm_is_uskep_online" numeric(1);

-- ---------------------------------------
-- Table structure for prc_tender_main
-- ---------------------------------------
ALTER TABLE "public"."prc_tender_main"
ADD COLUMN "ptm_tender_project_type" varchar(15),
ADD COLUMN "ptm_add_bidder" char(2),
ADD COLUMN "ptm_ctr_matgis_type" varchar(10),
ADD COLUMN "ptm_periode" varchar(20),
ADD COLUMN "doc_attachment_inp_mtd_pengadaan" varchar(255),
ADD COLUMN "doc_attachment_inp_header" varchar(255),
ADD COLUMN "ptm_doc_type_sap" varchar(255),
ADD COLUMN "ptm_metode_pengadaan" varchar(50),
ADD COLUMN "ptm_is_uskep_online" numeric(1),
ADD COLUMN "is_sap" smallint;

-- ---------------------------------------
-- Table structure for prc_evaluation_template_detail
-- ---------------------------------------
ALTER TABLE "public"."prc_evaluation_template_detail"
ADD COLUMN "rfq_no" varchar(50);

-- ---------------------------------------
-- Table structure for prc_tender_item
-- ---------------------------------------
ALTER TABLE "public"."prc_tender_item"
ADD COLUMN "tit_incoterm" text,
ADD COLUMN "tit_lokasi_incoterm" text,
ADD COLUMN "tit_sumber_hps" text,
ADD COLUMN "tit_hps" numeric(19, 4),
ADD COLUMN "tit_lampiran" text,
ADD COLUMN "tit_pr_number" varchar(100),
ADD COLUMN "tit_tax_code" varchar(10),
ADD COLUMN "tit_no_asset" varchar(30),
ADD COLUMN "tit_sub_number" varchar(40),
ADD COLUMN "tit_retention" varchar(40),
ADD COLUMN "tit_pr_item" varchar(100),
ADD COLUMN "tit_delivery_date" date,
ADD COLUMN "tit_pr_type" varchar(10),
ADD COLUMN "tit_cat_tech" smallint,
ADD COLUMN "tit_acc_assig" varchar(4);

-- ---------------------------------------
-- Table structure for ctr_contract_header
-- ---------------------------------------
ALTER TABLE ctr_contract_header
ADD ctr_jenis varchar(10),
ADD kategori_pekerjaan varchar(100),
ADD amandemen_number varchar(60),
ADD amandemen_urut int4,
ADD type_winner varchar(20),
ADD contract_number_first varchar(50),
ADD is_push_contract smallint,
ADD ctr_doc_type varchar(8),
ADD ctr_down_payment numeric(19, 4),
ADD ctr_down_payment_date date,
ADD ctr_delivery_date date,
ADD ctr_scope text,
ADD is_sap smallint,
ADD ctr_po_number varchar(100),
ADD ctr_generate_text_number varchar(100),
ADD ctr_is_matgis_ecatalogue smallint default 0,
ADD pengadaan_method varchar(100),
ADD ctr_is_manual smallint;

-- ---------------------------------------
-- Table structure for ctr_contract_milestone
-- ---------------------------------------
ALTER TABLE ctr_contract_milestone
ADD nilai numeric(19, 4),
ADD note varchar(100),
ADD milestone_file varchar(100);

-- ---------------------------------------
-- Table structure for ctr_contract_doc
-- ---------------------------------------
ALTER TABLE ctr_contract_doc
ADD name_input varchar(100),
ADD upload_date timestamp(0),
ADD signor varchar(100),
ADD req_e_sign varchar(100);

-- ---------------------------------------
-- Table structure for ctr_contract_item
-- ---------------------------------------
ALTER TABLE ctr_contract_item
ADD item_po int4,
ADD no_asset int4,
ADD pr_retention int4,
ADD tax_code varchar(8),
ADD pr_delivery_date date,
ADD pr_item_sap varchar(100),
ADD pr_number_sap varchar(100),
ADD pr_type_sap varchar(8),
ADD pr_retention int,
ADD pr_acc_assig varchar(4),
ADD note varchar(100),
ADD incoterm varchar(255),
ADD kategori_pekerjaan varchar(255),
ADD lokasi_incoterm text,
ADD sub_number int4,
ADD sumber_hps text,
ADD lampiran text,
ADD hps numeric(25, 4),
ADD pr_cat_tech smallint;


-- ================================================================================================== --

CREATE TABLE ctr_release_po(
   id_res SERIAL PRIMARY KEY,
   NOMOR_PO VARCHAR(20),
   TYPE_RES VARCHAR(2),
   ID_INTERFACE VARCHAR(20),   
   NUMBER_RES smallint,
   MESSAGE_RES TEXT,
   LOG_NO VARCHAR(50),
   LOG_MSG_NO smallint,
   MESSAGE_V1 VARCHAR(50),   
   MESSAGE_V2 VARCHAR(50),   
   MESSAGE_V3 VARCHAR(50),   
   MESSAGE_V4 VARCHAR(50),   
   PARAMETER VARCHAR(50),
   ROW_RES smallint,
   FIELD VARCHAR(50),
   SYSTEM_RES VARCHAR(50),
   sync_at timestamp
);

CREATE TABLE adm_tax_code(
   id SERIAL PRIMARY KEY,
   tax_code VARCHAR(16) NOT NULL,
   description VARCHAR(128) NOT NULL
);

CREATE TABLE prc_pr_vendor(
   id SERIAL PRIMARY KEY,
   pr_number VARCHAR(20) NOT NULL,
   vendor_id int8 NOT NULL
);

CREATE TABLE "public"."vnd_nasabah_online" (
  "id" int8 NOT NULL DEFAULT nextval('vnd_nasabah_online_id_seq'::regclass),
  "jns" varchar(20),
  "ns_id" varchar(10),
  "kdnasabah_temp" varchar(100),
  "nmnasabah" varchar(255),
  "alamat" varchar(255),
  "npwp" varchar(100),
  "alamat_npwp" varchar(255),
  "kota" varchar(255),
  "kode_pos" varchar(10),
  "telepon" varchar(255),
  "fax" varchar(255),
  "website" varchar(200),
  "email" varchar(255),
  "nama_kontak" varchar(255),
  "jenis" varchar(255),
  "jabatan" varchar(255),
  "handphone" varchar(50),
  "tipe" varchar(20),
  "keterangan" varchar(150),
  "kelompok" varchar(50),
  "kol1" varchar(20),
  "kol2" varchar(20),
  "cotid" varchar(50),
  "kdnasabah" varchar(255),
  "kdbp_sap" varchar(20),
  "sync_date" timestamp(6)
);

-- ----------------------------
-- Primary Key structure for table vnd_nasabah_online
-- ----------------------------
ALTER TABLE "public"."vnd_nasabah_online" ADD CONSTRAINT "vnd_nasabah_online_pkey" PRIMARY KEY ("id");

INSERT INTO adm_tax_code (tax_code, description)
VALUES
    ('V0', '0% - PPN Masukan NON-PKP'),
    ('V1', '11% - PPN Masukan NON-WAPU'),
    ('V3', '11% - PPN Masukan WAPU'),
    ('V4', '1.1% - PPN JKP Tertentu Pihak ketiga'),
    ('V5', '1.1% - PPN JKP Tertentu Berelasi'),
    ('V6', '11% - PPN Masukan Tidak di Pungut'),
    ('V7', '11% - PPN Masukan di Bebaskan'),
    ('V8', '11% - BKP Tidak berwujud/JKPLN'),
    ('V9', 'PPN Masukan Luar Negeri');


INSERT INTO adm_dept (dept_name, dep_code, dept_active)
VALUES
    ('PG Kantor Pusat','A00',1),
    ('PG Matgis WIKA','A0M',1),
    ('PG Infra 1','AB0',1),
    ('PG Infra 1 - Proyek','AB1',1),
    ('PG Infra 2','AC0',1),
    ('PG Infra 2 - Proyek','AC1',1),
    ('PG EPCC','AD0',1),
    ('PG EPCC - Proyek','AD1',1),
    ('PG BGLN','AE0',1),
    ('PG BGLN - Proyek','AE1',1),
    ('PG DPPU','AF0',1),
    ('PG DPPU - Proyek','AF1',1)

CREATE TABLE adm_pr_type(
    id SERIAL PRIMARY KEY,
    pr_code VARCHAR(8) NOT NULL,
    pr_name VARCHAR(64) NOT NULL
);

INSERT INTO adm_pr_type (pr_code, pr_name)
VALUES
    ('ZPW1','WIKA PR Non Proyek'),
    ('ZPW2','WIKA PR Proyek (BL)'),
    ('ZPW3','WIKA PR Proyek (BTL)'),
    ('ZPW4','WIKA PR Sales Order')

ALTER TABLE uskep_online
ADD metode_pengadaan varchar(50) NULL,
ADD is_sap smallint;



-- public.vw_ctr_monitor_amandemen source
-- ADD is_sap FIELD
CREATE OR REPLACE VIEW public.vw_ctr_monitor_amandemen
AS SELECT ctr.contract_id,
	ctr.is_sap,
    ctr.ptm_number,
    ctr.contract_number,
    ctr.ctr_spe_employee,
    ctr.ctr_spe_pos,
    ctr.vendor_id,
    ctr.vendor_name,
    ctr.sign_date,
    ctr.start_date,
    ctr.end_date,
    ctr.created_date,
    ctr.subject_work,
    ctr.scope_work,
    ctr.contract_type,
    ctr.contract_type_2,
    ctr.repeat_order,
    ctr.currency,
    ctr.contract_amount,
    ctr.rental_payment_period,
    ctr.rental_payment_unit,
    ctr.rental_payment_term,
    ctr.status,
    ctr.notes,
    ctr.terminate_date,
    ctr.terminate_reason,
    ctr.terminate_notes,
    ctr.current_approver_pos,
    ctr.ammend_count,
    ctr.completed_tender_date,
    ctr.pf_amount,
    ctr.pf_bank,
    ctr.pf_number,
    ctr.pf_start_date,
    ctr.pf_end_date,
    ctr.pf_attachment,
    ctr.current_approver_level,
    ctr.ctr_man_pos,
    ctr.ctr_man_employee,
    ctr.ctr_man_pos_name,
    ctr.ctr_spe_pos_name,
    ctr.amandemen_number,
    ( SELECT adm_wkf_activity.awa_name
           FROM adm_wkf_activity
          WHERE adm_wkf_activity.awa_id = (( SELECT ccc.ccc_activity
                   FROM ctr_contract_comment ccc
                  WHERE ccc.contract_id = ctr.contract_id
                  ORDER BY ccc.ccc_id DESC
                 LIMIT 1))) AS status_name,
    COALESCE(( SELECT ccc.ccc_activity
           FROM ctr_contract_comment ccc
          WHERE ccc.contract_id = ctr.contract_id
          ORDER BY ccc.ccc_id DESC
         LIMIT 1), ctr.status) AS last_status,
    ctr.is_sap
    FROM ctr_contract_header ctr;



-- public.vw_daftar_pekerjaan_kontrak source

CREATE OR REPLACE VIEW public.vw_daftar_pekerjaan_kontrak
AS SELECT "A".ccc_id,
    "A".contract_id,
    "A".ptm_number,
    "D".ptm_dept_id,
    "D".ptm_requester_id,
    "B".subject_work,
    "B".contract_number,
    "B".amandemen_number,
    "B".contract_amount,
    "B".vendor_name,
    "B".contract_type,
    "A".ccc_user,
    "A".ccc_name,
    "A".ccc_pos_code,
    "A".ccc_activity,
    "C".awa_name AS activity,
    "A".ccc_end_date,
    to_char("A".ccc_start_date, 'DD/MM/YYYY HH24:MI'::text) AS waktu,
    "B".ctr_is_matgis,
        CASE
            WHEN "B".is_sap::text = '1'::text THEN 'YES'::text
            ELSE 'NO'::text
        END AS is_sap,
        CASE
            WHEN "B".ctr_is_sync_po_number = 1 AND "B".ctr_po_number IS NOT NULL THEN 'TERKIRIM'::text
            WHEN "B".ctr_is_sync_po_number = 1 AND "B".ctr_po_number IS NULL THEN 'GAGAL TERKIRIM'::text
            ELSE 'BELUM TERKIRIM'::text
        END AS status_po,
    "B".ctr_po_number,
     	CASE
            WHEN "B".ctr_is_manual::text = '1'::text THEN 'YES'::text
            ELSE 'NO'::text
        END AS ctr_is_manual
   FROM ctr_contract_comment "A"
     LEFT JOIN prc_tender_main "D" ON "A".ptm_number::text = "D".ptm_number::text
     LEFT JOIN ctr_contract_header "B" ON "B".contract_id = "A".contract_id
     LEFT JOIN adm_wkf_activity "C" ON "C".awa_id = "A".ccc_activity;


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
    ppi.ppis_pr_type,
    ppi.ppis_pr_number,
    ppi.ppis_acc_assig,
    ppi.ppis_pr_item,
    ppi.ppi_code,
    ppi.ppi_item_desc,
    ppm.ppm_dept_id,
    ppm.ppm_dept_name,
    ppi.ppi_satuan,
    ppi.ppi_jumlah,
    ppi.ppi_harga,
    ppi.ppi_harga::double precision * ppi.ppi_jumlah AS subtotal,
    ppm.ppms_start_date,
    ppi.ppis_delivery_date,
    ppi.ppi_update_at,
    ppi.status_rkp
   FROM prc_plan_main ppm
     JOIN prc_plan_item ppi ON ppi.ppm_id = ppm.ppm_id
     LEFT JOIN adm_dept ad ON ad.dept_id = ppm.ppm_dept_id
  WHERE ppm.ppm_is_sap = 1
  ORDER BY ppi.ppis_pr_number DESC;


  -- {tblview_deleted.sql}
  ALTER TABLE public.prc_plan_main ALTER COLUMN ppm_project_id TYPE text USING ppm_project_id::text;
  ALTER TABLE public.prc_plan_main ALTER COLUMN ppm_project_name TYPE text USING ppm_project_name::text;


  ALTER TABLE public.uskep_online ALTER COLUMN paket_pengadaan TYPE text USING paket_pengadaan::text;

  ALTER TABLE public.uskep_online ADD is_draft int2 NOT NULL DEFAULT 0;
  CREATE OR REPLACE VIEW public.vw_prc_monitor
AS SELECT ptm.pr_number,
    ptp.ptm_number,
    vnd.vendor_name,
    vnd.vendor_id,
    ptm.ptm_upreff,
    ptm.ptm_downreff,
    ptm.ptm_requester_name,
    ptm.ptm_requester_pos_code,
    ptm.ptm_requester_pos_name,
    to_char(ptm.ptm_created_date, 'YYYY-MM-DD HH24:MI:SS'::text) AS ptm_created_date,
    ptm.ptm_subject_of_work,
    ptm.ptm_scope_of_work,
    ptm.ptm_district_id,
    ptm.ptm_district,
    ptm.ptm_delivery_point_id,
    ptm.ptm_delivery_point,
    ptm.ptm_delivery_time,
    ptm.ptm_delivery_unit,
    ptm.ptm_buyer,
    ptm.ptm_buyer_pos_code,
    ptm.ptm_buyer_pos_name,
    ptm.ptm_currency,
    ptm.ptm_contract_type,
    ptm.ptm_doc_type_sap,
    ptm.ptm_last_participant,
    ptm.ptm_last_participant_code,
    ptm.ptm_is_contract_created,
    ptm.ptm_rfq_no,
    ptm.is_sap,
    ptm.ptm_status,
    ptm.ptm_completed_date,
    ptm.ptm_tender_id,
    ptm.ptm_is_manual,
    ptm.ptm_dept_id,
    ( SELECT adm_dept.dep_code
           FROM adm_dept
          WHERE adm_dept.dept_id = ptm.ptm_dept_id) AS ptm_dep_code,
    ptm.ptm_dept_name,
    ptm.ptm_mata_anggaran,
    ptm.ptm_nama_mata_anggaran,
    ptm.ptm_sub_mata_anggaran,
    ptm.ptm_nama_sub_mata_anggaran,
    ptm.ptm_pagu_anggaran,
    ptm.ptm_sisa_anggaran,
    ptm.ptm_requester_id,
    ptp.ptp_id,
    ptp.ptp_tender_method,
    ptp.ptp_submission_method,
    ptp.ptp_evaluation_method,
    ptp.ptp_reg_opening_date,
    ptp.ptp_reg_closing_date,
    ptp.ptp_prebid_date,
    ptp.ptp_prebid_location,
    ptp.ptp_quot_closing_date,
    ptp.ptp_tech_bid_date,
    ptp.ptp_quot_opening_date,
    ptp.ptp_eauction,
    ptp.ptp_inquiry_notes,
    ptp.ptp_enabled_rank,
    ptp.ptp_prequalify,
    ptp.ptp_doc_open_date,
    ptp.ptp_preq_info,
    ptp.evt_id,
        CASE ptp.ptp_tender_method
            WHEN 0 THEN 'Penunjukan Langsung'::text
            WHEN 1 THEN 'Tender Terbatas'::text
            WHEN 2 THEN 'Tender Umum'::text
            ELSE '--'::text
        END AS tender_metode,
    ptp.evt_description,
    ptp.adm_bid_committee,
    ptp.adm_bid_committee_name,
    ptp.ppt_id,
    ptp.ppt_name,
    ptp.ptp_bid_opening2,
    ptp.ptp_tgl_aanwijzing2,
    ptp.ptp_lokasi_aanwijzing2,
    ptp.ptp_klasifikasi_peserta,
    ptp.ptp_aanwijzing_online,
    ( SELECT adm_wkf_activity.awa_name
           FROM adm_wkf_activity
          WHERE adm_wkf_activity.awa_id = (( SELECT ptc.ptc_activity
                   FROM prc_tender_comment ptc
                  WHERE ptc.ptm_number::text = ptm.ptm_number::text
                  ORDER BY ptc.ptc_id DESC
                 LIMIT 1))) AS status,
    pqvs.total AS total_contract,
    COALESCE(( SELECT ptc.ptc_activity
           FROM prc_tender_comment ptc
          WHERE ptc.ptm_number::text = ptm.ptm_number::text
          ORDER BY ptc.ptc_id DESC
         LIMIT 1), ptm.ptm_status) AS last_status,
    ( SELECT ptc.ptc_position
           FROM prc_tender_comment ptc
          WHERE ptc.ptm_number::text = ptm.ptm_number::text
          ORDER BY ptc.ptc_id DESC
         LIMIT 1) AS last_pos,
    pqm.pqm_currency,
    ptm.pr_type,
    ptm.ptm_type_of_plan,
    ptm.ptm_project_name,
    ptm.ptm_packet,
    ptm.isjoin,
    ptm.ptm_dept,
        CASE ptm.ptm_type_of_plan
            WHEN 'rkp'::text THEN 'Proyek'::text
            WHEN 'rkp_matgis'::text THEN 'Proyek Matgis'::text
            ELSE 'Non Proyek'::text
        END AS jenis_pengadaan,
    ptm.ptm_winner,
    ptm.spk_code,
    ptm.dept_code,
    ptm.mppp_pos_code,
    ptm.mppp_pos_name,
    ptm.amm_id,
    ptm.ptm_district_name,
    ptm.ptm_tender_project_type,
    ptm.ptm_ctr_matgis_type,
    ptm.doc_attachment_inp_header,
    ptm.doc_attachment_inp_mtd_pengadaan
   FROM prc_tender_main ptm
     LEFT JOIN prc_tender_prep ptp ON ptp.ptm_number::text = ptm.ptm_number::text
     LEFT JOIN prc_tender_vendor_status ptvs ON ptvs.ptm_number::text = ptm.ptm_number::text AND ptvs.pvs_is_winner = 1
     LEFT JOIN vnd_header vnd ON vnd.vendor_id = ptvs.pvs_vendor_code
     LEFT JOIN prc_tender_quo_main pqm ON vnd.vendor_id = pqm.ptv_vendor_code AND ptp.ptm_number::text = pqm.ptm_number::text
     LEFT JOIN vw_prc_quotation_vendor_sum pqvs ON vnd.vendor_id = pqvs.ptv_vendor_code AND pqvs.ptm_number::text = ptm.ptm_number::text
 union
    select
	no_rfq as pr_number,
    '' as ptm_number,
    '' as vendor_name,
    0 as vendor_id,
    '' as ptm_upreff,
    '' as ptm_downreff,
    '' as ptm_requester_name,
    0 as ptm_requester_pos_code,
    '' as ptm_requester_pos_name,
    to_char(date_created, 'YYYY-MM-DD HH24:MI:SS'::text) as ptm_created_date,
    '' as ptm_subject_of_work,
    '' as ptm_scope_of_work,
    0 as ptm_district_id,
    0 as ptm_district,
    0 as ptm_delivery_point_id,
    '' as ptm_delivery_point,
    null as ptm_delivery_time,
    null as ptm_delivery_unit,
    '' as ptm_buyer,
    0 as ptm_buyer_pos_code,
    '' as ptm_buyer_pos_name,
    '' as ptm_currency,
    '' as ptm_contract_type,
    '' as ptm_doc_type_sap,
    '' as ptm_last_participant,
    0 as ptm_last_participant_code,
    '' as ptm_is_contract_created,
    '' as ptm_rfq_no,
    '' as is_sap,
    0 as ptm_status,
    null as ptm_completed_date,
    0 as ptm_tender_id,
    '' as ptm_is_manual,
    0 as ptm_dept_id,
    '' as ptm_dep_code,
    '' as ptm_dept_name,
    '' as ptm_mata_anggaran,
    '' as ptm_nama_mata_anggaran,
    '' as ptm_sub_mata_anggaran,
    '' as ptm_nama_sub_mata_anggaran,
    0 as ptm_pagu_anggaran,
    0 as ptm_sisa_anggaran,
    0 as ptm_requester_id,
    0 as ptp_id,
    0 as ptp_tender_method,
    0 as ptp_submission_method,
    0 as ptp_evaluation_method,
    null as ptp_reg_opening_date,
    null as ptp_reg_closing_date,
    null as ptp_prebid_date,
    '' as ptp_prebid_location,
    null as ptp_quot_closing_date,
    null as ptp_tech_bid_date,
    null as ptp_quot_opening_date,
    0 as ptp_eauction,
    '' as ptp_inquiry_notes,
    '' as ptp_enabled_rank,
    '' as ptp_prequalify,
    null as ptp_doc_open_date,
    '' as ptp_preq_info,
    0 as evt_id,
    '' as tender_metode,
    '' as evt_description,
    null as adm_bid_committee,
    '' as adm_bid_committee_name,
    0 as ppt_id,
    '' as ppt_name,
    null as ptp_bid_opening2,
    null as ptp_tgl_aanwijzing2,
    '' as ptp_lokasi_aanwijzing2,
    '' as ptp_klasifikasi_peserta,
    null as ptp_aanwijzing_online,
    '' as status,
    0 as total_contract,
    0 as last_status,
    '' as last_pos,
    '' as pqm_currency,
    '' as pr_type,
    '' as ptm_type_of_plan,
    '' as ptm_project_name,
    paket_pengadaan as ptm_packet,
    0 as isjoin,
    '' as ptm_dept,
    '' as jenis_pengadaan,
    0 as ptm_winner,
    '' as spk_code,
    '' as dept_code,
    null as mppp_pos_code,
    '' as mppp_pos_name,
    0 as amm_id,
    '' as ptm_district_name,
    '' as ptm_tender_project_type,
    '' as ptm_ctr_matgis_type,
    '' as doc_attachment_inp_header,
    '' as doc_attachment_inp_mtd_pengadaan
from uskep_online where is_draft = 1
