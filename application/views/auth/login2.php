<!doctype html>
<html lang="en">
  <head>
  	<title>Masuk | Performa Mahasiswa</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="<?=base_url()?>login_assets/css/style.css">

	</head>
	<body>
	<section class="ftco-section">
		<div class="container">	
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div style="background: #3c8dbc !important;" class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last">
							<div class="text w-100">
								<h2>Selamat Datang</h2>
								<p>Sistem Informasi Penilaian Performa Mahasiswa</p>
							</div>
			      </div>
						<div class="login-wrap p-4 p-lg-5">
							<div id="infoMessage" class="text-center"><?php echo $message;?></div>
			      	<div class="d-flex">
			      		<div class="w-100">
			      			<h3 class="mb-4">Masuk</h3>
			      		</div>
								
			      	</div>
							<?= form_open("auth/cek_login", array('id'=>'login'));?>
			      		<div class="form-group mb-3">
			      			<label class="label" for="name">Email</label>
			      			<?= form_input($identity);?>
			      		</div>
		            <div class="form-group mb-3">
		            	<label class="label" for="password">Password</label>
		              <?= form_input($password);?>
		            </div>
		            <div class="form-group">
		            	<?= form_submit('submit', lang('login_submit_btn'), array('id'=>'submit', 'style'=>'background-color:#3c8dbc !important;color:white' ,'class'=>'btn  btn-block btn-flat'));?>
		            </div>
		            <!-- <div class="form-group d-md-flex">
		            	<div class="w-50 text-left">
			            	<label class="checkbox-wrap checkbox-primary mb-0">Remember Me
									  <input type="checkbox" checked>
									  <span class="checkmark"></span>
										</label>
									</div>
									<div class="w-50 text-md-right">
										<a href="#">Forgot Password</a>
									</div>
		            </div> -->
		          </form>
		        </div>
		      </div>
				</div>
			</div>
		</div>
	</section>

	<script src="<?=base_url()?>login_assets/js/jquery.min.js"></script>
  <script src="<?=base_url()?>login_assets/js/popper.js"></script>
  <script src="<?=base_url()?>login_assets/js/bootstrap.min.js"></script>
  <script src="<?=base_url()?>login_assets/js/main.js"></script>
  <script type="text/javascript">
		let base_url = '<?=base_url();?>';
	</script>
	<script src="<?=base_url()?>assets/dist/js/app/auth/login.js"></script>
	</body>
</html>

