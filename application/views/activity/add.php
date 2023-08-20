<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$subjudul?></h3>
        <div class="box-tools pull-right">
            <a href="<?=base_url()?>activity/master" class="btn btn-sm btn-flat btn-warning">
                <i class="fa fa-arrow-left"></i> Batal
            </a>
        </div>
    </div>
    <?=form_open_multipart('activity/save', array('id'=>'formactivity'), array('method'=>'add','dosen_id'=>$dosen->id_dosen, 'matkul_id'=>$matkul->matkul_id))?>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                <div class="alert bg-purple">
                    <h4>Mata Kuliah <i class="fa fa-book pull-right"></i></h4>
                    <p><?=$matkul->nama_matkul?></p>
                </div>
                <div class="alert bg-purple">
                    <h4>Dosen <i class="fa fa-address-book-o pull-right"></i></h4>
                    <p><?=$dosen->nama_dosen?></p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                   <label for="komponen">Jenis Activity</label>  
                    <select name="komponen_id" id="komponen" class="form-control select2" style="width: 100%!important">
                        <?php foreach ($komponen as $test2) : ?>
                            <option value="<?=$test2['id_komponen']?>"><?=$test2['komponen']?></option>
                        <?php endforeach; ?>
                    </select>
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="nama_activity">Nama activity</label>
                    <input autofocus="autofocus" onfocus="this.select()" id="nama_activity" placeholder="Nama activity" type="text" class="form-control" name="nama_activity">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="tgl_mulai">Tanggal</label>
                    <input name="tgl_mulai" type="text" class="datetimepicker form-control" placeholder="Tanggal">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="tgl_selesai">Tanggal Selesai</label>
                    <input name="tgl_selesai" type="text" class="datetimepicker form-control" placeholder="Tanggal Selesai">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="waktu">Waktu</label>
                    <input placeholder="menit" type="number" class="form-control" name="waktu">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                  
                   <label for="kelas">Kelas</label>  
                    <select name="kelas_id" id="kelas" class="form-control select2" style="width: 100%!important">
                        <option value="all">Semua</option>
                        <?php foreach ($kelas as $test) : ?>
                            <option value="<?=$test['kelas_id']?>"><?=$test['nama_kelas']?></option>
                        <?php endforeach; ?>
                    </select>
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="kelas">Tambah Soal :</label>  
                    <input type="button" class="btn btn-default" name="btnTicket" id="btnTicket" value="Tambah" /> 
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">     
                <div class="form-group">  
                    <div class="row">  
                        <div class="col-md-12"> 
                            <input type="hidden" name="soalrow" id="soalrow" value="0">
                            <div class="table-responsive" style="overflow-x: auto !important;">  
                                <table class="table table-striped table-bordered" id="tbl">  
                                    <thead>
                                        <tr>  
                                            <th>ID</th>  
                                            <th>Soal</th>  
                                            <th>Jenis</th>  
                                            <th>Opsi A</th>
                                            <th>Opsi B</th>
                                            <th>Opsi C</th>
                                            <th>Opsi D</th>
                                            <th>Opsi E</th>
                                            <th>Jawaban</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="barissoal">
                                        
                                    </tbody>
                                </table>
                            </div>  
                        </div>  
                    </div>  
                </div> 
                <div class="form-group pull-right">
                    <button type="reset" class="btn btn-default btn-flat">
                        <i class="fa fa-rotate-left"></i> Reset
                    </button>
                    <button id="submit" type="submit" class="btn btn-flat bg-purple"><i class="fa fa-save"></i> Simpan</button>
                </div>  
            </div>
            
        </div>
    </div>
    <?=form_close()?>
</div>
<!-- <script>
    function initialize(){
        initializex();
    }
    function initializex(){
        $( '#barissoal' ).append(add_row_soal( 0, 0 ));    
    }

    function add_row_soal(i, action){
        var tblRow = '<tr id="row' + i + '"><td><label>' + i + '</label></td><td><textarea type="text" name"soal['+i+'][soal]" class="form-control" placeholder="Soal" id="soal-'+i+'-soal" /></textarea></td><td><input type="file" class="form-control" name"soal['+i+'][gambar]" id="soal-'+i+'-gambar" /></td><td><select class="form-control" name"soal['+i+'][jenis]"><option>Pilihan Ganda</option><option>Essay</option><option>File</option><select></td><td><input type="text" name"soal['+i+'][opsi_a]" class="form-control" id="soal-'+i+'-opsi_a" /></td><td><input type="text" name"soal['+i+'][opsi_b]" class="form-control" id="soal-'+i+'-opsi_b" /></td><td><input type="text" name"soal['+i+'][opsi_c]" class="form-control" id="soal-'+i+'-opsi_c" /></td><td><input type="text" name"soal['+i+'][opsi_d]" class="form-control" id="soal-'+i+'-opsi_d" /></td><td><input type="text" name"soal['+i+'][opsi_d]" class="form-control" id="soal-'+i+'-opsi_d" /></td><td><select class="form-control" name"soal['+i+'][kunci]"><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><select></td><td><input type="button" class="btn btn-danger" id="btnDelete' + i + '" onclick="DeleteTicket(' + i + ')" value="Delete" /></td> </tr>'    
        //append the row to the table.      
        $( "#soalrow" ).val( i + 1 );
        return tblRow;
    }
</script> -->
<script src="<?=base_url()?>assets/dist/js/app/activity/add.js"></script>
