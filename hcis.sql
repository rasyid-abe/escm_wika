CREATE OR REPLACE VIEW public.vw_response_hcis AS

select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'oa' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR MANAGER' and nm_fungsi_bidang = 'Supply Chain Management'
	union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'oa' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_fungsi_bidang = 'Supply Chain Management'
	union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'oa' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'' as kelas,
	0 as proyek_big,
	3 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_direktorat like '%OPERASI%'
	union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'oa' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'' as kelas,
	0 as proyek_big,
	4 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_departemen = 'FINANCE DIV.'
	union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'oa' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'' as kelas,
	0 as proyek_big,
	5 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_departemen = 'RISK MGMT. DIV.'
-- OA BAKP
union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'oa' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'' as nilai,
	'' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_direktorat IN ('DIR QUALTY,HLTH,SFTY,ENVRNMNT')
	union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'oa' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'' as nilai,
	'' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_direktorat like '%DIR OPERASI%'
	union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'oa' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'' as nilai,
	'' as kelas,
	1 as proyek_big,
	3 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'DIREKTUR UTAMA'

-- ####====================================================================(DONE)

-- NON OA DSP-DEPKN KELAS LOW
union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'non-oa' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'low' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'MANAGER' and nm_fungsi_bidang = 'Supply Chain Management'
	union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'non-oa' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'low' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'MANAJER PROYEK KECIL'
	union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'non-oa' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'low' as kelas,
	0 as proyek_big,
	3 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'MANAGER' and nm_fungsi_bidang in ('Project Planning and Control','Project Control')
	union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'non-oa' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'low' as kelas,
	0 as proyek_big,
	4 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan in ('MANAJER BIRO OPERASI', 'MANAGER') and nm_fungsi_bidang = 'Finance'
	union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'non-oa' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'low' as kelas,
	0 as proyek_big,
	5 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan IN ('GENERAL MANAGER','MANAGER') and nm_fungsi_bidang = 'Engineering'
-- NON OA BAKP KELAS LOW
union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'non-oa' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'' as nilai,
	'low' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR MANAGER' and nm_fungsi_bidang = 'Supply Chain Management'
	union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'non-oa' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'' as nilai,
	'low' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'GENERAL MANAGER' and nm_direktorat like '%OPERASI%'

-- #### =========================================================================

-- NON OA DSP-DEKPN KELAS MEDIUM
union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'non-oa' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR MANAGER' and nm_fungsi_bidang = 'Supply Chain Management'
	union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'non-oa' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'MANAJER PROYEK MENENGAH'
	union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'non-oa' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	3 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'MANAGER' and nm_fungsi_bidang in ('Project Planning and Control','Project Control')
	union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'non-oa' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	4 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan in ('MANAJER BIRO OPERASI', 'MANAGER') and nm_fungsi_bidang = 'Finance'
	union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'non-oa' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	5 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan IN ('GENERAL MANAGER','MANAGER') and nm_fungsi_bidang = 'Engineering'
	union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'non-oa' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	6 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'GENERAL MANAGER' and nm_direktorat like '%OPERASI%' and nm_fungsi_bidang != 'Engineering'
-- NON OA BAKP KELAS MEDIUM
union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'non-oa' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_fungsi_bidang = 'Supply Chain Management'
	union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'non-oa' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_direktorat like '%OPERASI%'
-- ### =========================================================================

-- NON OA DSP-DEPKN KELAS HIGH
union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'non-oa' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'high' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_fungsi_bidang = 'Supply Chain Management'
	union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'non-oa' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'high' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan in ('MANAJER PROYEK BESAR', 'MANAJER PROYEK MEGA')
	union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'non-oa' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'high' as kelas,
	0 as proyek_big,
	3 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_direktorat like '%OPERASI%'
	union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'non-oa' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'high' as kelas,
	0 as proyek_big,
	4 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_fungsi_bidang = 'Risk Management'
	union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'non-oa' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'high' as kelas,
	0 as proyek_big,
	5 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_unit_org = 'FINANCE DIVISION'
