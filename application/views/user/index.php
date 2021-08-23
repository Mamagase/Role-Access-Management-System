 <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

        <div class="row">
           <div class="col-lg-10">

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
                        <a href="" class="badge badge-success">edit</a>
                        <a href="" class="badge badge-danger">delete</a>
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