 <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

        <div class="row">
            <div class="col-lg-8">
                <?= $this->session->flashdata('messageE'); ?>
            </div>
        </div>

        <div class="card mb-3 col-lg-8" style=" max-height: 400px;">
            <div class="row g-0">
                <div class="col-md-4 mt-2 pb-3">
                    <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="img-fluid rounded-start">
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h5 class="card-title"><?= $user['name']; ?></h5>
                        <p class="card-text"><?= $user['email']; ?></p>
                        <p class="card-text"><small class="text-muted"> Member since <?= date('d F Y', $user['date_created']); ?></small></p>
                    </div>
                </div>
            </div>
        </div>                    
    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

