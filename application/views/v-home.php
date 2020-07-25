<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pupuk Web Master</title>

    <!-- CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>


    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/form-elements.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="assets/ico/favicon.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
</head>

<body>
    <!-- Top content -->
    <div class="top-content">

        <div class="inner-bg">
            <div class="container">
                <!-- <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>Bootstrap</strong> Login Form</h1>
                            <div class="description">
                                <p>
                                    This is a free responsive login form made with Bootstrap. 
                                    Download it on <a href="http://azmind.com"><strong>AZMIND</strong></a>, customize and use it as you like!
                                </p>
                            </div>
                        </div>
                    </div> -->
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3 form-box">
                        <div class="form-top">
                            <div class="form-top-center" color="white">
                                <h3 color="white">Admin</h3>
                                <!-- <p>Enter your username and password to log on:</p> -->
                            </div>
                            <!-- <div class="form-top-right">
                                    <i class="fa fa-key"></i>
                                </div> -->
                        </div>
                        <div class="form-bottom">
                            <?php echo form_open(base_url().'tambah'); ?>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="luas">Luas Lahan</label>
                                    <div class="col-md-9">
                                        <input type="text" name="luas" class="form-control input-md" value="<?= $luas; ?>" id="luas" readonly>
                                        <span>&nbsp;</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="urea">Urea</label>
                                    <div class="col-md-9">
                                        <input type="text" name="urea" placeholder="Urea" class="form-control input-md" id="urea"
                                        max="<?= $urea; ?>" min="0">
                                        <span>&nbsp;</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="sp36">Sp36</label>
                                    <div class="col-md-9">
                                        <input type="text" name="sp36" placeholder="Sp36" class="form-control input-md" id="sp36"
                                        max="<?= $sp36; ?>" min="0">
                                        <span>&nbsp;</span>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="za">Za</label>
                                    <div class="col-md-9">
                                        <input type="text" name="za" placeholder="Za" class="form-control input-md" id="za"
                                        max="<?= $za; ?>" min="0">
                                        <span>&nbsp;</span>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="npk">Npk</label>
                                    <div class="col-md-9">
                                        <input type="text" name="npk" placeholder="Npk" class="form-control input-md" id="npk"
                                        max="<?= $npk; ?>" min="0">
                                        <span>&nbsp;</span>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="organik">Organik</label>
                                    <div class="col-md-9">
                                        <input type="text" name="organik" placeholder="Organik" class="form-control input-md" id="organik"
                                        max="<?= $organik; ?>" min="0">
                                        <span>&nbsp;</span>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-link-1 btn-link-1-facebook">Tambah</button>

                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- Javascript -->
    <script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.2.6/jquery.inputmask.bundle.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.backstretch.min.js"></script>
    <script src="assets/js/scripts.js"></script>

    <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->
    <script>
        // jQuery(function($){
        //     $("#sp36").inputmask({
        //         mask: "99[.99]",
        //         greedy: false,
        //         numericInput: true,
        //         placeholder: '',
        //         definitions: {
        //         '*': {
        //             validator: "[0-9]"
        //         }
        //         }
        //     });
        // });
    </script>

    <script>
        $(function() {
            $("#urea").change(function() {
                var value = parseFloat(this.value);
                var max = parseFloat(this.max);
                var min = parseFloat(this.min);

                if (value > max) {
                    this.value = max;
                    console.log(max)
                } else if (value < min) {
                    this.value = min
                }
            });
            $("#sp36").change(function() {
                var value = parseFloat(this.value);
                var max = parseFloat(this.max);
                var min = parseFloat(this.min);

                if (value > max) {
                    this.value = max;
                    console.log(max)
                } else if (value < min) {
                    this.value = min
                }
            });
            $("#za").change(function() {
                var value = parseFloat(this.value);
                var max = parseFloat(this.max);
                var min = parseFloat(this.min);

                if (value > max) {
                    this.value = max;
                    console.log(max)
                } else if (value < min) {
                    this.value = min
                }
            });
            $("#npk").change(function() {
                var value = parseFloat(this.value);
                var max = parseFloat(this.max);
                var min = parseFloat(this.min);

                if (value > max) {
                    this.value = max;
                    console.log(max)
                } else if (value < min) {
                    this.value = min
                }
            });
            $("#organik").change(function() {
                var value = parseFloat(this.value);
                var max = parseFloat(this.max);
                var min = parseFloat(this.min);

                if (value > max) {
                    this.value = max;
                    console.log(max)
                } else if (value < min) {
                    this.value = min
                }
            });
        });
    </script>

</body>

</html>