<?=$this->extend("layout")?>
    
<?=$this->section("content")?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active"><?= $data['name'] ?></li>
            </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <section class="col-lg-12 connectedSortable">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <?= $data['name'] ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <table id="table-<?= $data['code'] ?>" class="table table-bordered table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <?php 
                                    $fields = json_decode($data['field']);
                                    foreach ($fields as $key => $value) { ?>
                                        <th><?= $value->label ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
<?=$this->endSection()?>

<?=$this->section("script")?>
<script>
    var table;
    var tableId = 'table-<?= $data['code'] ?>';
    var tableFilter = <?= $data['filter'] ?>;
    var urlTable = '/information/get-data?code=<?= $data['code'] ?>';

    $(document).ready(function(){
        table = $('#'+tableId).DataTable({
            paging: true,
            lengthChange: true,
            pageLength: 10,
            searching: false,
            ordering: true,
            order: [[1, 'asc']],
            info: true,
            scrollX: true,
            responsive: false,
            processing: true,
            serverSide: true,
            ajax: urlTable,
            columns: [
                { data: null, defaultContent: "", orderable: false},
                <?php foreach ($fields as $key => $value) { ?>
                    { data: '<?= $value->field ?>' },
                <?php } ?>
            ],
            fnRowCallback: function( nRow, aData, iDisplayIndex) {
                var info = $(this).DataTable().page.info();
                $('td:eq(0)', nRow).html(info.start + iDisplayIndex + 1);
                return nRow;
            }
        });

        filterTable(tableId, tableFilter);
    });
</script>
<?=$this->endSection()?>