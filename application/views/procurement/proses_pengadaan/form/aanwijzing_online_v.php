<?php if(!empty($prep['ptp_aanwijzing_online'])){ ?>
<style type="text/css">
  .badge-success {
    background-color: #468847 !important;
  }
  .badge-secondary {
    background-color: #999999 !important;
    color: white !important;
  }
</style>

<div class="row" id="aanwijzing_online">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Aanwijzing Online</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
            <div id="chat" class="wrapper">
              <div class="container">
                <div class="left">
                  <div class="top">
                    <?php $isonline = ($user_aanwijzing[$userdata['complete_name']] == "Online"); ?>
                    <h1>Chat <input type="checkbox" id="checkonline" <?php echo ($isonline) ? "checked" : "" ?> data-toggle="toggle"></h1>
                  </div>
                  <ul class="people">
                    <?php 
                    if (array_key_exists($userdata['complete_name'], $user_aanwijzing)) {
                          $new_value = array($userdata['complete_name'] =>$user_aanwijzing[$userdata['complete_name']]);
                          unset($user_aanwijzing[$userdata['complete_name']]);
                          $user_aanwijzing = array_merge($new_value,$user_aanwijzing);


                    foreach ($user_aanwijzing as $key => $value) { ?>
                    <li class="person <?php echo ($key == $userdata['complete_name']) ? "active" : "" ?>" data-user="<?php echo strtoupper($key) ?>">
                      <span class="name"><?php echo $key ?></span>
                      <span class="time <?php echo ($value == "Online") ? "active" : "" ?>" id="status">
                      <?php
                        if ($value == 'Online') {
                          echo "<span class='badge badge-success'>".$value."</span>";
                        } elseif ($value == 'Offline') {
                          echo "<span class='badge badge-secondary'>".$value."</span>";
                        }else{
                          echo html_entity_decode($value);
                        }
                        ?>
                      </span>
                    </li>
                    <?php } }?>
                  </ul>
                </div>
                <div class="right">

                  <div class="top"></div>

                  <div class="chat" data-chat="chat-aanwijzing">
                        <br/>
                        <?php foreach ($chat_aanwijzing as $key => $value) {
                            $isyou = ($userdata['complete_name'] == $value['name_ac']); ?>
                            <div class='bubble <?php echo ($isyou) ? "me" : "you" ?>'>
                                <?php if(!$isyou){ ?>
                                <?php echo $value['name_ac'] ?><br/>
                                <?php } ?>
                                <?php echo $value['message_ac'] ?><br/><small>(<?php echo date("d/m/y H:i",strtotime($value['datetime_ac'])) ?>)</small>
                            </div>
                        <?php } ?>
                  </div>

                  <div class="write">
                    <input type="text" id="chat-input"/>
                    <a class="write-link send"></a>
                  </div>
                  
                </div>
              </div>
            </div>
        </div>
      </div>

    </div>
  </div>
</div>

<link href="<?php echo base_url('assets/css/aanwijzing.css') ?>" rel="stylesheet">
<script type="text/javascript">
  const tenderid_aanwijzing = "<?php echo $permintaan['ptm_number'] ?>";
  const username_aanwijzing = "<?php echo $userdata['complete_name'] ?>";
  const submiturl_aanwijzing = "<?php echo site_url('procurement/sendaanwijzing') ?>";
</script>
<script type="text/javascript" src="<?php echo base_url('assets/js/aanwijzing.js') ?>"></script>

<?php } ?>