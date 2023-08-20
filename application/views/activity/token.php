<div class="callout callout-info">
    <h4>Activity</h4>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime minus dolores accusantium fugiat debitis modi voluptates non consequuntur nemo expedita nihil laudantium commodi voluptatum voluptatem molestiae consectetur incidunt animi, qui exercitationem? Nisi illo, magnam perferendis commodi consequuntur impedit, et nihil excepturi quas iste cum sunt debitis odio beatae placeat nemo..</p>
</div>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Konfirmasi Data</h3>
    </div>
    <div class="box-body">
        <span id="id_activity" data-key="<?=$encrypted_id?>"></span>
        <div class="row">
            <div class="col-sm-6">
                <table class="table table-bordered">
                    <tr>
                        <th>Nama</th>
                        <td><?=$mhs->nama?></td>
                    </tr>
                    <tr>
                        <th>Dosen</th>
                        <td><?=$activity->nama_dosen?></td>
                    </tr>
                    <tr>
                        <th>Kelas/Jurusan</th>
                        <td><?=$mhs->nama_kelas?> / <?=$mhs->nama_jurusan?></td>
                    </tr>
                    <tr>
                        <th>Nama activity</th>
                        <td><?=$activity->nama_activity?></td>
                    </tr>
                    <tr>
                        <th>Waktu</th>
                        <td><?=$activity->waktu?> Menit</td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-6">
                <div class="box box-solid">
                    <div class="box-body pb-0">
                        <div class="callout callout-info">
                            <p>
                                Waktu boleh mengerjakan activity adalah saat tombol "MULAI" berwarna hijau.
                            </p>
                        </div>
                        <?php
                        $mulai = strtotime($activity->tgl);
                        $now = time();
                        if($mulai > $now) : 
                        ?>
                        <div class="callout callout-success">
                            <strong><i class="fa fa-clock-o"></i> activity akan dimulai pada</strong>
                            <br>
                            <span class="countdown" data-time="<?=date('Y-m-d H:i:s', strtotime($activity->tgl))?>">00 Hari, 00 Jam, 00 Menit, 00 Detik</strong><br/>
                        </div>
                        <?php else : ?>
                        <button id="btncek" data-id="<?=$activity->id_activity?>" class="btn btn-success btn-lg mb-4">
                            <i class="fa fa-pencil"></i> Mulai
                        </button>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?=base_url()?>assets/dist/js/app/activity/token.js"></script>