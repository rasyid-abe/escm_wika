<?php
//shares stated declaration
//Include
$activity_first=0;
$activity_second=0;
$activity_third=0;
$activity_last=0;
$activity_cancel=0;

switch ($mod) {
  case 'wo':
  $activity_first=2031; 	// Pembuatan Wo Matgis
  $activity_second=2032; 	// Persetujuan Wo Matgis
  $activity_third=2033; 	// WO Matgis Aktif
  $activity_last=2035; 		// WO Matgis Selesai
  $activity_cancel=2034; 	// Wo Matgis dibatalkan
  break;

  case 'si':
  $activity_first=2040; 	// Pembuatan SI Matgis
  $activity_last=2042; 		// SI Matgis Aktif
  $activity_cancel=2041; 	// Wo Matgis dibatalkan
  break;

  case 'sppm':
  $activity_first=2050; 	// Pembuatan SPPM Matgis
  $activity_last=2052; 		// SPPM Matgis Aktif
  $activity_cancel=2051; 	// SPPM Matgis dibatalkan
  break;

  case 'do':
  $activity_first=2060; 	// Pembuatan DO Matgis
  $activity_last=2062; 		// DO Matgis Aktif
  $activity_cancel=2061; 	// DO Matgis dibatalkan
  break;

  case 'sj':
  $activity_first=2070; 	// Pembuatan SJ Matgis
  $activity_last=2072; 		// SJ Matgis Aktif
  $activity_cancel=2071; 	// SJ Matgis dibatalkan
  break;

  case 'bapb':
  $activity_first=2080; 	// Pembuatan BAPB Matgis
  $activity_second=2083; 	// Persetujuan BAPB
  $activity_last=2082; 		// BAPB Matgis Aktif
  $activity_cancel=2081; 	// BAPB Matgis dibatalkan
  break;

  case 'inv':
  $activity_first=2090; 	// Pembuatan Inv Matgis
  $activity_second=2092; 		// Pengajuan Invoice
  $activity_last=2093; 		// Inv Matgis Aktif
  $activity_cancel=2091; 	// Inv Matgis dibatalkan
  break;
  default:
  break;
}
