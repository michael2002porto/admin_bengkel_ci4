<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
        <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <div class="card-title h4 mb-0 fw-bolder">List of Transactions</div>
            </div>
            <div class="col-auto">
                <button onclick="downloadPDFWithBrowserPrint()">Print</button>
                <button onclick="demoFromHTML()">Download Report PDF</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-stripped table-bordered" id="report">
                <colgroup>
                    <col width="5%">
                    <col width="15%">
                    <col width="15%">
                    <col width="25%">
                    <col width="10%">
                    <col width="20%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <th class="p-1 text-center">#</th>
                    <th class="p-1 text-center">Date/Time</th>
                    <th class="p-1 text-center">Code</th>
                    <th class="p-1 text-center">Customer</th>
                    <th class="p-1 text-center">Items</th>
                    <th class="p-1 text-center">Total Amount</th>
                    <th class="p-1 text-center">Action</th>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $row) : ?>
                        <tr>
                            <th class="p-1 text-center align-middle"><?= $row['id'] ?></th>
                            <td class="px-2 py-1 align-middle"><?= date("Y-m-d h:i A", strtotime($row['created_at'])) ?></td>
                            <td class="px-2 py-1 align-middle"><?= $row['code'] ?></td>
                            <td class="px-2 py-1 align-middle"><?= $row['customer'] ?></td>
                            <td class="px-2 py-1 align-middle text-end"><?= number_format($row['total_items']) ?></td>
                            <td class="px-2 py-1 align-middle text-end"><?= number_format($row['total_amount'], 2) ?></td>
                            <td class="px-2 py-1 align-middle text-center">
                                <a href="<?= base_url('Main/transaction_view/' . $row['id']) ?>" class="mx-2 text-decoration-none text-dark"><i class="fa fa-eye"></i></a>
                                <a href="<?= base_url('Main/transaction_delete/' . $row['id']) ?>" class="mx-2 text-decoration-none text-danger" onclick="if(confirm('Are you sure to delete <?= $row['code'] ?> from list?') !== true) event.preventDefault()"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (count($transactions) <= 0) : ?>
                        <tr>
                            <td class="p-1 text-center" colspan="7">No result found</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
            <div>
                <?= $pager->makeLinks($page, $perPage, $total, 'custom_view') ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.2.4/jspdf.plugin.autotable.min.js"></script>
<script>
    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        const seconds = String(date.getSeconds()).padStart(2, '0');

        const formattedDate = `${year}-${month}-${day} ${hours}-${minutes}-${seconds}`;
        return formattedDate;
    }

    function downloadPDFWithBrowserPrint() {
        window.print();
    }

    function demoFromHTML() {
        var addFooterPages = true;

        var firstColumnWidth = 1.5;

        var doc = new jsPDF({
            orientation: 'portrait',
            unit: 'in',
            format: 'letter'
        });
        doc.setFontSize(14);

        var totalPagesExp = "{total_pages_count_string}";

        doc.text('List of Transactions', 0.5, 0.5);

        // It can parse html:
        doc.autoTable({
            html: '#report',
            useCss: true,
            startY: 0.75,
            rowPageBreak: 'avoid',
            margin: {
                top: 0.5,
                bottom: 0.5,
                left: 0.5,
                right: 0.5
            },
            didDrawPage: (addFooterPages ?
                function(data) {
                    //footer
                    let str = "Page " + doc.internal.getNumberOfPages();

                    if (typeof doc.putTotalPages === 'function') {
                        str = str + " of " + totalPagesExp;
                    }

                    doc.setFontSize(8);
                    let pageSize = doc.internal.pageSize;
                    let pageHeight = pageSize.height ? pageSize.height : pageSize.getHeight();
                    doc.text(str, data.settings.margin.left, pageHeight - 0.35);
                } :
                null)
        });

        if (addFooterPages) {
            if (typeof doc.putTotalPages === 'function') {
                doc.putTotalPages(totalPagesExp);
            }
        }

        doc.save('List of Transactions ' + formatDate(new Date()) + '.pdf');
    }
</script>
<?= $this->endSection() ?>