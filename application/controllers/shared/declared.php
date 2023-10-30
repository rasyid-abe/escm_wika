<?php
//shares stated declaration
//Include
$activity_first=0;
$activity_second=0;
$activity_third=0;
$activity_last=0;
$activity_cancel=0;

switch ($mod) {
  case 'po':
  $activity_first=2031; 	// Pembuatan Wo Matgis
  $activity_second=2032; 	// Persetujuan Wo Matgis
  $activity_active=2033; 	// PO Matgis Aktif
  $activity_last=2035; 		// WO Matgis Selesai
  $activity_cancel=2034; 	// Wo Matgis dibatalkan
  $activity_revise_po=2036; 	// SKBDN
  $activity_skbdn=2037; 	// SKBDN
  $activity_approved_po=2038;
  $activity_approve_vendor=2039;
  $activity_draft=2044;
  break;

  
  case 'si':
  $activity_first=2040; 	// Pembuatan SI Matgis
  $activity_last=2042; 		// SI Matgis Aktif
  $activity_draft=2043; 		// SI Matgis Draft
  $activity_cancel=2041; 	// Wo Matgis dibatalkan
  break;

  case 'sppm':
  $activity_first=2050; 	// Pembuatan SPPM Matgis
  $activity_second=2053; 	// Persetujuan SPPM
  $activity_last=2052; 		// SPPM Matgis Aktif
  $activity_cancel=2051; 	// SPPM Matgis dibatalkan
  $activity_draft=2054; 		// SI Matgis Draft
  break;

  case 'do':
  $activity_first=2060; 	// Pembuatan DO Matgis
  $activity_last=2062; 		// DO Matgis Aktif
  $activity_cancel=2061; 	// DO Matgis dibatalkan
  $activity_draft=2063; 		// SI Matgis Draft
  break;

  case 'sj':
  $activity_first=2070; 	// Pembuatan SJ Matgis
  $activity_last=2072; 		// SJ Matgis Aktif
  $activity_cancel=2071; 	// SJ Matgis dibatalkan
  $activity_draft=2073; 		// SI Matgis Draft
  break;

  case 'bapb':
  $activity_first=2080; 	// Pembuatan BAPB Matgis
  $activity_second=2083; 	// Pembuatan BAPB Matgis
  $activity_last=2082; 		// BAPB Matgis Aktif
  $activity_cancel=2081; 	// BAPB Matgis dibatalkan
  $activity_draft=2084; 		// SI Matgis Draft
  break;

  case 'inv':
  $activity_first=2090; 	// Pembuatan Inv Matgis
  $activity_second=2092; 		// Inv Matgis Selesai
  $activity_cancel=2091; 	// Inv Matgis dibatalkan
  $activity_last=2093; 	// Inv Matgis Aktif
  $activity_draft=2094; 	// draft Matgis Aktif
  break;
  default:
  break;
}
