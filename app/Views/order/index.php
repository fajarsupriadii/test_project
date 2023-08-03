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
                <li class="breadcrumb-item active">Orders</li>
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
                            Orders
                        </h3>
                    </div>
                    <div class="card-body">
                        <table id="table-order" class="table table-bordered table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Employee ID</th>
                                    <th>Employee Name</th>
                                    <th>Employee Email</th>
                                    <th>Employee Phone</th>
                                    <th>Office</th>
                                    <th>Order Date</th>
                                    <th>Order Item</th>
                                    <th>Order Amount</th>
                                    <th>Client ID</th>
                                    <th>Client Name</th>
                                    <th>Client Email</th>
                                    <th>Client Phone</th>
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
    var urlTable = '/order/get-data';

    $(document).ready(function(){
        table = $('#table-order').DataTable({
            paging: true,
            lengthChange: true,
            pageLength: 10,
            searching: false,
            ordering: true,
            order: [[6, 'asc']],
            info: true,
            scrollX: true,
            responsive: false,
            processing: true,
            serverSide: true,
            ajax: urlTable,
            columns: [
                { data: null, defaultContent: "", orderable: false},
                { data: 'employee_no' },
                { data: 'employee_name' },
                { data: 'employee_email' },
                { data: 'employee_phone' },
                { data: 'office' },
                { data: 'order_date'},
                { data: 'item' },
                { data: 'amount'},
                { data: 'client_no' },
                { data: 'client_name' },
                { data: 'client_email' },
                { data: 'client_phone' },
            ],
            fnRowCallback: function( nRow, aData, iDisplayIndex) {
                var info = $(this).DataTable().page.info();
                $('td:eq(0)', nRow).html(info.start + iDisplayIndex + 1);
                return nRow;
            }
        });

        filterTable('table-order', [
            {
                fieldName: 'order_date',
                label: 'Order Date',
                type : {
                    name : 'dateRange'
                }
            },
            {
                fieldName: 'employee_no',
                label: 'Employee ID'
            },
            {
                fieldName: 'employee_name',
                label: 'Employee Name'
            },
            {
                fieldName: 'employee_email',
                label: 'Employee Email'
            },
            {
                fieldName: 'employee_phone',
                label: 'Employee Phone'
            },
            {
                fieldName: 'office',
                label: 'Office'
            },
            {
                fieldName: 'item',
                label: 'Item'
            },
            {
                fieldName: 'amount',
                label: 'Amount'
            },
            {
                fieldName: 'client_no',
                label: 'Client ID'
            },
            {
                fieldName: 'client_name',
                label: 'Client Name'
            },
            {
                fieldName: 'client_email',
                label: 'Client Email'
            },
            {
                fieldName: 'client_phone',
                label: 'Client Phone'
            },
        ]);
    });
</script>
<?=$this->endSection()?>