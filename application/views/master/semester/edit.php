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
                <?=form_open('semester/save', array('id'=>'semester'), array('method'=>'edit', 'id'=>$semester->id))?>
                    
                  
                    <div class="form-group">
                        <label for="dari">Dari Bulan</label>
                        <select name="dari" class="form-control select2">
                            <option value="">-- Pilih --</option>
                            <option <?=$semester->dari === "Januari" ? "selected" : "" ?> >Januari</option>
                            <option <?=$semester->dari === "Februari" ? "selected" : "" ?> >Februari</option>
                            <option <?=$semester->dari === "Maret" ? "selected" : "" ?> >Maret</option>
                            <option <?=$semester->dari === "April" ? "selected" : "" ?> >April</option>
                            <option <?=$semester->dari === "Mei" ? "selected" : "" ?> >Mei</option>
                            <option <?=$semester->dari === "Juni" ? "selected" : "" ?> >Juni</option>
                            <option <?=$semester->dari === "Juli" ? "selected" : "" ?> >Juli</option>
                            <option <?=$semester->dari === "Agustus" ? "selected" : "" ?> >Agustus</option>
                            <option <?=$semester->dari === "September" ? "selected" : "" ?> >September</option>
                            <option <?=$semester->dari === "Oktober" ? "selected" : "" ?> >Oktober</option>
                            <option <?=$semester->dari === "November" ? "selected" : "" ?> >November</option>
                            <option <?=$semester->dari === "Desember" ? "selected" : "" ?> >Desember</option>
                        </select>
                        <small class="help-block"></small>
                    </div>
                    <div class="form-group">
                        <label for="ke">Ke Bulan</label>
                        <select name="ke" class="form-control select2">
                            <option value="">-- Pilih --</option>
                            <option <?=$semester->ke === "Januari" ? "selected" : "" ?> >Januari</option>
                            <option <?=$semester->ke === "Februari" ? "selected" : "" ?> >Februari</option>
                            <option <?=$semester->ke === "Maret" ? "selected" : "" ?> >Maret</option>
                            <option <?=$semester->ke === "April" ? "selected" : "" ?> >April</option>
                            <option <?=$semester->ke === "Mei" ? "selected" : "" ?> >Mei</option>
                            <option <?=$semester->ke === "Juni" ? "selected" : "" ?> >Juni</option>
                            <option <?=$semester->ke === "Juli" ? "selected" : "" ?> >Juli</option>
                            <option <?=$semester->ke === "Agustus" ? "selected" : "" ?> >Agustus</option>
                            <option <?=$semester->ke === "September" ? "selected" : "" ?> >September</option>
                            <option <?=$semester->ke === "Oktober" ? "selected" : "" ?> >Oktober</option>
                            <option <?=$semester->ke === "November" ? "selected" : "" ?> >November</option>
                            <option <?=$semester->ke === "Desember" ? "selected" : "" ?> >Desember</option>
                        </select>
                        <small class="help-block"></small>
                    </div>
                    <div class="form-group">
                        <label for="semester">Jenis Kelamin</label>
                        <select name="semester" class="form-control select2">
                            <option value="">-- Pilih --</option>
                            <option <?=$semester->semester === "Genap" ? "selected" : "" ?>>Genap</option>
                            <option <?=$semester->semester === "Ganjil" ? "selected" : "" ?>>Ganjil</option>
                        </select>
                        <small class="help-block"></small>
                    </div>
                   
                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <input value="<?=$semester->tahun?>" placeholder="Tahun" type="text" name="tahun" class="form-control">
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

<script src="<?=base_url()?>assets/dist/js/app/master/semester/edit.js"></script>