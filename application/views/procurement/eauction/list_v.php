<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.16.2/axios.js"></script>

<div class="wrapper wrapper-content animated fadeInRight">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="row">
          <div class="col-9">
            <div id="servertime"></div>
            
            <div class="row mb-1">
              <div class="col-12">
                <div class="card">        
                  <div class="card-header border-bottom pb-2">
                      <h4 class="card-title font-weight-bold">Perbaikan Distribusi Air di Gedung Wika 123</h4>
                  </div>
                  <div class="card-content">
                    <div class="card-body">

                        <div class="row mb-3">
                          <div class="col-lg-12">
                            <div class="card float-e-margins">
                              <div class="card-title">
                                <div class="card-tools">
                                  <a class="collapse-link">Peringkat Penawar disini
                                    <i class="fa fa-chevron-up"></i>
                                  </a>
                                </div>
                              </div>
                              <div class="card-content mt-2">

                                <div class="table-responsive">

                                  <table id="table_peringkat_penawar" class="table table-bordered table-striped">
                                    <thead>
                                      <tr>
                                        <th class="text-center" data-field='online'>Online</th>
                                        <th class="text-center" data-field='peringkat'>Peringkat</th>
                                        <th class="text-center" data-field='nama_vendor'>Nama Vendor</th>
                                        <th class="text-center" data-field='penawaran_saat_ini'>Penawaran Saat Ini</th>
                                        <th class="text-center" data-field='penawaran_sebelumnya'>Penawaran Sebelumnya</th>
                                        <th class="text-center" data-field='riwayat'>Riwayat</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td class="text-center"><i class="bi bi-circle-fill text-info" ></i></td>
                                        <td class="text-center">1</td>
                                        <td class="text-center">PT. Maju Jaya 1</td>
                                        <td class="text-center">1.200.000.000</td>
                                        <td class="text-center">1.300.000.000</td>
                                        <td class="text-center"><a class="btn btn-primary bg-info btn-xs action" href="#"><i class="bi bi-eye"></i> Lihat</a></td>
                                      </tr>
                                      <!-- <tr>
                                        <td class="text-center"><i class="bi bi-circle-fill text-danger" ></i></td>
                                        <td class="text-center">2</td>
                                        <td class="text-center">PT. Maju Jaya 3</td>
                                        <td class="text-center">1.300.000.000</td>
                                        <td class="text-center">1.350.000.000</td>
                                        <td class="text-center"><a class="btn btn-primary bg-info btn-xs action" href="#"><i class="bi bi-eye"></i> Lihat</a></td>
                                      </tr>
                                      <tr>
                                        <td class="text-center"><i class="bi bi-circle-fill text-danger" ></i></td>
                                        <td class="text-center">3</td>
                                        <td class="text-center">PT. Maju Jaya 4</td>
                                        <td class="text-center">1.320.000.000</td>
                                        <td class="text-center">1.380.000.000</td>
                                        <td class="text-center"><a class="btn btn-primary bg-info btn-xs action" href="#"><i class="bi bi-eye"></i> Lihat</a></td>
                                      </tr>
                                      <tr>
                                        <td class="text-center"><i class="bi bi-circle-fill text-danger" ></i></td>
                                        <td class="text-center">4</td>
                                        <td class="text-center">PT. Maju Jaya 2</td>
                                        <td class="text-center">1.400.000.000</td>
                                        <td class="text-center">1.450.000.000</td>
                                        <td class="text-center"><a class="btn btn-primary bg-info btn-xs action" href="#"><i class="bi bi-eye"></i> Lihat</a></td>
                                      </tr> -->
                                    </tbody>
                                  </table>

                                </div>

                              </div>
                            </div>


                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-lg-12">
                            <div class="card float-e-margins">
                              <div class="card-title">
                                <div class="card-tools">
                                  <a class="collapse-link">Ringkasan Statistik
                                    <i class="fa fa-chevron-up"></i>
                                  </a>
                                </div>
                              </div>
                              <div class="card-content mt-2">

                              <div class="row">
                                <div class="col-6">

                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Jumlah Penawaran
                                    </div>
                                    <div class="col-7">
                                    :  20
                                    </div>
                                  </div>
                                  
                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Perputaran Tempat Teratas
                                    </div>
                                    <div class="col-7">
                                    :  0
                                    </div>
                                  </div>
                                  
                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Established Bid Ceiling
                                    </div>
                                    <div class="col-7">
                                    :  Rp. 0
                                    </div>
                                  </div>
                                  
                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Established Bid Decrement
                                    </div>
                                    <div class="col-7">
                                    :  Rp. 0
                                    </div>
                                  </div>
                                  
                                </div>
                                <div class="col-6">

                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Kuantitas
                                    </div>
                                    <div class="col-7">
                                    :  0
                                    </div>
                                  </div>

                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      High - Low Spread %1st-2nd
                                    </div>
                                    <div class="col-7">
                                    :  10%
                                    </div>
                                  </div>
                                  
                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      High - Low Spread % Total
                                    </div>
                                    <div class="col-7">
                                    :  50%
                                    </div>
                                  </div>
                                  
                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Perhitungan Perpanjangan
                                    </div>
                                    <div class="col-7">
                                    : 0
                                    </div>
                                  </div>
                                  
                                  
                                </div>
                              </div>

                              </div>
                            </div>


                          </div>
                        </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>

            
            <div class="row mb-1">
              <div class="col-12">
                <div class="card">        
                  <div class="card-header border-bottom pb-2">
                      <h4 class="card-title font-weight-bold">Perbaikan Distribusi Air di Gedung Wika</h4>
                  </div>
                  <div class="card-content">
                    <div class="card-body">

                        <div class="row mb-3">
                          <div class="col-lg-12">
                            <div class="card float-e-margins">
                              <div class="card-title">
                                <div class="card-tools">
                                  <a class="collapse-link">Air Compressor
                                    <i class="fa fa-chevron-up"></i>
                                  </a>
                                </div>
                              </div>
                              <div class="card-content mt-2">

                                <div class="table-responsive">

                                  <table id="table_peringkat_penawar_aircompressor" class="table table-bordered table-striped">
                                    <thead>
                                      <tr>
                                        <th class="text-center">Online</th>
                                        <th class="text-center">Peringkat</th>
                                        <th class="text-center">Nama Vendor</th>
                                        <th class="text-center">Penawaran Saat Ini</th>
                                        <th class="text-center">Penawaran Sebelumnya</th>
                                        <th class="text-center">Riwayat</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td class="text-center"><i class="bi bi-circle-fill text-info" ></i></td>
                                        <td class="text-center">1</td>
                                        <td class="text-center">PT. Maju Jaya 1</td>
                                        <td class="text-center">1.200.000.000</td>
                                        <td class="text-center">1.300.000.000</td>
                                        <td class="text-center"><a class="btn btn-primary bg-info btn-xs action" href="#"><i class="bi bi-eye"></i> Lihat</a></td>
                                      </tr>
                                      <tr>
                                        <td class="text-center"><i class="bi bi-circle-fill text-danger" ></i></td>
                                        <td class="text-center">2</td>
                                        <td class="text-center">PT. Maju Jaya 3</td>
                                        <td class="text-center">1.300.000.000</td>
                                        <td class="text-center">1.350.000.000</td>
                                        <td class="text-center"><a class="btn btn-primary bg-info btn-xs action" href="#"><i class="bi bi-eye"></i> Lihat</a></td>
                                      </tr>
                                      <tr>
                                        <td class="text-center"><i class="bi bi-circle-fill text-danger" ></i></td>
                                        <td class="text-center">3</td>
                                        <td class="text-center">PT. Maju Jaya 4</td>
                                        <td class="text-center">1.320.000.000</td>
                                        <td class="text-center">1.380.000.000</td>
                                        <td class="text-center"><a class="btn btn-primary bg-info btn-xs action" href="#"><i class="bi bi-eye"></i> Lihat</a></td>
                                      </tr>
                                      <tr>
                                        <td class="text-center"><i class="bi bi-circle-fill text-danger" ></i></td>
                                        <td class="text-center">4</td>
                                        <td class="text-center">PT. Maju Jaya 2</td>
                                        <td class="text-center">1.400.000.000</td>
                                        <td class="text-center">1.450.000.000</td>
                                        <td class="text-center"><a class="btn btn-primary bg-info btn-xs action" href="#"><i class="bi bi-eye"></i> Lihat</a></td>
                                      </tr>
                                    </tbody>
                                  </table>

                                </div>

                              </div>
                            </div>


                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-lg-12">
                            <div class="card float-e-margins">
                              <div class="card-title">
                                <div class="card-tools">
                                  <a class="collapse-link">Ringkasan Statistik
                                    <i class="fa fa-chevron-up"></i>
                                  </a>
                                </div>
                              </div>
                              <div class="card-content mt-2">

                              <div class="row">
                                <div class="col-6">

                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Jumlah Penawaran
                                    </div>
                                    <div class="col-7">
                                    :  20
                                    </div>
                                  </div>
                                  
                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Perputaran Tempat Teratas
                                    </div>
                                    <div class="col-7">
                                    :  0
                                    </div>
                                  </div>
                                  
                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Established Bid Ceiling
                                    </div>
                                    <div class="col-7">
                                    :  Rp. 0
                                    </div>
                                  </div>
                                  
                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Established Bid Decrement
                                    </div>
                                    <div class="col-7">
                                    :  Rp. 0
                                    </div>
                                  </div>
                                  
                                </div>
                                <div class="col-6">

                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Kuantitas
                                    </div>
                                    <div class="col-7">
                                    :  0
                                    </div>
                                  </div>

                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      High - Low Spread %1st-2nd
                                    </div>
                                    <div class="col-7">
                                    :  10%
                                    </div>
                                  </div>
                                  
                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      High - Low Spread % Total
                                    </div>
                                    <div class="col-7">
                                    :  50%
                                    </div>
                                  </div>
                                  
                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Perhitungan Perpanjangan
                                    </div>
                                    <div class="col-7">
                                    : 0
                                    </div>
                                  </div>
                                  
                                  
                                </div>
                              </div>

                              </div>
                            </div>


                          </div>
                        </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>

                        
            <div class="row mb-1">
              <div class="col-12">
                <div class="card">        
                  <div class="card-header border-bottom pb-2">
                      <h4 class="card-title font-weight-bold">Perbaikan Distribusi Air di Gedung Wika</h4>
                  </div>
                  <div class="card-content">
                    <div class="card-body">

                        <div class="row mb-3">
                          <div class="col-lg-12">
                            <div class="card float-e-margins">
                              <div class="card-title">
                                <div class="card-tools">
                                  <a class="collapse-link">Solenoid
                                    <i class="fa fa-chevron-up"></i>
                                  </a>
                                </div>
                              </div>
                              <div class="card-content mt-2">

                                <div class="table-responsive">

                                  <table id="table_peringkat_penawar_solenoid" class="table table-bordered table-striped">
                                    <thead>
                                      <tr>
                                        <th class="text-center">Online</th>
                                        <th class="text-center">Peringkat</th>
                                        <th class="text-center">Nama Vendor</th>
                                        <th class="text-center">Penawaran Saat Ini</th>
                                        <th class="text-center">Penawaran Sebelumnya</th>
                                        <th class="text-center">Riwayat</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td class="text-center"><i class="bi bi-circle-fill text-info" ></i></td>
                                        <td class="text-center">1</td>
                                        <td class="text-center">PT. Maju Jaya 1</td>
                                        <td class="text-center">1.200.000.000</td>
                                        <td class="text-center">1.300.000.000</td>
                                        <td class="text-center"><a class="btn btn-primary bg-info btn-xs action" href="#"><i class="bi bi-eye"></i> Lihat</a></td>
                                      </tr>
                                      <tr>
                                        <td class="text-center"><i class="bi bi-circle-fill text-danger" ></i></td>
                                        <td class="text-center">2</td>
                                        <td class="text-center">PT. Maju Jaya 3</td>
                                        <td class="text-center">1.300.000.000</td>
                                        <td class="text-center">1.350.000.000</td>
                                        <td class="text-center"><a class="btn btn-primary bg-info btn-xs action" href="#"><i class="bi bi-eye"></i> Lihat</a></td>
                                      </tr>
                                      <tr>
                                        <td class="text-center"><i class="bi bi-circle-fill text-danger" ></i></td>
                                        <td class="text-center">3</td>
                                        <td class="text-center">PT. Maju Jaya 4</td>
                                        <td class="text-center">1.320.000.000</td>
                                        <td class="text-center">1.380.000.000</td>
                                        <td class="text-center"><a class="btn btn-primary bg-info btn-xs action" href="#"><i class="bi bi-eye"></i> Lihat</a></td>
                                      </tr>
                                      <tr>
                                        <td class="text-center"><i class="bi bi-circle-fill text-danger" ></i></td>
                                        <td class="text-center">4</td>
                                        <td class="text-center">PT. Maju Jaya 2</td>
                                        <td class="text-center">1.400.000.000</td>
                                        <td class="text-center">1.450.000.000</td>
                                        <td class="text-center"><a class="btn btn-primary bg-info btn-xs action" href="#"><i class="bi bi-eye"></i> Lihat</a></td>
                                      </tr>
                                    </tbody>
                                  </table>

                                </div>

                              </div>
                            </div>


                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-lg-12">
                            <div class="card float-e-margins">
                              <div class="card-title">
                                <div class="card-tools">
                                  <a class="collapse-link">Ringkasan Statistik
                                    <i class="fa fa-chevron-up"></i>
                                  </a>
                                </div>
                              </div>
                              <div class="card-content mt-2">

                              <div class="row">
                                <div class="col-6">

                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Jumlah Penawaran
                                    </div>
                                    <div class="col-7">
                                    :  20
                                    </div>
                                  </div>
                                  
                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Perputaran Tempat Teratas
                                    </div>
                                    <div class="col-7">
                                    :  0
                                    </div>
                                  </div>
                                  
                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Established Bid Ceiling
                                    </div>
                                    <div class="col-7">
                                    :  Rp. 0
                                    </div>
                                  </div>
                                  
                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Established Bid Decrement
                                    </div>
                                    <div class="col-7">
                                    :  Rp. 0
                                    </div>
                                  </div>
                                  
                                </div>
                                <div class="col-6">

                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Kuantitas
                                    </div>
                                    <div class="col-7">
                                    :  0
                                    </div>
                                  </div>

                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      High - Low Spread %1st-2nd
                                    </div>
                                    <div class="col-7">
                                    :  10%
                                    </div>
                                  </div>
                                  
                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      High - Low Spread % Total
                                    </div>
                                    <div class="col-7">
                                    :  50%
                                    </div>
                                  </div>
                                  
                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Perhitungan Perpanjangan
                                    </div>
                                    <div class="col-7">
                                    : 0
                                    </div>
                                  </div>
                                  
                                  
                                </div>
                              </div>

                              </div>
                            </div>


                          </div>
                        </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>

                        
            <div class="row mb-1">
              <div class="col-12">
                <div class="card">        
                  <div class="card-header border-bottom pb-2">
                      <h4 class="card-title font-weight-bold">Perbaikan Distribusi Air di Gedung Wika</h4>
                  </div>
                  <div class="card-content">
                    <div class="card-body">

                        <div class="row mb-3">
                          <div class="col-lg-12">
                            <div class="card float-e-margins">
                              <div class="card-title">
                                <div class="card-tools">
                                  <a class="collapse-link">Pressure Pipe
                                    <i class="fa fa-chevron-up"></i>
                                  </a>
                                </div>
                              </div>
                              <div class="card-content mt-2">

                                <div class="table-responsive">

                                  <table id="table_peringkat_penawar_pressurepipe" class="table table-bordered table-striped">
                                    <thead>
                                      <tr>
                                        <th class="text-center">Online</th>
                                        <th class="text-center">Peringkat</th>
                                        <th class="text-center">Nama Vendor</th>
                                        <th class="text-center">Penawaran Saat Ini</th>
                                        <th class="text-center">Penawaran Sebelumnya</th>
                                        <th class="text-center">Riwayat</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td class="text-center"><i class="bi bi-circle-fill text-info" ></i></td>
                                        <td class="text-center">1</td>
                                        <td class="text-center">PT. Maju Jaya 1</td>
                                        <td class="text-center">1.200.000.000</td>
                                        <td class="text-center">1.300.000.000</td>
                                        <td class="text-center"><a class="btn btn-primary bg-info btn-xs action" href="#"><i class="bi bi-eye"></i> Lihat</a></td>
                                      </tr>
                                      <tr>
                                        <td class="text-center"><i class="bi bi-circle-fill text-danger" ></i></td>
                                        <td class="text-center">2</td>
                                        <td class="text-center">PT. Maju Jaya 3</td>
                                        <td class="text-center">1.300.000.000</td>
                                        <td class="text-center">1.350.000.000</td>
                                        <td class="text-center"><a class="btn btn-primary bg-info btn-xs action" href="#"><i class="bi bi-eye"></i> Lihat</a></td>
                                      </tr>
                                      <tr>
                                        <td class="text-center"><i class="bi bi-circle-fill text-danger" ></i></td>
                                        <td class="text-center">3</td>
                                        <td class="text-center">PT. Maju Jaya 4</td>
                                        <td class="text-center">1.320.000.000</td>
                                        <td class="text-center">1.380.000.000</td>
                                        <td class="text-center"><a class="btn btn-primary bg-info btn-xs action" href="#"><i class="bi bi-eye"></i> Lihat</a></td>
                                      </tr>
                                      <tr>
                                        <td class="text-center"><i class="bi bi-circle-fill text-danger" ></i></td>
                                        <td class="text-center">4</td>
                                        <td class="text-center">PT. Maju Jaya 2</td>
                                        <td class="text-center">1.400.000.000</td>
                                        <td class="text-center">1.450.000.000</td>
                                        <td class="text-center"><a class="btn btn-primary bg-info btn-xs action" href="#"><i class="bi bi-eye"></i> Lihat</a></td>
                                      </tr>
                                    </tbody>
                                  </table>

                                </div>

                              </div>
                            </div>


                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-lg-12">
                            <div class="card float-e-margins">
                              <div class="card-title">
                                <div class="card-tools">
                                  <a class="collapse-link">Ringkasan Statistik
                                    <i class="fa fa-chevron-up"></i>
                                  </a>
                                </div>
                              </div>
                              <div class="card-content mt-2">

                              <div class="row">
                                <div class="col-6">

                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Jumlah Penawaran
                                    </div>
                                    <div class="col-7">
                                    :  20
                                    </div>
                                  </div>
                                  
                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Perputaran Tempat Teratas
                                    </div>
                                    <div class="col-7">
                                    :  0
                                    </div>
                                  </div>
                                  
                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Established Bid Ceiling
                                    </div>
                                    <div class="col-7">
                                    :  Rp. 0
                                    </div>
                                  </div>
                                  
                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Established Bid Decrement
                                    </div>
                                    <div class="col-7">
                                    :  Rp. 0
                                    </div>
                                  </div>
                                  
                                </div>
                                <div class="col-6">

                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Kuantitas
                                    </div>
                                    <div class="col-7">
                                    :  0
                                    </div>
                                  </div>

                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      High - Low Spread %1st-2nd
                                    </div>
                                    <div class="col-7">
                                    :  10%
                                    </div>
                                  </div>
                                  
                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      High - Low Spread % Total
                                    </div>
                                    <div class="col-7">
                                    :  50%
                                    </div>
                                  </div>
                                  
                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Perhitungan Perpanjangan
                                    </div>
                                    <div class="col-7">
                                    : 0
                                    </div>
                                  </div>
                                  
                                  
                                </div>
                              </div>

                              </div>
                            </div>


                          </div>
                        </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>

                        
            <div class="row mb-1">
              <div class="col-12">
                <div class="card">        
                  <div class="card-header border-bottom pb-2">
                      <h4 class="card-title font-weight-bold">Perbaikan Distribusi Air di Gedung Wika</h4>
                  </div>
                  <div class="card-content">
                    <div class="card-body">

                        <div class="row mb-3">
                          <div class="col-lg-12">
                            <div class="card float-e-margins">
                              <div class="card-title">
                                <div class="card-tools">
                                  <a class="collapse-link">Pressure Gauge
                                    <i class="fa fa-chevron-up"></i>
                                  </a>
                                </div>
                              </div>
                              <div class="card-content mt-2">

                                <div class="table-responsive">

                                  <table id="table_peringkat_penawar_pressuregauge" class="table table-bordered table-striped">
                                    <thead>
                                      <tr>
                                        <th class="text-center">Online</th>
                                        <th class="text-center">Peringkat</th>
                                        <th class="text-center">Nama Vendor</th>
                                        <th class="text-center">Penawaran Saat Ini</th>
                                        <th class="text-center">Penawaran Sebelumnya</th>
                                        <th class="text-center">Riwayat</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td class="text-center"><i class="bi bi-circle-fill text-info" ></i></td>
                                        <td class="text-center">1</td>
                                        <td class="text-center">PT. Maju Jaya 1</td>
                                        <td class="text-center">1.200.000.000</td>
                                        <td class="text-center">1.300.000.000</td>
                                        <td class="text-center"><a class="btn btn-primary bg-info btn-xs action" href="#"><i class="bi bi-eye"></i> Lihat</a></td>
                                      </tr>
                                      <tr>
                                        <td class="text-center"><i class="bi bi-circle-fill text-danger" ></i></td>
                                        <td class="text-center">2</td>
                                        <td class="text-center">PT. Maju Jaya 3</td>
                                        <td class="text-center">1.300.000.000</td>
                                        <td class="text-center">1.350.000.000</td>
                                        <td class="text-center"><a class="btn btn-primary bg-info btn-xs action" href="#"><i class="bi bi-eye"></i> Lihat</a></td>
                                      </tr>
                                      <tr>
                                        <td class="text-center"><i class="bi bi-circle-fill text-danger" ></i></td>
                                        <td class="text-center">3</td>
                                        <td class="text-center">PT. Maju Jaya 4</td>
                                        <td class="text-center">1.320.000.000</td>
                                        <td class="text-center">1.380.000.000</td>
                                        <td class="text-center"><a class="btn btn-primary bg-info btn-xs action" href="#"><i class="bi bi-eye"></i> Lihat</a></td>
                                      </tr>
                                      <tr>
                                        <td class="text-center"><i class="bi bi-circle-fill text-danger" ></i></td>
                                        <td class="text-center">4</td>
                                        <td class="text-center">PT. Maju Jaya 2</td>
                                        <td class="text-center">1.400.000.000</td>
                                        <td class="text-center">1.450.000.000</td>
                                        <td class="text-center"><a class="btn btn-primary bg-info btn-xs action" href="#"><i class="bi bi-eye"></i> Lihat</a></td>
                                      </tr>
                                    </tbody>
                                  </table>

                                </div>

                              </div>
                            </div>


                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-lg-12">
                            <div class="card float-e-margins">
                              <div class="card-title">
                                <div class="card-tools">
                                  <a class="collapse-link">Ringkasan Statistik
                                    <i class="fa fa-chevron-up"></i>
                                  </a>
                                </div>
                              </div>
                              <div class="card-content mt-2">

                              <div class="row">
                                <div class="col-6">

                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Jumlah Penawaran
                                    </div>
                                    <div class="col-7">
                                    :  20
                                    </div>
                                  </div>
                                  
                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Perputaran Tempat Teratas
                                    </div>
                                    <div class="col-7">
                                    :  0
                                    </div>
                                  </div>
                                  
                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Established Bid Ceiling
                                    </div>
                                    <div class="col-7">
                                    :  Rp. 0
                                    </div>
                                  </div>
                                  
                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Established Bid Decrement
                                    </div>
                                    <div class="col-7">
                                    :  Rp. 0
                                    </div>
                                  </div>
                                  
                                </div>
                                <div class="col-6">

                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Kuantitas
                                    </div>
                                    <div class="col-7">
                                    :  0
                                    </div>
                                  </div>

                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      High - Low Spread %1st-2nd
                                    </div>
                                    <div class="col-7">
                                    :  10%
                                    </div>
                                  </div>
                                  
                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      High - Low Spread % Total
                                    </div>
                                    <div class="col-7">
                                    :  50%
                                    </div>
                                  </div>
                                  
                                  <div class="row text-left">
                                    <div class="col-5 font-weight-bold" >
                                      Perhitungan Perpanjangan
                                    </div>
                                    <div class="col-7">
                                    : 0
                                    </div>
                                  </div>
                                  
                                  
                                </div>
                              </div>

                              </div>
                            </div>


                          </div>
                        </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>


          </div>
          <div class="col-3">
            <div class="row">
                <div class="col-12">
                  <div class="card">        
                    <div class="card-header border-bottom pb-2">
                        <h4 class="card-title font-weight-bold">Riwayat Penawaran</h4>
                    </div>
                    <div class="card-content">
                      <div class="card-body">

                        <div class="table-responsive">

                          <div class="col-12">

                            <div class="row mb-2 pb-2 border-bottom">
                              
                              <div class="col-6">
                                <div class="row">
                                  <span style="font-size:1.2em;" class="font-weight-bold">Rp. 1.200.000.000</span>
                                </div>
                                <div class="row text-muted">
                                  PT. Maju Jaya 1
                                </div>
                                <div class="row">
                                  <div class="text-info">
                                    Semua Sumberdaya
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="row justify-content-end text-muted text-right">
                                  27/01/2022 21:00
                                </div>
                                <div class="row justify-content-end h-auto">
                                  <h3>
                                    <i class="bi bi-hammer text-info"></i>
                                    <i class="bi bi-arrow-down-circle-fill text-info"></i>
                                  </h3>
                                </div>
                                <div class="row  justify-content-end text-right">
                                  <span class="badge badge-light text-info">Take Lead</span>
                                </div>
                              </div>

                            </div>
                            
                            
                            <div class="row pt-2 pb-2 border-bottom">
                              
                              <div class="col-6">
                                <div class="row">
                                  <span style="font-size:1.2em;" class="font-weight-bold">Rp. 200.000.000</span>
                                </div>
                                <div class="row text-muted">
                                  PT. Maju Jaya 3
                                </div>
                                <div class="row">
                                  <div class="text-info">
                                    Air Compressor
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="row justify-content-end text-muted text-right">
                                  27/01/2022 21:00
                                </div>
                                <div class="row justify-content-end h-auto">
                                  <h3>
                                    <i class="bi bi-arrow-down-circle-fill text-info"></i>
                                  </h3>
                                </div>
                                <div class="row  justify-content-end text-right">
                                  <span class="badge badge-info text-white">Lower Price</span>
                                </div>
                              </div>

                            </div>
                            
                            <div class="collapse" id="collapseHistory">
                              
                              <div class="row pt-2 pb-2 border-bottom">
                                
                                <div class="col-6">
                                  <div class="row">
                                    <span style="font-size:1.2em;" class="font-weight-bold">Rp. 600.000.000</span>
                                  </div>
                                  <div class="row text-muted">
                                    PT. Maju Jaya 2
                                  </div>
                                  <div class="row">
                                    <div class="text-info">
                                      Pressure Gauge
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="row justify-content-end text-muted text-right">
                                    27/01/2022 21:00
                                  </div>
                                  <div class="row justify-content-end h-auto">
                                    <h3>
                                      <i class="bi bi-arrow-down-circle-fill text-info"></i>
                                    </h3>
                                  </div>
                                  <div class="row  justify-content-end text-right">
                                    <span class="badge badge-info text-white">Lower Price</span>
                                  </div>
                                </div>

                              </div>

                              <div class="row pt-2 pb-2 border-bottom">
                                
                                <div class="col-6">
                                  <div class="row">
                                    <span style="font-size:1.2em;" class="font-weight-bold">Rp. 1.200.000.000</span>
                                  </div>
                                  <div class="row text-muted">
                                    PT. Maju Jaya 1
                                  </div>
                                  <div class="row">
                                    <div class="text-info">
                                      Pressure Pipe
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="row justify-content-end text-muted text-right">
                                    27/01/2022 21:00
                                  </div>
                                  <div class="row justify-content-end h-auto">
                                    <h3>
                                      <i class="bi bi-arrow-down-circle-fill text-info"></i>
                                    </h3>
                                  </div>
                                  <div class="row  justify-content-end text-right">
                                    <span class="badge badge-info text-white">Lower Price</span>
                                  </div>
                                </div>

                              </div>

                              <div class="row pt-2 pb-2 border-bottom">
                                
                                <div class="col-6">
                                  <div class="row">
                                    <span style="font-size:1.2em;" class="font-weight-bold">Rp. 1.200.000.000</span>
                                  </div>
                                  <div class="row text-muted">
                                    PT. Maju Jaya 1
                                  </div>
                                  <div class="row">
                                    <div class="text-info">
                                      Solenoid
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="row justify-content-end text-muted text-right">
                                    27/01/2022 21:00
                                  </div>
                                  <div class="row justify-content-end h-auto">
                                    <h3>
                                      <i class="bi bi-arrow-down-circle-fill text-info"></i>
                                    </h3>
                                  </div>
                                  <div class="row  justify-content-end text-right">
                                    <span class="badge badge-info text-white">Lower Price</span>
                                  </div>
                                </div>

                              </div>
                            



                            </div>
                            
                            <div class="row mt-1 justify-content-center">
                              
                              <a class="collapse-link text-center text-info"  
                              data-toggle="collapse" href="#collapseHistory" role="button" 
                              aria-expanded="false" aria-controls="collapseHistory"> Show All
                                <i class="fa fa-chevron-down"></i>
                              </a>
                            </div>
                            

                          </div>

                        </div>

                      </div>
                    </div>
                  </div>
                </div>
            </div>


          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script type="text/javascript">

  //https://stackoverflow.com/questions/1349404/generate-random-string-characters-in-javascript
  function makeid(length) {
      var result           = '';
      var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
      var charactersLength = characters.length;
      for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
  }


  $(function () {
    var table_peringkat_penawar = $('#table_peringkat_penawar')

    table_peringkat_penawar.bootstrapTable({
      search:true,
    });

    Pusher.logToConsole = true;

    var pusher = new Pusher('<?php $this->load->config("pusher"); echo $this->config->item('PUSHER_key');?>', {
      cluster: 'ap1'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
      table_peringkat_penawar.bootstrapTable('append', JSON.parse(data['message']))
    });

    setInterval(function () {
      //Secara random ngepush event ke pusher
      if(Math.floor(Math.random() * 11) < 5 ){

        data = {
                'online' : (Math.floor(Math.random() * 11) < 5) ? '<i class="bi bi-circle-fill text-info" ></i>' : '<i class="bi bi-circle-fill text-danger" ></i>',
                'peringkat' : Math.floor(Math.random() * 10),
                'nama_vendor' : `PT. ${makeid(10)}`,
                'penawaran_saat_ini' : Math.floor(Math.random() * 100)  * 100000000,
                'penawaran_sebelumnya' : Math.floor(Math.random() * 100)  * 100000000,
                'riwayat' : '<a class="btn btn-primary bg-info btn-xs action" href="#"><i class="bi bi-eye"></i> Zoom</a>',
        }
        var formData = new FormData();

        formData.append('message',JSON.stringify(data))
        fetch("<?php echo site_url('pusher/sendMessage') ?>",
          {
              method: "POST",
              body: formData
          })
        }

    }, 1500);


});

</script>