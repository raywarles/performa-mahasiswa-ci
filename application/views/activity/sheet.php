<div class="row">
    <div class="col-sm-3">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Detail Activity</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body" id="tampil_jawaban">
                <table class="table table-striped">
                    <tr>
                        <td>Jenis Activity</td>
                        <td>:</td>
                        <td><?php echo $activity->komponen; ?></td>
                    </tr>
                    <tr>
                        <td>Nama Activity</td>
                        <td>:</td>
                        <td><?php echo $activity->nama_activity; ?></td>
                    </tr>
                    <tr>
                        <td>Dosen</td>
                        <td>:</td>
                        <td><?php echo $activity->nama_dosen; ?></td>
                    </tr>
                    <tr>
                        <td>Mata Kuliah</td>
                        <td>:</td>
                        <td><?php echo $activity->nama_matkul; ?></td>
                    </tr>
                    <tr>
                        <td>Nip</td>
                        <td>:</td>
                        <td><?php echo $mhs->nim; ?></td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td><?php echo $mhs->nama; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-9">
        <!-- ?=form_open_multipart('activity/save_sheet', array('id'=>'activity'), array('activity_id'=> $activity->id_activity,'mahasiswa_id'=> $mhs->id_mahasiswa));?> -->
        <form action="<?= base_url() ?>activity/save_sheet" method="post" id="activity" enctype="multipart/form-data">
            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
            <input type="hidden" name="activity_id" value="<?php echo $activity->id_activity ?>">
            <input type="hidden" name="mahasiswa_id" value="<?php echo $mhs->id_mahasiswa ?>">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><span class="badge bg-blue">Jumlah Soal : <?php echo count($soal) ?> </span></h3>
                <div class="box-tools pull-right">
                    <!-- <span class="badge bg-red">Sisa Waktu <span class="sisawaktu" data-time="<?=$activity->tgl_selesai?>"></span></span> -->
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body panel panel-understanding-check">
                <?php $no = 0; foreach($soal as $sol){  $no++; ?>
                    <div class="form-group">
                        <label for="radio"><?php echo $no; ?>. <?php echo $sol->soal; ?> (<?php echo $sol->jenis ?>)</label>
                        <input type="hidden" name="soalnya[<?php echo $sol->id ?>]" value="<?php echo $sol->id ?>" >
                        <input type="hidden" name="jenis[<?php echo $sol->id ?>]" value="<?php echo $sol->jenis ?>" >
                        <?php if($sol->jenis == 'Pilihan Ganda') {?>
                        <div class="radio">
                            <label>
                                <input type="radio" data-question-number="87518975480" name="jawaban[<?php echo $sol->id ?>]" id="bsr-radios-97468235240" data-alert-type="alert-danger" data-comment="<strong>Incorrect</strong><br>Lorem ipsum dolor sit amet, consectetur adipisicing elit." value="A">
                                A. <?php echo $sol->opsi_a; ?>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" data-question-number="87518975480" name="jawaban[<?php echo $sol->id ?>]" id="bsr-radios-97468235241" data-alert-type="alert-danger" data-comment="<strong>Incorrect</strong><br>Lorem ipsum dolor sit amet, consectetur adipisicing elit." value="B">
                                B. <?php echo $sol->opsi_b; ?>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" data-question-number="87518975480" name="jawaban[<?php echo $sol->id ?>]" id="bsr-radios-97468235242" data-alert-type="alert-danger" data-comment="<strong>Incorrect</strong><br>Lorem ipsum dolor sit amet, consectetur adipisicing elit." value="C">
                                C. <?php echo $sol->opsi_c; ?>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" data-question-number="87518975480" name="jawaban[<?php echo $sol->id ?>]" id="bsr-radios-97468235243" data-alert-type="alert-success" data-comment="<strong>Correct</strong><br>Lorem ipsum dolor sit amet, consectetur adipisicing elit." value="D">
                                D. <?php echo $sol->opsi_d; ?>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" data-question-number="87518975480" name="jawaban[<?php echo $sol->id ?>]" id="bsr-radios-97468235243" data-alert-type="alert-success" data-comment="<strong>Correct</strong><br>Lorem ipsum dolor sit amet, consectetur adipisicing elit." value="E">
                                E. <?php echo $sol->opsi_e; ?>
                            </label>
                        </div>
                        <?php } elseif($sol->jenis == 'Essay'){ ?>
                            <div class="form-group">
                                <textarea class="form-control" name="jawaban[<?php echo $sol->id ?>]"></textarea>
                            </div>
                        <?php } else{?>
                            <div class="form-group">
                               <input type="file" name="jawaban[<?php echo $sol->id ?>]" class="form-control">
                            </div>
                        <?php } ?>
                    </div>
                    <hr>
                 <?php } ?>
            </div>
            <div class="box-footer text-center">
                <!-- <a class="action back btn btn-info" rel="0" onclick="return back();"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
                <a class="ragu_ragu btn btn-warning" rel="1" onclick="return tidak_jawab();">Ragu-ragu</a>
                <a class="action next btn btn-info" rel="2" onclick="return next();"><i class="glyphicon glyphicon-chevron-right"></i> Next</a> -->
                <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-stop"></i> Selesai</button>
                <input type="hidden" name="jml_soal" id="jml_soal" value="<?=$no; ?>">
            </div>
        </div>
        </form>
       <!--  <?=form_close();?> -->
    </div>
</div>

<script type="text/javascript">
    var base_url = "<?=base_url(); ?>";
</script>

<!-- <script src="<?=base_url()?>assets/dist/js/app/activity/sheet.js"></script> -->