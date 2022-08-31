<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title">GLOBAL</h1>

    <!-- DataTales Example -->
    <!-- <div class="card shadow mb-4"> -->
    <!-- <div class="card-body"> -->
    <!-- <div class="table-responsive"> -->
    <?php
    
    ?>
    <table class="text-center tb-custom" width="100%" cellspacing="0">
        <thead class="text-tb-head">
            <tr>
                <th>Name</th>
                <th>Level</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($detail as $row) : ?>
                <tr>
                    <td class="tb-column"><?= $row->first_name; ?></td>
                    <td class="tb-column"><?= $row->level_fm == NULL ? '-' : $row->level_fm; ?></td>
                </tr>
            <?php 
            endforeach;
            ?>
        </tbody>
    </table>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->