-- NON OA BAKP KELAS HIGH
union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'oa' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'' as nilai,
	'high' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_direktorat IN ('DIR QUALTY,HLTH,SFTY,ENVRNMNT')
	union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'oa' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'' as nilai,
	'high' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_direktorat like '%DIR OPERASI%'
	union
select
	'proyek' as tipe_proyek,
	1 as is_category_management,
	'oa' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'' as nilai,
	'high' as kelas,
	1 as proyek_big,
	3 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'DIREKTUR UTAMA'


-- ### ==================================================================================

-- NON MATGIS DEPKN KECIL KELAS LOW
union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'kecil' as nilai,
	'low' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan in ('KEPALA SEKSI PROYEK KECIL') and nm_fungsi_bidang = 'Supply Chain Management'
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'kecil' as nilai,
	'low' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan in ('KEPALA SEKSI PROYEK KECIL') and nm_fungsi_bidang = 'Finance'
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'kecil' as nilai,
	'low' as kelas,
	0 as proyek_big,
	3 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan in ('KEPALA SEKSI PROYEK KECIL', 'MANAJER BIDANG') and (nm_fungsi_bidang = 'Project Planning and Control' or nm_fungsi_bidang_lvl1 = 'Project Planning and Control')
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'kecil' as nilai,
	'low' as kelas,
	0 as proyek_big,
	4 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan in ('KEPALA SEKSI PROYEK KECIL', 'MANAJER BIDANG') and nm_fungsi_bidang = 'Engineering'
-- NON MATGIS BAKP KECIL KELAS LOW
union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'kecil' as nilai,
	'low' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'MANAJER PROYEK KECIL'
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'kecil' as nilai,
	'low' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'MANAGER' and nm_fungsi_bidang in ('Project Planning and Control','Project Control')

-- NON MATGIS DEPKN MENENGAH KELAS LOW
union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'menengah' as nilai,
	'low' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan in ('KEPALA SEKSI PROYEK MENENGAH') and nm_unit_org like '%SIE. SCM%'
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'menengah' as nilai,
	'low' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan in ('KEPALA SEKSI PROYEK MENENGAH') and nm_fungsi_bidang = 'Finance'
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'menengah' as nilai,
	'low' as kelas,
	0 as proyek_big,
	3 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan in ('KEPALA SEKSI PROYEK MENENGAH', 'MANAJER BIDANG') and (nm_fungsi_bidang = 'Project Planning and Control' or nm_fungsi_bidang_lvl1 = 'Project Planning and Control')
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'menengah' as nilai,
	'low' as kelas,
	0 as proyek_big,
	4 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan in ('KEPALA SEKSI PROYEK MENENGAH', 'MANAJER BIDANG') and nm_fungsi_bidang = 'Engineering'
-- NON MATGIS BAKP MENENGAH KELAS LOW
union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'menengah' as nilai,
	'low' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'MANAJER PROYEK MENENGAH'
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'menengah' as nilai,
	'low' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'MANAGER' and nm_fungsi_bidang in ('Project Planning and Control','Project Control')

-- NON MATGIS DEPKN BESAR KELAS LOW
union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'besar' as nilai,
	'low' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		(nm_jabatan in ('MANAJER BIDANG PROYEK MEGA') and nm_fungsi_bidang = 'Supply Chain Management') or (nm_jabatan in ('KEPALA SEKSI PROYEK BESAR', 'KEPALA SEKSI PROYEK MEGA') and (nm_unit_org like '%SIE. SCM%' or nm_unit_org like '%SIE SCM%'))
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'besar' as nilai,
	'low' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan in ('KEPALA SEKSI PROYEK BESAR', 'KEPALA SEKSI PROYEK MEGA', 'MANAJER BIDANG PROYEK MEGA') and nm_fungsi_bidang = 'Finance'
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'besar' as nilai,
	'low' as kelas,
	0 as proyek_big,
	3 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan in ('KEPALA SEKSI PROYEK BESAR', 'KEPALA SEKSI PROYEK MEGA', 'MANAJER BIDANG PROYEK MEGA') and (nm_fungsi_bidang = 'Project Planning and Control' or nm_fungsi_bidang_lvl1 = 'Project Planning and Control')
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'besar' as nilai,
	'low' as kelas,
	0 as proyek_big,
	4 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan in ('KEPALA SEKSI PROYEK BESAR', 'KEPALA SEKSI PROYEK MEGA', 'MANAJER BIDANG PROYEK MEGA', 'MANAJER BIDANG PROYEK BESAR') and nm_fungsi_bidang = 'Engineering'
