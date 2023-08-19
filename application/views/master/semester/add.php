<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Form <?=$judul?></h3>
        <div class="box-tools pull-right">
            <a href="<?=base_url('semester')?>" class="btn btn-sm btn-flat btn-warning">
                <i class="fa fa-arrow-left"></i> Batal
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <?=form_open('semester/save', array('id'=>'semester'), array('method'=>'add'))?>
                    <div class="form-group">
                        <label for="dari">Dari Bulan</label>
                        <select name="dari" class="form-control select2">
                            <option value="">-- Pilih --</option>
                            <option >Januari</option>
                            <option >Februari</option>
                            <option >Maret</option>
                            <option >April</option>
                            <option >Mei</option>
                            <option >Juni</option>
                            <option >Juli</option>
                            <option >Agustus</option>
                            <option >September</option>
                            <option >Oktober</option>
                            <option >November</option>
                            <option >Desember</option>
                        </select>
                        <small class="help-block"></small>
                    </div>

                    <div class="form-group">
                        <label for="ke">ke Bulan</label>
                        <select name="ke" class="form-control select2">
                            <option value="">-- Pilih --</option>
                            <option >Januari</option>
                            <option >Februari</option>
                            <option >Maret</option>
                            <option >April</option>
                            <option >Mei</option>
                            <option >Juni</option>
                            <option >Juli</option>
                            <option >Agustus</option>
                            <option >September</option>
                            <option >Oktober</option>
                            <option >November</option>
                            <option >Desember</option>
                        </select>
                        <small class="help-block"></small>
                    </div>
                    
                    <div class="form-group">
                        <label for="semester">Genap/Ganjil</label>
                        <select name="semester" class="form-control select2">
                            <option value="">-- Pilih --</option>
                            <option >Genap</option>
                            <option >Ganjil</option>
                        </select>
                        <small class="help-block"></small>
                    </div>
                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <input placeholder="Tahun" type="text" name="tahun" class="form-control">
                        <small class="help-block"></small>
                    </div>
                    <div class="form-group pull-right">
                        <button type="reset" class="btn btn-flat btn-default"><i class="fa fa-rotate-left"></i> Reset</button>
                        <button type="submit" id="submit" class="btn btn-flat bg-purple"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                <?=form_close()?>
            </div>
        </div>
    </div>
</div>

<script src="<?=base_url()?>assets/dist/js/app/master/semester/add.js"></script>