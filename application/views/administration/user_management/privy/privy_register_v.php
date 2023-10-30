<style>
  .bold-td 
  {
    font-weight: bold;
  }
</style>
<div class="wrapper wrapper-content">
<section class="users-view">
                    
                            <div class="col-12">
                                <!-- Card data starts -->
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form method="POST" enctype="multipart/form-data" action="<?=base_url() ?>/privy/registration">
                                        <h5 class="mb-2 text-bold-500"><i class="ft-info mr-2"></i> Register Info</h5>
                                            <div class="row">
                                                <div class="col-12 col-xl-12">
                                                    <table class="table table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <td class="bold-td">email:</td>
                                                                <td><input class="form-control" type="email" required name="email"></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bold-td">phone:</td>
                                                                <td><input class="form-control" maxlength="12"  required type="text" name="phone"></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bold-td">selfie photo:</td>
                                                                <td><input class="form-control" type="file" required name="selfie"></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bold-td">ktp photo:</td>
                                                                <td><input class="form-control" type="file" required name="ktp"></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bold-td">nik:</td>
                                                                <td><input class="form-control" maxlength="16" required type="number" name="nik"></td>
                                                            </tr>

                                                            <tr>
                                                                <td class="bold-td">nama:</td>
                                                                <td><input class="form-control" required type="text" name="nama"></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bold-td">Tanggal Lahir:</td>
                                                                <td><input class="form-control" required type="date" name="tanggal_lahir"></td>
                                                            </tr>

                                                            <tr>
                                                                <td class="bold-td"> </td>
                                                                <td><button type="submit" class="btn btn-info" >SUBMIT</button></td>
                                                            </tr>
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                               
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card data ends -->
                            </div>
                            
                                                      
                        </div>
                    </section>
</div>