-- NON MATGIS BAKP BESAR KELAS LOW
union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'besar' as nilai,
	'low' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan in ('MANAJER PROYEK BESAR', 'MANAJER PROYEK MEGA')
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'besar' as nilai,
	'low' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'MANAGER' and nm_fungsi_bidang in ('Project Planning and Control','Project Control')


-- #### ========================================================================

-- NON MATGIS DSP-DEPKN KECIL KELAS MEDIUM
union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'kecil' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR MANAGER' and nm_fungsi_bidang = 'Supply Chain Management'
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'kecil' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'MANAJER PROYEK KECIL'
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'kecil' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	3 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'MANAGER' and nm_fungsi_bidang in ('Project Planning and Control','Project Control')
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'kecil' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	4 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan in ('MANAJER BIRO OPERASI', 'MANAGER') and nm_fungsi_bidang = 'Finance'
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'kecil' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	5 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan IN ('GENERAL MANAGER','MANAGER') and nm_fungsi_bidang = 'Engineering'
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'kecil' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	6 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'GENERAL MANAGER' and nm_direktorat like '%OPERASI%' and nm_fungsi_bidang != 'Engineering'
-- NON MATGIS BAKP KECIL KELAS MEDIUM
union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'kecil' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_fungsi_bidang = 'Supply Chain Management'
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'kecil' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_direktorat like '%OPERASI%'

-- NON MATGIS DSP-DEPKN MENENGAH KELAS MEDIUM
union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'menengah' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR MANAGER' and nm_fungsi_bidang = 'Supply Chain Management'
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'menengah' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'MANAJER PROYEK MENENGAH'
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'menengah' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	3 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'MANAGER' and nm_fungsi_bidang in ('Project Planning and Control','Project Control')
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'menengah' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	4 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan in ('MANAJER BIRO OPERASI', 'MANAGER') and nm_fungsi_bidang = 'Finance'
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'menengah' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	5 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan IN ('GENERAL MANAGER','MANAGER') and nm_fungsi_bidang = 'Engineering'
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'menengah' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	6 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'GENERAL MANAGER' and nm_direktorat like '%OPERASI%' and nm_fungsi_bidang != 'Engineering'
-- NON MATGIS BAKP MENENGAH KELAS MEDIUM
union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'menengah' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_fungsi_bidang = 'Supply Chain Management'
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'menengah' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_direktorat like '%OPERASI%'

-- NON MATGIS DSP-DEPKN BESAR KELAS MEDIUM
union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'besar' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR MANAGER' and nm_fungsi_bidang = 'Supply Chain Management'
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'besar' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan in ('MANAJER PROYEK BESAR','MANAJER PROYEK MEGA')
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'besar' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	3 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'MANAGER' and nm_fungsi_bidang in ('Project Planning and Control','Project Control')
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'besar' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	4 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan in ('MANAJER BIRO OPERASI', 'MANAGER') and nm_fungsi_bidang = 'Finance'
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'besar' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	5 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan IN ('GENERAL MANAGER','MANAGER') and nm_fungsi_bidang = 'Engineering'
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'besar' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	6 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'GENERAL MANAGER' and nm_direktorat like '%OPERASI%' and nm_fungsi_bidang != 'Engineering'
-- NON MATGIS BAKP BESAR KELAS MEDIUM
union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'besar' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_fungsi_bidang = 'Supply Chain Management'
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'besar' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_direktorat like '%OPERASI%'

-- ### =========================================================================

