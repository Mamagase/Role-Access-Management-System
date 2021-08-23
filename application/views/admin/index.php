 <!-- Begin Page Content -->
    <div class="container-fluid"> 

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

        <div class="row">
           <div class="col-lg-10">
               <?= $this->session->flashdata('message'); ?>
               <table class="table table-hover">
                  <thead>
                   <tr> 
                     <th scope="col">#</th>
                     <th scope="col">Full Name</th>
                     <th scope="col">Email Address</th>
                     <th scope="col">Date Created</th>
                     <th scope="col">Action</th>
                   </tr>
                  </thead>
                  <tbody>
                   <?php $i = 1; ?>
                   <?php foreach($users as $u) : ?>  
                   <tr>
                     <th scope="row"><?= $i; ?></th>
                     <td><?= $u['name']; ?></td>
                     <td><?= $u['email']; ?></td>
                     <td><?= date('d F Y', $u['date_created']); ?></td>
                     <td>
                        <a href="<?= base_url('admin/edit/') . $u['id'];?>" class="badge badge-success">edit</a>
                        <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteUserModal">delete</a>
                     </td>
                   </tr>
                   <?php $i++; ?>
                   <?php endforeach; ?>
                  </tbody>
               </table>
           </div>
        </div> 
                   
    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content --> 

<!-- Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('admin/delete/') . $u['id']; ?>" method="post">
         <div class="modal-body">
            <p>Are you sure you want to delete these records?</p>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
           <button type="submit" class="btn btn-danger">Delete</button>
         </div>
      </form>
    </div>
  </div>
</div>