-- NON MATGIS DSP BESAR KELAS HIGH
union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'besar' as nilai,
	'high' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_fungsi_bidang = 'Supply Chain Management'
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'besar' as nilai,
	'high' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan in ('MANAJER PROYEK BESAR', 'MANAJER PROYEK MEGA')
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'besar' as nilai,
	'high' as kelas,
	0 as proyek_big,
	3 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_direktorat like '%OPERASI%'
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'besar' as nilai,
	'high' as kelas,
	0 as proyek_big,
	4 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR MANAGER' and nm_fungsi_bidang = 'Risk Management'
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'besar' as nilai,
	'high' as kelas,
	0 as proyek_big,
	5 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR MANAGER' and nm_fungsi_bidang = 'Finance'
-- NON MATGIS BAKP BESAR
union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'besar' as nilai,
	'high' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_direktorat IN ('DIR QUALTY,HLTH,SFTY,ENVRNMNT')
	union
select
	'proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'besar' as nilai,
	'high' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_direktorat like '%DIR OPERASI%'

-- ### =========================================================================

-- NON PROYEK DSP-DEPKN LOW
union
select
	'non-proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'low' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'MANAGER' and nm_fungsi_bidang = 'Supply Chain Management'
	union
select
	'non-proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'low' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR MANAGER'
-- NON PROYEK BAKP LOW
union
select
	'non-proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'' as nilai,
	'low' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_fungsi_bidang != 'Supply Chain Management'
	union
select
	'non-proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'' as nilai,
	'low' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_fungsi_bidang = 'Supply Chain Management'
	union
select
	'non-proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'' as nilai,
	'low' as kelas,
	1 as proyek_big,
	3 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_direktorat like '%KEUANGAN%'


-- NON PROYEK DSP-DEPKN MEDIUM
union
select
	'non-proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR MANAGER' and nm_fungsi_bidang = 'Supply Chain Management'
	union
select
	'non-proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR MANAGER'
	union
select
	'non-proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	3 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR MANAGER' and nm_fungsi_bidang = 'Finance'
-- NON PROYEK BAKP MEDIUM
union
select
	'non-proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_fungsi_bidang != 'Supply Chain Management'
	union
select
	'non-proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'' as nilai,
	'medium' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_fungsi_bidang = 'Supply Chain Management'
	union
select
	'non-proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'' as nilai,
	'medium' as kelas,
	1 as proyek_big,
	3 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_direktorat like '%KEUANGAN%'
-- NON PROYEK DSP-DEPKN HIGH
union
select
	'non-proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'high' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_fungsi_bidang = 'Supply Chain Management'
	union
select
	'non-proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'high' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT'
	union
select
	'non-proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'high' as kelas,
	0 as proyek_big,
	3 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_fungsi_bidang = 'Risk Management'
	union
select
	'non-proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'depkn-dsp' as tipe_dokumen,
	'' as nilai,
	'high' as kelas,
	0 as proyek_big,
	4 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'SENIOR VICE PRESIDENT' and nm_fungsi_bidang = 'Finance'
-- NON PROYEK BAKP HIGH
union
select
	'non-proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'' as nilai,
	'high' as kelas,
	0 as proyek_big,
	1 as order_no,
	*
	from
		response_hcis rh
	where
		nm_jabatan = 'DIREKTUR'
	union
select
	'non-proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'' as nilai,
	'high' as kelas,
	0 as proyek_big,
	2 as order_no,
	*
	from
		response_hcis rh
	where
		nm_direktorat IN ('DIR QUALTY,HLTH,SFTY,ENVRNMNT')
	union
select
	'non-proyek' as tipe_proyek,
	0 as is_category_management,
	'' as tipe_kontrak,
	'bakp' as tipe_dokumen,
	'' as nilai,
	'high' as kelas,
	0 as proyek_big,
	3 as order_no,
	*
	from
		response_hcis rh
	where
		nm_direktorat IN ('DIR KEUANGAN & MNJMN RISIKO')
